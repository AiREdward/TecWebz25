<?php
require_once __DIR__ . '/../models/HomeModel.php';
require_once __DIR__ . '/../views/HomeView.php';

class HomeController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new HomeModel();
        $this->view = new HomeView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home']
        ];
        $this->view->render($data);
    }
}
?>