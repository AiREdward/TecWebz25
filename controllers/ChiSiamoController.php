<?php
require_once __DIR__ . '/../models/ChiSiamoModel.php';
require_once __DIR__ . '/../views/ChiSiamoView.php';

class ChiSiamoController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ChiSiamoModel();
        $this->view = new ChiSiamoView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Chi Siamo', 'url' => 'index.php?page=chi-siamo']
        ];
        $this->view->render($data);
    }
}
?>