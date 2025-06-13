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
            $searchTerm = isset($_GET['term']) ? trim($_GET['term']) : '';
            
            // Validazione del termine di ricerca
            if (strlen($searchTerm) > 100) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Termine di ricerca troppo lungo', 'products' => []]);
                exit;
            }
            
            // Sanitizzazione del termine di ricerca
            $searchTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
            
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
        if ((isset($_GET['action']) && $_GET['action'] === 'checkout') || (isset($_POST) && !empty($_POST) && strpos($_SERVER['REQUEST_URI'], 'action=checkout') !== false)) {
            // Validazione dei dati del carrello se presenti
            if (isset($_POST['cartData'])) {
                $cartData = json_decode($_POST['cartData'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    setPopupMessage("Dati del carrello non validi", "error");
                    header('Location: index.php?page=shop');
                    exit;
                }
                
                // Validazione degli elementi del carrello
                if (!isset($cartData['items']) || !is_array($cartData['items']) || empty($cartData['items'])) {
                    setPopupMessage("Il carrello è vuoto", "error");
                    header('Location: index.php?page=shop');
                    exit;
                }
                
                // Validazione di ogni elemento del carrello
                foreach ($cartData['items'] as $item) {
                    if (!isset($item['id'], $item['quantity'], $item['prezzo']) ||
                        !is_numeric($item['id']) || $item['id'] <= 0 ||
                        !is_numeric($item['quantity']) || $item['quantity'] <= 0 ||
                        !is_numeric($item['prezzo']) || $item['prezzo'] <= 0) {
                        setPopupMessage("Dati del carrello non validi", "error");
                        header('Location: index.php?page=shop');
                        exit;
                    }
                }
            }
            
            // Controlla se l'utente è loggato
            if (!isset($_SESSION['user'])) {
                // Se non è loggato, salva i dati del carrello nella sessione prima del reindirizzamento
                if (isset($_POST['cartData'])) {
                    $_SESSION['cartData'] = $_POST['cartData'];
                }
                // Imposta un messaggio e reindirizza al login
                setPopupMessage("Per procedere all'acquisto è necessario effettuare il login", "info");
                // Salva l'URL di redirect per dopo il login
                $_SESSION['redirect_after_login'] = 'index.php?page=payment';
                header('Location: index.php?page=auth&action=login');
                exit;
            } else {
                // Se è loggato, procedi direttamente al pagamento
                // Assicuriamoci che i dati del carrello vengano passati correttamente
                if (isset($_POST['cartData'])) {
                    $_SESSION['cartData'] = $_POST['cartData'];
                }
                header('Location: index.php?page=payment');
                exit;
            }
        }
        
        // Visualizzazione normale della pagina
        $data = $this->model->getData();
        
        // Definizione del breadcrumb (spostato dalla vista al controller)
        $data['breadcrumb'] = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Negozio', 'url' => 'index.php?page=shop']
        ];
        
        $this->view->render($data);
    }
}
?>