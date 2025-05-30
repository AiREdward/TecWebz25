<?php
session_start();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'calc_rating':
            require_once 'controllers/TradeController.php';
            $api = new TradeController();
            $api->getRating(
                $_GET['type'] ?? null,
                $_GET['conditions'] ?? null,
                $_GET['brand'] ?? null
            );
            exit;
    }
}

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
    case 'trade':
        require_once 'controllers/TradeController.php';
        $controller = new TradeController();
        break;
    case 'chi-siamo':
        require_once 'controllers/ChiSiamoController.php';
        $controller = new ChiSiamoController();
        break;
    case 'admin':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        break;
    case 'contact':
        require_once 'controllers/ContactController.php';
        $controller = new ContactController();
        break;
    case 'payment':
        require_once 'controllers/PaymentController.php';
        $controller = new PaymentController();
        break;
    case 'payment_success': 
        require_once 'controllers/PaymentSuccessController.php';
        $controller = new PaymentSuccessController();
        break;
    case 'auth':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        break;
    case 'home':
    default:
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        break;
}


$controller->invoke();
?>
