<?php
require_once __DIR__ . '/../models/ShopModel.php';
require_once __DIR__ . '/../views/ShopView.php';

class ShopController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ShopModel();
        $this->view = new ShopView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>