<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../views/AdminView.php';

class AdminController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new AdminModel();
        $this->view = new AdminView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>