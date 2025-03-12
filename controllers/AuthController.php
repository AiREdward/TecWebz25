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
        $email    = $_POST['email'];
        $password = $_POST['password'];
        // Se non c'è un redirect, va semplicemente a "index.php"
        $redirect = !empty($_POST['redirect']) ? $_POST['redirect'] : 'index.php';
    
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user->password)) {
            if ($user->stato === 'bloccato') {
                $error = "Il tuo account è bloccato.";
                include 'views/Accedi.php';
                return;
            }
    
            // Aggiorna il timestamp dell'ultimo accesso
            $user->updateLastAccess();
    
            $_SESSION['user']  = $user;
            $_SESSION['ruolo'] = $user->ruolo;
    
            header("Location: $redirect");
            exit;
        } else {
            include 'controllers/includes/popupController.php';
            setPopupMessage("Email o password errate. Riprova.", "error");
            header("Location: index.php?page=auth&action=login");
            include 'views/Accedi.php';
        }
    }    

    public function register() {
        include 'views/register.php';
    }

    public function doRegister() {
        $username      = $_POST['username'];
        $email         = $_POST['email'];
        $password      = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
        $user = new User();
        $user->username = $username;
        $user->email    = $email;
        $user->password = $password_hash;
        $user->ruolo    = 'user';
        $user->stato    = 'attivo';
        
        if ($user->save()) {
            // Usa il popup controller per impostare il messaggio
            include 'controllers/includes/popupController.php';
            setPopupMessage("Registrazione completata con successo! Ora puoi accedere.", "success");
            
            header("Location: index.php?page=auth&action=login");
            exit;
        } else {
            $error = "Errore nella registrazione";
            include 'views/register.php';
        }
    }       

    public function logout() {
        session_destroy();
        header("Location: index.php?page=auth&action=login");
        exit;
    }
}
?>
