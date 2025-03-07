<?php
require_once __DIR__ . '/../models/PrintModel.php';
require_once __DIR__ . '/../views/PrintView.php';

class PrintController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PrintModel();
        $this->view = new PrintView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>