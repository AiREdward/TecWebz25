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
        $cartItems = [];
        $total = 0;

        // Controlla prima i dati POST dal form
        if (isset($_POST['cartData'])) {
            $cartData = json_decode($_POST['cartData'], true);
            if ($cartData && isset($cartData['items']) && isset($cartData['total'])) {
                $_SESSION['cartData'] = $_POST['cartData'];
                $cartItems = $cartData['items'];
                $total = $cartData['total'];
            }
        }
        // Se non ci sono dati POST, controlla la sessione
        else if (isset($_SESSION['cartData'])) {
            $cartData = json_decode($_SESSION['cartData'], true);
            if ($cartData && isset($cartData['items']) && isset($cartData['total'])) {
                $cartItems = $cartData['items'];
                $total = $cartData['total'];
            }
        }

        // Se il carrello è vuoto, reindirizza allo shop
        if (empty($cartItems)) {
            header('Location: index.php?page=shop');
            exit;
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