<?php
require_once __DIR__ . '/../models/ShopModel.php';
require_once __DIR__ . '/../views/ShopView.php';

class ShopController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ShopModel();
        $this->view = new ShopView();
    }

    public function invoke() {
        // Gestione della ricerca tramite AJAX
        if (isset($_GET['action']) && $_GET['action'] === 'search') {
            $searchTerm = isset($_GET['term']) ? $_GET['term'] : '';
            
            // Utilizziamo la cache del browser per le richieste ripetute
            header('Cache-Control: private, max-age=10'); // Cache di 10 secondi
            
            $products = $this->model->searchProducts($searchTerm);
            
            // Inverti l'ordine dei prodotti per mantenere la coerenza con la vista originale
            $products = array_reverse($products);
            
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
            exit;
        }
        
        // Visualizzazione normale della pagina
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>