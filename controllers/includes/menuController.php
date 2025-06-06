<?php
class MenuController {
    private $pages;
    private $userRole;

    public function __construct() {
        $this->pages = [
            '<span lang="en">Home</span>' => 'index.php?page=home',
            'Negozio' => 'index.php?page=shop',
            'Permuta' => 'index.php?page=trade',
            'Chi Siamo' => 'index.php?page=chi-siamo',
            'Contattaci' => 'index.php?page=contact'
        ];
        $this->userRole = isset($_SESSION['ruolo']) ? $_SESSION['ruolo'] : null;
    }

    public function getPages() {
        $menuItems = $this->pages;
        
        if ($this->userRole === 'admin') {
            $menuItems['<span lang="en">Admin</span>'] = 'index.php?page=admin';
        }

        // Questo non serve aggiungerlo da qui perché è già inserito da generateMenuItems
        // Aggiungi Accedi/Logout in base allo stato dell'utente
        // if ($this->userRole) {
        //     $menuItems['<span lang="en">Logout</span>'] = '#';
        // } else {
        //     $menuItems['Accedi'] = 'index.php?page=auth';
        // }

        return $menuItems;
    }

    public function isUserLoggedIn() {
        return isset($_SESSION['user']);
    }
}
?>