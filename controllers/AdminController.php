<?php
require_once 'models/User.php';
require_once __DIR__ . '/../models/AdminModel.php';
// require_once __DIR__ . '/../views/AdminView.php';

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
    
    // Aggiorna un prodotto
    public function updateProduct() {
        // Check if the request is POST
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
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate a unique filename
                $filename = basename($_FILES['immagine']['name']);
                $filename = str_replace(' ', '_', $filename); // Replace spaces with underscores
                $uploadFile = $uploadDir . $filename;
                
                // Move the uploaded file to the destination directory
                if (move_uploaded_file($_FILES['immagine']['tmp_name'], $uploadFile)) {
                    $immagine = $uploadFile;
                } else {
                    // Return error response
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Impossibile caricare l\'immagine']);
                    exit;
                }
            }
            
            // If no new image was uploaded, keep the current one
            if (empty($immagine)) {
                $immagine = '';
            }
            
            // Update product in the database
            $result = $this->model->updateProduct($id, $nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione);
            
            // Return JSON response
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile aggiornare il prodotto']);
            }
            exit;
        }
        
        // If not POST request, return error
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }

    // Add this new method
    public function searchProducts() {
        // Get search query from GET parameter
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        
        // Get products from the model
        $products = $this->model->searchProducts($query);
        
        // Convert to format expected by JavaScript
        $result = [];
        foreach ($products as $product) {
            // Convert backslashes to forward slashes for web URLs
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
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
    
    public function searchUsers() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = $_GET['query'];
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

        // Passa i dati alla vista
        include 'views/AdminView.php';
    }
    
    public function getStatistics() {
        $statistics = $this->model->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($statistics);
        exit;
    }
    
    public function addProduct() {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $nome = $_POST['nome'] ?? '';
            $prezzo = $_POST['prezzo'] ?? 0;
            $prezzo_ritiro_usato = $_POST['prezzo_ritiro_usato'] ?? 0;
            $genere = $_POST['genere'] ?? '';
            $descrizione = $_POST['descrizione'] ?? '';
            
            // Handle image upload
            $immagine = '';
            if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
                // Determine the appropriate directory based on genre
                if ($genere === 'piattaforma') {
                    $uploadDir = 'assets/img/products_images/console/';
                } else if ($genere === 'carta regalo') {
                    $uploadDir = 'assets/img/products_images/cards/';
                } else {
                    $uploadDir = 'assets/img/products_images/games/';
                }
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate unique filename
                $fileName = uniqid() . '_' . basename($_FILES['immagine']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                // Move uploaded file
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
    
    // Add this new method
    public function deleteProducts() {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get JSON data from request body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (isset($data['ids']) && is_array($data['ids']) && !empty($data['ids'])) {
                // Delete products from the database
                $result = $this->model->deleteProducts($data['ids']);
                
                // Return JSON response
                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Impossibile eliminare i prodotti']);
                }
            } else {
                // Return error if no IDs provided
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Nessun ID prodotto fornito']);
            }
            exit;
        }
        
        // If not POST request, return error
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    // Elimina un utente
    public function deleteUser() {
        // Verifica che la richiesta sia POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ottieni l'ID dell'utente
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            
            if ($id <= 0) {
                // Restituisci errore se l'ID non è valido
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'ID utente non valido']);
                exit;
            }
            
            // Elimina l'utente dal database
            $result = $this->model->deleteUser($id);
            
            // Restituisci risposta JSON
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile eliminare l\'utente']);
            }
            exit;
        }
        
        // Se la richiesta non è POST, restituisci errore
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    // Aggiunge il metodo per aggiornare un utente
    public function updateUser() {
        // Verifica se la richiesta è di tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ottieni i dati dal form
            $id = $_POST['id'] ?? 0;
            $ruolo = $_POST['ruolo'] ?? '';
            $stato = $_POST['stato'] ?? '';
            
            // Aggiorna l'utente nel database
            $result = $this->model->updateUser($id, $ruolo, $stato);
            
            // Restituisci una risposta JSON
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Impossibile aggiornare l\'utente']);
            }
            exit;
        }
        
        // Se non è una richiesta POST, restituisci un errore
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }
    
    // Aggiunge il metodo per ottenere i dettagli di un utente
    public function getUserDetails() {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
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
