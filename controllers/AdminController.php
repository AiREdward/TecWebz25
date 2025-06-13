<?php

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=auth&action=login");
    exit();
}

require_once 'models/User.php';
require_once __DIR__ . '/../models/AdminModel.php';

class AdminController {
    private $model;
    
    public function __construct() {
        $this->model = new AdminModel();
    }
    
    public function invoke() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        
        switch ($action) {
            case 'add_product':
                $this->addProduct();
                break;
            case 'search_products':
                $this->searchProducts();
                break;
            case 'update_product':
                $this->updateProduct();
                break;
            case 'delete_products':
                $this->deleteProducts();
                break;
            case 'get_statistics':
                $this->getStatistics();
                break;
            case 'search_users':
                $this->searchUsers();
                break;
            case 'get_user_details':
                $this->getUserDetails();
                break;
            case 'update_user':
                $this->updateUser();
                break;
            case 'delete_user':
                $this->deleteUser();
                break;
            default:
                $this->listUsers();
                break;
        }
    }
    
    public function updateProduct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $id = $_POST['id'] ?? 0;
            $nome = $_POST['nome'] ?? '';
            $prezzo = $_POST['prezzo'] ?? 0;
            $prezzo_ritiro_usato = $_POST['prezzo_ritiro_usato'] ?? 0;
            $genere = $_POST['genere'] ?? '';
            $descrizione = $_POST['descrizione'] ?? '';
            $currentImage = $_POST['current_image'] ?? '';
            
            // Handle image upload
            $immagine = '';
            if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
                // Determine the appropriate directory based on genre
                if ($genere === 'piattaforma') {
                    $uploadDir = 'assets/img/products_images/console/';
                } elseif ($genere === 'carta regalo') {
                    $uploadDir = 'assets/img/products_images/gift/';
                } else {
                    $uploadDir = 'assets/img/products_images/games/';
                }
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate a unique filename
                $filename = basename($_FILES['immagine']['name']);
                $filename = str_replace(' ', '_', $filename);
                $uploadFile = $uploadDir . $filename;
                
                // Sposta il file caricato nella directory di destinazione
                if (move_uploaded_file($_FILES['immagine']['tmp_name'], $uploadFile)) {
                    $immagine = $uploadFile;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Impossibile caricare l\'immagine']);
                    exit;
                }
            }
            
            if (empty($immagine)) {
                $immagine = '';
            }
            
            // Sanitizzazione dei dati prima dell'inserimento
            $nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
            $descrizione = htmlspecialchars($descrizione, ENT_QUOTES, 'UTF-8');
            
            $result = $this->model->updateProduct($id, $nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione);
            
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile aggiornare il prodotto']);
            }
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }


    public function searchProducts() {
        // Get search query from GET parameter
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        
        // Get products from the model
        $products = $this->model->searchProducts($query);
        
        $result = [];
        foreach ($products as $product) {

            $imagePath = str_replace('\\', '/', $product['immagine']);
            $result[] = [
                'id' => $product['id'],
                'name' => $product['nome'],
                'price' => $product['prezzo'],
                'tradePrice' => $product['prezzo_ritiro_usato'],
                'genre' => $product['genere'],
                'image' => $imagePath,
                'description' => $product['descrizione']
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
    
    public function searchUsers() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = trim($_GET['query']);
            
            // Validazione query di ricerca utenti
            if (strlen($query) > 100) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Query di ricerca troppo lunga']);
                exit;
            }
            
            // Sanitizzazione della query
            $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
            $users = $this->model->searchUsers($query);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'users' => $users]);
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Richiesta non valida']);
        exit;
    }
    
    public function listUsers() {
        $users = $this->model->getUsers();
        $statistics = $this->model->getStatistics();

        include 'views/AdminView.php';
    }
    
    public function getStatistics() {
        $statistics = $this->model->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($statistics);
        exit;
    }
    
    public function addProduct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $nome = $_POST['nome'] ?? '';
            $prezzo = $_POST['prezzo'] ?? 0;
            $prezzo_ritiro_usato = $_POST['prezzo_ritiro_usato'] ?? 0;
            $genere = $_POST['genere'] ?? '';
            $descrizione = $_POST['descrizione'] ?? '';
            
            // Gestione caricamento immagine
            $immagine = '';
            if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
                // Determina la directory appropriata in base al genere
                if ($genere === 'piattaforma') {
                    $uploadDir = 'assets/img/products_images/console/';
                } else if ($genere === 'carta regalo') {
                    $uploadDir = 'assets/img/products_images/cards/';
                } else {
                    $uploadDir = 'assets/img/products_images/games/';
                }
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate unique filename
                $fileName = uniqid() . '_' . basename($_FILES['immagine']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['immagine']['tmp_name'], $uploadFile)) {
                    $immagine = $uploadFile;
                }
            }
            
            // Validate data
            $errors = [];
            if (empty($nome)) $errors[] = 'Il titolo del gioco è obbligatorio';
            if (empty($prezzo) || !is_numeric($prezzo)) $errors[] = 'Il prezzo deve essere un numero valido';
            if (!is_numeric($prezzo_ritiro_usato)) $errors[] = 'Il prezzo di ritiro usato deve essere un numero valido';
            if (empty($genere)) $errors[] = 'Il genere è obbligatorio';
            if (empty($descrizione)) $errors[] = 'La descrizione è obbligatoria';
            if (empty($immagine)) $errors[] = 'L\'immagine è obbligatoria';
            
            // If there are no errors, add the product
            if (empty($errors)) {
                $result = $this->model->addProduct($nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione);
                
                // Return JSON response
                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiunta del prodotto']);
                }
            } else {
                // Return errors
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
            }
            exit;
        }
    }
    
    public function deleteProducts() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            // Validazione dei dati JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Dati JSON non validi']);
                exit;
            }
            
            if (isset($data['ids']) && is_array($data['ids']) && !empty($data['ids'])) {
                // Delete products from the database
                $result = $this->model->deleteProducts($data['ids']);
                
                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Impossibile eliminare i prodotti']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Nessun ID prodotto fornito']);
            }
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    public function deleteUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            
            if ($id <= 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID utente non valido']);
                exit;
            }
            
            // Elimina l'utente dal database
            $result = $this->model->deleteUser($id);
            
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile eliminare l\'utente']);
            }
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    public function updateUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ottieni i dati dal form
            $id = $_POST['id'] ?? 0;
            $ruolo = $_POST['ruolo'] ?? '';
            $stato = $_POST['stato'] ?? '';
            
            // Aggiorna l'utente nel database
            $result = $this->model->updateUser($id, $ruolo, $stato);
            
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile aggiornare l\'utente']);
            }
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    // Aggiunge il metodo per ottenere i dettagli di un utente
    public function getUserDetails() {
        if (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            
            // Validazione ID utente
            if ($userId <= 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID utente non valido']);
                exit;
            }
            
            $user = $this->model->getUserById($userId);
            
            header('Content-Type: application/json');
            if ($user) {
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Utente non trovato']);
            }
            exit;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'ID utente non specificato']);
        exit;
    }
}
?>
