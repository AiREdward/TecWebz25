<?php
require_once 'models/User.php';
require_once 'config/db_config.php';

class AuthController {

    public function invoke() {
        $action = $_GET['action'] ?? 'login';

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'doLogin':
                $this->doLogin();
                break;
            case 'register':
                $this->register();
                break;
            case 'doRegister':
                $this->doRegister();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                echo "Azione non valida";
                break;
        }
    }

    public function login() {
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Accedi', 'url' => 'index.php?page=accedi']
        ];
        include 'views/Accedi.php';
    }

    public function doLogin() {
        include 'controllers/includes/popupController.php';
        
        // Validazione dei dati di input
        $errors = [];
        
        $input = isset($_POST['email']) ? trim($_POST['email']) : '';
        if (empty($input)) {
            $errors[] = 'Email o username è obbligatorio';
        } elseif (strlen($input) > 100) {
            $errors[] = 'Email o username troppo lungo';
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if (empty($password)) {
            $errors[] = 'Password è obbligatoria';
        } elseif (strlen($password) > 255) {
            $errors[] = 'Password troppo lunga';
        }
        
        // Se ci sono errori di validazione, reindirizza con messaggio
        if (!empty($errors)) {
            setPopupMessage(implode('<br>', $errors), "error");
            header("Location: index.php?page=auth&action=login");
            exit;
        }
        
        // Sanitizzazione dell'input
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        // Priorità alla variabile di sessione per il redirect
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
        } else {
            $redirect = !empty($_POST['redirect']) ? htmlspecialchars($_POST['redirect'], ENT_QUOTES, 'UTF-8') : 'index.php';
        }
        
        // Validazione del redirect per prevenire redirect malevoli
        if (!empty($redirect) && !preg_match('/^(index\.php|\?page=\w+)/', $redirect)) {
            $redirect = 'index.php';
        }
    
        $user = User::findByEmailOrUsername($input);
    
        if ($user && password_verify($password, $user->password)) {
            if ($user->stato === 'bloccato') {
                setPopupMessage("Il tuo account è stato bloccato. Contatta l'amministratore.", "error");
                header("Location: index.php?page=auth&action=login");
                exit;
            }
    
            $user->updateLastAccess();
    
            $_SESSION['user']  = $user->id;
            $_SESSION['ruolo'] = $user->ruolo;
            
            if (isset($_SESSION['redirect_after_login'])) {
                unset($_SESSION['redirect_after_login']);
            }
    
            header("Location: $redirect");
            exit;
        } else {
            setPopupMessage("Email/Username o password errati. Riprova.", "error");
            header("Location: index.php?page=auth&action=login");
            exit;
        }
    }

    public function register() {
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Registrazione', 'url' => 'index.php?page=registrazione']
        ];
        include 'views/Registrazione.php';
    }

    public function doRegister() {
        include 'controllers/includes/popupController.php';
        
        // Validazione completa dei dati di registrazione
        $errors = [];
        
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        if (empty($username)) {
            $errors[] = 'Lo username è obbligatorio';
        } elseif (strlen($username) < 3 || strlen($username) > 30) {
            $errors[] = 'Lo username deve essere tra 3 e 30 caratteri';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'Lo username può contenere solo lettere, numeri e underscore';
        }
        
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        if (empty($email)) {
            $errors[] = 'L\'email è obbligatoria';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Formato email non valido';
        } elseif (strlen($email) > 100) {
            $errors[] = 'Email troppo lunga';
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if (empty($password)) {
            $errors[] = 'La password è obbligatoria';
        } elseif (strlen($password) < 8) {
            $errors[] = 'La password deve essere di almeno 8 caratteri';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
            $errors[] = 'La password deve contenere almeno una lettera minuscola, una maiuscola e un numero';
        }
        
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        if (empty($confirm_password)) {
            $errors[] = 'La conferma password è obbligatoria';
        } elseif ($password !== $confirm_password) {
            $errors[] = 'Le password non coincidono';
        }
        
        // Se ci sono errori di validazione, reindirizza con messaggio
        if (!empty($errors)) {
            setPopupMessage(implode('<br>', $errors), "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }
        
        // Sanitizzazione dei dati
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Controllo se l'email o lo username esistono già
        $existenceCheck = User::existsByEmailOrUsername($email, $username);

        if ($existenceCheck['emailExists']) {
            setPopupMessage("L'email è già in uso. Scegli un'altra email.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }

        if ($existenceCheck['usernameExists']) {
            setPopupMessage("Lo username è già in uso. Scegli un altro nome utente.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }

        // Creazione del nuovo utente
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password_hash;
        $user->ruolo = 'user';
        $user->stato = 'attivo';

        if ($user->save()) {
            setPopupMessage("Registrazione completata con successo! Ora puoi accedere.", "success");
            header("Location: index.php?page=auth&action=login");
            exit;
        } else {
            setPopupMessage("Errore nella registrazione. Riprova.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=home");
        exit;
    }
}
?>
