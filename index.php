<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'shop':
        require_once 'controllers/ShopController.php';
        $controller = new ShopController();
        break;
    case 'product':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        break;
    case 'rental':
        require_once 'controllers\RentalController.php';
        $controller = new RentalController();
        break;
    case 'login':
        require_once 'controllers/LoginController.php';
        $controller = new LoginController();
        break;
    case 'register':
        require_once 'controllers/RegisterController.php';
        $controller = new RegisterController();
        break;
    case 'admin':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        break;
    case 'print':
        require_once 'controllers/PrintController.php';
        $controller = new PrintController();
        break;
    case 'tournament':
        require_once 'controllers/TournamentController.php';
        $controller = new TournamentController();
        break;
    case 'chi-siamo':
        require_once 'controllers/ChiSiamoController.php';
        $controller = new ChiSiamoController();
        break;
    case 'contact':
        require_once 'controllers/ContactController.php';
        $controller = new ContactController();
        break;
    case 'payment':
        require_once 'controllers/PaymentController.php';
        $controller = new PaymentController();
        break;
    case 'home':
    default:
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        break;
}

$controller->invoke();
?>
