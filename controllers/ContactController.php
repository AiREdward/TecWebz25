<?php
require_once __DIR__ . '/../models/ContactModel.php';
require_once __DIR__ . '/../views/ContactView.php';

class ContactController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ContactModel();
        $this->view = new ContactView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>