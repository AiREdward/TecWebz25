<?php
require_once __DIR__ . '/../models/TradeModel.php';
require_once __DIR__ . '/../views/TradeView.php';

class TradeController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new TradeModel();
        $this->view = new TradeView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Permuta', 'url' => 'index.php?page=trade']
        ];
        $this->view->render($data);
    }

    public function getRating($type, $conditions, $brand) {
        $this->model->calcRating($type, $conditions, $brand);
    }
        
}

?>