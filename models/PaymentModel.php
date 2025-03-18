<?php
require_once __DIR__ . '/../config/db_config.php';

class PaymentModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    public function getData() {
        if (isset($_SESSION['cartData'])) {
            $cartData = json_decode($_SESSION['cartData'], true);
            $cartItems = $cartData['items'];
            $total = $cartData['total'];
        } else {
            $cartItems = [];
            $total = 0;

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const cartData = sessionStorage.getItem('cartData');
                    if (cartData) {
                        // Invia i dati al server tramite AJAX
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'index.php?page=payment', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Ricarica la pagina per mostrare i dati aggiornati
                                location.reload();
                            }
                        };
                        xhr.send('cartData=' + encodeURIComponent(cartData));
                    }
                });
            </script>";
            
            if (isset($_POST['cartData'])) {
                $cartData = json_decode($_POST['cartData'], true);
                $_SESSION['cartData'] = $_POST['cartData'];
                $cartItems = $cartData['items'];
                $total = $cartData['total'];
            }
        }
        
        return [
            'title' => 'Pagamento',
            'header' => 'Completa il tuo acquisto',
            'cartItems' => $cartItems,
            'total' => $total
        ];
    }
    
    public function processPayment($paymentData) {
        try {
            $this->pdo->beginTransaction();
            
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 
            
            $cartData = json_decode($_SESSION['cartData'], true);
            $cartItems = $cartData['items'];
            $total = $cartData['total'];
            
            $stmtOrder = $this->pdo->prepare("INSERT INTO ordini (utente_id, totale, stato) VALUES (?, ?, ?)");
            $stmtOrder->execute([$userId, $total, 'in attesa']);
            
            $orderId = $this->pdo->lastInsertId();
            
            $stmtItems = $this->pdo->prepare("INSERT INTO ordine_prodotti (ordine_id, prodotto_id, quantita, prezzo_unitario) VALUES (?, ?, ?, ?)");
            
            foreach ($cartItems as $item) {
                $stmtItems->execute([
                    $orderId,
                    $item['id'],
                    $item['quantity'],
                    $item['prezzo']
                ]);
            }
            
            $stmtPayment = $this->pdo->prepare("INSERT INTO pagamenti (ordine_id, intestatario, numero_carta, data_scadenza, cvv, stato) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtPayment->execute([
                $orderId,
                $paymentData['card-holder'],
                $paymentData['card-number'],
                $paymentData['expiry-date'],
                $paymentData['cvv'],
                'completato' 
            ]);
            
            $stmtUpdateOrder = $this->pdo->prepare("UPDATE ordini SET stato = ? WHERE id = ?");
            $stmtUpdateOrder->execute(['completato', $orderId]);
            
            $this->pdo->commit();
            
            unset($_SESSION['cartData']);
            
            return ['success' => true, 'order_id' => $orderId];
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>