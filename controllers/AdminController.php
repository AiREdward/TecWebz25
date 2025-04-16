<?php
require_once 'models/User.php';
require_once 'models/AdminModel.php';

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
            default:
                $this->listUsers();
                break;
        }
    }

    public function listUsers() {
        $users = User::getAllUsers();
        include 'test/admin.php';
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
                    $uploadDir = 'assets/products_images/console/';
                } else if ($genere === 'carta regalo') {
                    $uploadDir = 'assets/products_images/cards/';
                } else {
                    $uploadDir = 'assets/products_images/games/';
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
}
?>
