<?php
require_once 'controllers/includes/menuController.php';

class MenuView {
    private $menuController;
    private $templatePath;
    
    public function __construct() {
        $this->menuController = new MenuController();
        $this->templatePath = 'template/include/menu.html';
    }
    
    public function render() {
        $template = file_get_contents($this->templatePath);
        
        // Sostituisci i placeholder con il contenuto dinamico
        $template = str_replace('{{MENU_ITEMS}}', $this->generateMenuItems(), $template);
        $template = str_replace('{{MENU_ACTIONS}}', $this->generateMenuActions(), $template);
        $template = str_replace('{{LOGOUT_POPUP}}', $this->generateLogoutPopup(), $template);
        
        return $template;
    }
    
    private function generateMenuItems() {
        $menuItems = $this->menuController->getPages();
        $html = '';
        
        foreach ($menuItems as $label => $url) {
            if ($label != 'Logout' && $label != 'Accedi') {
                $activeClass = (strpos($_SERVER['REQUEST_URI'], $url) !== false) ? 'active' : '';
                $target = (strpos($url, 'admin') !== false) ? 'target="_blank"' : '';
                
                $html .= '<li class="menu-item ' . $activeClass . '">';
                $html .= '<a href="' . htmlspecialchars($url) . '" ' . $target . '>';
                $html .= $label;
                $html .= '</a>';
                $html .= '</li>';
            }
        }
        
        return $html;
    }
    
    private function generateMenuActions() {
        $isLoggedIn = $this->menuController->isUserLoggedIn();
        $html = '';
        
        if ($isLoggedIn) {
            $html .= '<div id="menu-actions">';
            $html .= '<a href="#" class="menu-button" id="logoutBtn" onclick="event.preventDefault(); confirmLogout();">';
            $html .= '<img src="assets/img/icons/logout.svg" class="icon-button" alt="Logo logout" aria-hidden="true" width="16" height="16"/>';
            $html .= '<span class="logout-text" lang="en">Logout</span>';
            $html .= '</a>';
            $html .= '</div>';
        } else {
            $html .= '<div id="menu-actions">';
            $html .= '<a href="index.php?page=auth" class="menu-button">';
            $html .= '<img src="assets/img/icons/account.svg" class="icon-button" alt="Logo account utente" aria-hidden="true" width="16" height="16"/>';
            $html .= '<span class="logout-text">Accedi</span>';
            $html .= '</a>';
            $html .= '</div>';
        }
        
        return $html;
    }
    
    private function generateLogoutPopup() {
        $isLoggedIn = $this->menuController->isUserLoggedIn();
        
        if ($isLoggedIn) {
            $html = '<div id="logoutPopupOverlay" role="dialog" aria-labelledby="logoutPopupTitle" aria-modal="true">';
            $html .= '<div class="logout-popup">';
            $html .= '<h3 id="logoutPopupTitle">Conferma Uscita</h3>';
            $html .= '<p>Sei sicuro di voler uscire?</p>';
            $html .= '<div class="logout-popup-buttons">';
            $html .= '<button id="confirmLogoutPopupBtn" class="confirm-btn">Esci</button>';
            $html .= '<button id="cancelLogoutPopupBtn" class="cancel-btn">Annulla</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            return $html;
        }
        
        return '';
    }
}
?>