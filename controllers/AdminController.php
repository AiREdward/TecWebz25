<?php

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=auth&action=login");
    exit();
}

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
            // Validazione iniziale dei dati
            $errors = [];
            
            // Get form data con validazione
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($id <= 0) {
                $errors[] = 'ID prodotto non valido';
            }
            
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
            if (empty($nome)) {
                $errors[] = 'Il nome del prodotto è obbligatorio';
            } elseif (strlen($nome) < 2 || strlen($nome) > 100) {
                $errors[] = 'Il nome del prodotto deve essere tra 2 e 100 caratteri';
            }
            
            $prezzo = isset($_POST['prezzo']) ? floatval($_POST['prezzo']) : 0;
            if ($prezzo <= 0) {
                $errors[] = 'Il prezzo deve essere maggiore di zero';
            } elseif ($prezzo > 9999.99) {
                $errors[] = 'Il prezzo non può superare 9999.99';
            }
            
            $prezzo_ritiro_usato = isset($_POST['prezzo_ritiro_usato']) ? floatval($_POST['prezzo_ritiro_usato']) : 0;
            if ($prezzo_ritiro_usato < 0) {
                $errors[] = 'Il prezzo di ritiro usato non può essere negativo';
            } elseif ($prezzo_ritiro_usato > 9999.99) {
                $errors[] = 'Il prezzo di ritiro usato non può superare 9999.99';
            }
            
            $genere = isset($_POST['genere']) ? trim($_POST['genere']) : '';
            $generi_validi = ['gioco', 'piattaforma', 'carta regalo'];
            if (empty($genere) || !in_array($genere, $generi_validi)) {
                $errors[] = 'Genere non valido';
            }
            
            $descrizione = isset($_POST['descrizione']) ? trim($_POST['descrizione']) : '';
            if (empty($descrizione)) {
                $errors[] = 'La descrizione è obbligatoria';
            } elseif (strlen($descrizione) < 10 || strlen($descrizione) > 1000) {
                $errors[] = 'La descrizione deve essere tra 10 e 1000 caratteri';
            }
            
            $currentImage = isset($_POST['current_image']) ? trim($_POST['current_image']) : '';
            
            // Se ci sono errori di validazione, restituiscili
            if (!empty($errors)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
                exit;
            }
            
            // Handle image upload con validazione
            $immagine = '';
            if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
                // Validazione file immagine
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!in_array($_FILES['immagine']['type'], $allowedTypes)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Tipo di file non supportato. Usa JPEG, PNG, GIF o WebP']);
                    exit;
                }
                
                if ($_FILES['immagine']['size'] > $maxSize) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'File troppo grande. Massimo 5MB']);
                    exit;
                }
                
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
                $fileExtension = pathinfo($_FILES['immagine']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['immagine']['name'], '.' . $fileExtension)) . '.' . $fileExtension;
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
        
        // If not POST request, return error
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Metodo di richiesta non valido']);
        exit;
    }

    // Add this new method
    public function searchProducts() {
        // Get search query from GET parameter con validazione
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        
        // Validazione query di ricerca
        if (strlen($query) > 100) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Query di ricerca troppo lunga']);
            exit;
        }
        
        // Sanitizzazione della query
        $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
        
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
            // Validazione e sanitizzazione dei dati
            $errors = [];
            
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
            if (empty($nome)) {
                $errors[] = 'Il nome del prodotto è obbligatorio';
            } elseif (strlen($nome) < 2 || strlen($nome) > 100) {
                $errors[] = 'Il nome del prodotto deve essere tra 2 e 100 caratteri';
            }
            
            $prezzo = isset($_POST['prezzo']) ? floatval($_POST['prezzo']) : 0;
            if ($prezzo <= 0) {
                $errors[] = 'Il prezzo deve essere maggiore di zero';
            } elseif ($prezzo > 9999.99) {
                $errors[] = 'Il prezzo non può superare 9999.99';
            }
            
            $prezzo_ritiro_usato = isset($_POST['prezzo_ritiro_usato']) ? floatval($_POST['prezzo_ritiro_usato']) : 0;
            if ($prezzo_ritiro_usato < 0) {
                $errors[] = 'Il prezzo di ritiro usato non può essere negativo';
            } elseif ($prezzo_ritiro_usato > 9999.99) {
                $errors[] = 'Il prezzo di ritiro usato non può superare 9999.99';
            }
            
            $genere = isset($_POST['genere']) ? trim($_POST['genere']) : '';
            $generi_validi = ['gioco', 'piattaforma', 'carta regalo'];
            if (empty($genere) || !in_array($genere, $generi_validi)) {
                $errors[] = 'Genere non valido';
            }
            
            $descrizione = isset($_POST['descrizione']) ? trim($_POST['descrizione']) : '';
            if (empty($descrizione)) {
                $errors[] = 'La descrizione è obbligatoria';
            } elseif (strlen($descrizione) < 10 || strlen($descrizione) > 1000) {
                $errors[] = 'La descrizione deve essere tra 10 e 1000 caratteri';
            }
            
            // Validazione file immagine
            if (!isset($_FILES['immagine']) || $_FILES['immagine']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'L\'immagine è obbligatoria';
            } else {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!in_array($_FILES['immagine']['type'], $allowedTypes)) {
                    $errors[] = 'Tipo di file non supportato. Usa JPEG, PNG, GIF o WebP';
                }
                
                if ($_FILES['immagine']['size'] > $maxSize) {
                    $errors[] = 'File troppo grande. Massimo 5MB';
                }
            }
            
            // Se ci sono errori di validazione, restituiscili
            if (!empty($errors)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
                exit;
            }
            
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
                $fileExtension = pathinfo($_FILES['immagine']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['immagine']['name'], '.' . $fileExtension)) . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;
                
                // Move uploaded file
                if (move_uploaded_file($_FILES['immagine']['tmp_name'], $uploadFile)) {
                    $immagine = $uploadFile;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Impossibile caricare l\'immagine']);
                    exit;
                }
            }
            
            // Sanitizzazione dei dati
            $nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
            $descrizione = htmlspecialchars($descrizione, ENT_QUOTES, 'UTF-8');
            
            // Add the product
            $result = $this->model->addProduct($nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione);
                
            // Return JSON response
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiunta del prodotto']);
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
            
            // Validazione dei dati JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Dati JSON non validi']);
                exit;
            }
            
            if (isset($data['ids']) && is_array($data['ids']) && !empty($data['ids'])) {
                // Validazione degli ID
                $validIds = [];
                foreach ($data['ids'] as $id) {
                    $id = intval($id);
                    if ($id > 0) {
                        $validIds[] = $id;
                    }
                }
                
                if (empty($validIds)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Nessun ID prodotto valido fornito']);
                    exit;
                }
                
                // Delete products from the database
                $result = $this->model->deleteProducts($validIds);
                
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
            // Validazione dei dati
            $errors = [];
            
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($id <= 0) {
                $errors[] = 'ID utente non valido';
            }
            
            $ruolo = isset($_POST['ruolo']) ? trim($_POST['ruolo']) : '';
            $ruoli_validi = ['admin', 'user'];
            if (empty($ruolo) || !in_array($ruolo, $ruoli_validi)) {
                $errors[] = 'Ruolo non valido';
            }
            
            $stato = isset($_POST['stato']) ? trim($_POST['stato']) : '';
            $stati_validi = ['attivo', 'sospeso'];
            if (empty($stato) || !in_array($stato, $stati_validi)) {
                $errors[] = 'Stato non valido';
            }
            
            // Se ci sono errori, restituiscili
            if (!empty($errors)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
                exit;
            }
            
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
