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
            header('Cache-Control: private, max-age=10');
            
            $products = $this->model->searchProducts($searchTerm);
            
            // Inverti l'ordine dei prodotti per mantenere la coerenza
            $products = array_reverse($products);
            
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
            exit;
        }
        
        // Gestione del redirect al pagamento
        if ((isset($_GET['action']) && $_GET['action'] === 'checkout') || (isset($_POST) && !empty($_POST) && strpos($_SERVER['REQUEST_URI'], 'action=checkout') !== false)) {

            if (!isset($_SESSION['user'])) {
                // Se non è loggato, salva i dati del carrello nella sessione prima del reindirizzamento
                if (isset($_POST['cartData'])) {
                    $_SESSION['cartData'] = $_POST['cartData'];
                }

                setPopupMessage("Per procedere all'acquisto è necessario effettuare il login", "info");
                // Salva l'URL di redirect per dopo il login
                $_SESSION['redirect_after_login'] = 'index.php?page=payment';
                header('Location: index.php?page=auth&action=login');
                exit;
            } else {
                // Se è loggato, procedi direttamente al pagamento
                if (isset($_POST['cartData'])) {
                    $_SESSION['cartData'] = $_POST['cartData'];
                }
                header('Location: index.php?page=payment');
                exit;
            }
        }
        
        // Visualizzazione normale della pagina
        $data = $this->model->getData();
        
        // Definizione del breadcrumb
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Negozio', 'url' => 'index.php?page=shop']
        ];
        
        $this->view->render($data);
    }
}
?>