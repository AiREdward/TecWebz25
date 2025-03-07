<?php
require_once __DIR__ . '/../models/RentalModel.php';
require_once __DIR__ . '/../views/RentalView.php';

class RentalController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new RentalModel();
        $this->view = new RentalView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>