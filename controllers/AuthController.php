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
        include 'views/Accedi.php';
    }

    public function doLogin() {
        include 'controllers/includes/popupController.php';
    
        $input    = $_POST['email'];
        $password = $_POST['password'];
        $redirect = !empty($_POST['redirect']) ? $_POST['redirect'] : 'index.php';
    
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
            
            // Rimuovi la variabile di sessione redirect_after_login dopo averla utilizzata
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
        include 'views/Registrazione.php';
    }

    public function doRegister() {
        include 'controllers/includes/popupController.php';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Check if username contains only spaces
        if (trim($username) === '') {
            setPopupMessage("Lo username non può essere vuoto.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }

        // Controllo se l'email o lo username esistono già
        $existenceCheck = User::existsByEmailOrUsername($email, $username);

        if ($existenceCheck['emailExists']) {
            setPopupMessage("L'email '$email' è già in uso. Scegli un'altra email.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }

        if ($existenceCheck['usernameExists']) {
            setPopupMessage("Lo username '$username' è già in uso. Scegli un altro nome utente.", "error");
            header("Location: index.php?page=auth&action=register");
            exit;
        }

        if ($password !== $confirm_password) {
            setPopupMessage("Le password non coincidono.", "error");
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
