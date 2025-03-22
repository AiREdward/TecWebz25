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
            $data = $this->model->getData();
            $this->view->render($data);
        }
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
            $data = $this->model->getData();
            $data['error'] = 'Si è verificato un errore durante il pagamento: ' . $result['error'];
            $this->view->render($data);
        }
    }
}
?>