<?php
require_once __DIR__ . '/../models/RegisterModel.php';
require_once __DIR__ . '/../views/RegisterView.php';

class RegisterController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new RegisterModel();
        $this->view = new RegisterView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>