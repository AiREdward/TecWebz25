<?php
require_once __DIR__ . '/../models/TournamentModel.php';
require_once __DIR__ . '/../views/TournamentView.php';

class TournamentController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new TournamentModel();
        $this->view = new TournamentView();
    }

    public function invoke() {
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>