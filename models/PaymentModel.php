<?php
require_once __DIR__ . '/../config/db_config.php';

class PaymentModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
    }
    
    // Il metodo getData è stato rimosso poiché la logica della sessione è stata spostata nel controller
    
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