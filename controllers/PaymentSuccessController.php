<?php

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=auth&action=login");
    exit();
}

require_once __DIR__ . '/../models/PaymentSuccessModel.php';
require_once __DIR__ . '/../views/PaymentSuccessView.php';

class PaymentSuccessController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PaymentSuccessModel();
        $this->view = new PaymentSuccessView();
    }

    public function invoke() {
        if (!isset($_GET['order_id'])) {
            header('Location: index.php?page=shop');
            exit;
        }

        $orderId = $_GET['order_id'];
        $data = $this->model->getSuccessData($orderId);
        
        // Definizione del breadcrumb (spostato dalla vista al controller)
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Negozio', 'url' => 'index.php?page=shop'],
            ['name' => 'Pagamento', 'url' => 'index.php?page=payment'],
            ['name' => 'Pagamento completato', 'url' => 'index.php?page=payment_success&order_id=' . $orderId]
        ];
        
        $this->view->render($data);
    }
}
?>
