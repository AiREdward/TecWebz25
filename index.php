<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'shop':
        require_once 'app/controllers/ShopController.php';
        $controller = new ShopController();
        break;
    case 'product':
        require_once 'app/controllers/ProductController.php';
        $controller = new ProductController();
        break;
    case 'rental':
        require_once 'app/controllers\RentalController.php';
        $controller = new RentalController();
        break;
    case 'login':
        require_once 'app/controllers/LoginController.php';
        $controller = new LoginController();
        break;
    case 'register':
        require_once 'app/controllers/RegisterController.php';
        $controller = new RegisterController();
        break;
    case 'admin':
        require_once 'app/controllers/AdminController.php';
        $controller = new AdminController();
        break;
    case 'print':
        require_once 'app/controllers/PrintController.php';
        $controller = new PrintController();
        break;
    case 'tournament':
        require_once 'app/controllers/TournamentController.php';
        $controller = new TournamentController();
        break;
    case 'home':
    default:
        require_once 'app/controllers/HomeController.php';
        $controller = new HomeController();
        break;
}

$controller->invoke();
?>
