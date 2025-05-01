<?php
require_once __DIR__ . '/../models/ShopModel.php';
require_once __DIR__ . '/../views/ShopView.php';
require_once __DIR__ . '/../controllers/includes/popupController.php';

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
        
        // Gestione del redirect al pagamento
        if (isset($_GET['action']) && $_GET['action'] === 'checkout') {
            // Controlla se l'utente è loggato
            if (!isset($_SESSION['user'])) {
                // Se non è loggato, imposta un messaggio e reindirizza al login
                setPopupMessage("Per procedere all'acquisto è necessario effettuare il login", "info");
                // Salva l'URL di redirect per dopo il login
                $_SESSION['redirect_after_login'] = 'index.php?page=payment';
                header('Location: index.php?page=auth&action=login');
                exit;
            } else {
                // Se è loggato, procedi al pagamento
                header('Location: index.php?page=payment');
                exit;
            }
        }
        
        // Visualizzazione normale della pagina
        $data = $this->model->getData();
        $this->view->render($data);
    }
}
?>