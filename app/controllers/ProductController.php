<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../views/ProductView.php';

class ProductController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ProductModel();
        $this->view = new ProductView();
    }

    public function invoke() {
        $productId = $_GET['id'] ?? null;
        $data = $this->model->getProduct($productId);
        $this->view->render($data);
    }
}
?>