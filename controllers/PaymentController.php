<?php
require_once __DIR__ . '/../models/PaymentModel.php';
require_once __DIR__ . '/../views/PaymentView.php';

class PaymentController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PaymentModel();
        $this->view = new PaymentView();
    }

    public function invoke() {
        if (isset($_GET['action']) && $_GET['action'] === 'process') {
            $this->processPayment();
        } else {
            $data = $this->getCartData();
            $this->view->render($data);
        }
    }
    
    private function getCartData() {
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
                        try {
                            const parsedCartData = JSON.parse(cartData);
                            if (parsedCartData && parsedCartData.items && parsedCartData.items.length > 0) {
                                const cartItems = parsedCartData.items;
                                // Use the total from parsedCartData if available, otherwise calculate it
                                let total = parsedCartData.total || 0;
                                if (!total) {
                                    cartItems.forEach(item => {
                                        total += item.prezzo * item.quantity;
                                    });
                                }
                                
                                const cartDataObj = {
                                    items: cartItems,
                                    total: total
                                };
                                
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
                                xhr.send('cartData=' + encodeURIComponent(JSON.stringify(cartDataObj)));
                            }
                        } catch (e) {
                            console.error('Errore nel parsing dei dati del carrello:', e);
                        }
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
    
    private function processPayment() {
        if (!isset($_SESSION['cartData'])) {
            header('Location: index.php?page=shop');
            exit;
        }
        
        $paymentData = [
            'card-holder' => $_POST['card-holder'],
            'card-number' => $_POST['card-number'],
            'expiry-date' => $_POST['expiry-date'],
            'cvv' => $_POST['cvv']
        ];
        
        $result = $this->model->processPayment($paymentData);
        
        if ($result['success']) {
            $data = [
                'title' => 'Pagamento Completato',
                'header' => 'Grazie per il tuo acquisto!',
                'message' => 'Il tuo ordine #' . $result['order_id'] . ' è stato completato con successo.',
                'order_id' => $result['order_id']
            ];
            $this->view->renderSuccess($data);
        } else {
            $data = $this->getCartData();
            $data['error'] = 'Si è verificato un errore durante il pagamento: ' . $result['error'];
            $this->view->render($data);
        }
    }
}
?>