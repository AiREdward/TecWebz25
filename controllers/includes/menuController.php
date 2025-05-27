<?php
class MenuController {
    private $pages;
    private $userRole;

    public function __construct() {
        $this->pages = [
            'Home' => 'index.php?page=home',
            'Shop' => 'index.php?page=shop',
            'Permuta' => 'index.php?page=trade',
            'Noi' => 'index.php?page=chi-siamo',
            'Contattaci' => 'index.php?page=contact'
        ];
        $this->userRole = isset($_SESSION['ruolo']) ? $_SESSION['ruolo'] : null;
    }

    public function getPages() {
        $menuItems = $this->pages;
        
        // Aggiungi la pagina Admin solo se l'utente è admin
        if ($this->userRole === 'admin') {
            $menuItems['Admin'] = 'index.php?page=admin';
        }

        // Aggiungi Accedi/Logout in base allo stato dell'utente
        if ($this->userRole) {
            $menuItems['Logout'] = '#';
        } else {
            $menuItems['Accedi'] = 'index.php?page=auth';
        }

        return $menuItems;
    }

    public function isUserLoggedIn() {
        return isset($_SESSION['user']);
    }
}
?>