<?php
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
        $this->view->render($data);
    }
}
?>
