<?php
require_once __DIR__ . '/../models/LoginModel.php';
require_once __DIR__ . '/../views/LoginView.php';

class LoginController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new LoginModel();
        $this->view = new LoginView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>