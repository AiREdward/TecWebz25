<?php
require_once __DIR__ . '/../models/PaymentModel.php';
require_once __DIR__ . '/../views/PaymentView.php';
require_once __DIR__ . '/../controllers/includes/popupController.php';

class PaymentController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PaymentModel();
        $this->view = new PaymentView();
    }

    public function invoke() {
        if (isset($_GET['action'])) {
            if ($_GET['action'] === 'process') {
                $this->processPayment();
            } elseif ($_GET['action'] === 'update_cart' && isset($_POST['cartData'])) {
                $this->updateCartData();
                exit;
            } elseif ($_GET['action'] === 'cancel_order') {
                $this->cancelOrder();
            }
        } else {
            $data = $this->getCartData();
            $this->view->render($data);
        }
    }

    private function getCartData() {
        $cartItems = [];
        $total = 0;

        if (isset($_POST['cartData'])) {
            $cartData = json_decode($_POST['cartData'], true);
            if ($cartData && isset($cartData['items'])) {
                $cartItems = $cartData['items'];
                $total = $this->calculateTotal($cartItems);
                $cartData['total'] = $total;
                $_SESSION['cartData'] = json_encode($cartData);
            }
        } else if (isset($_SESSION['cartData'])) {
            $cartData = json_decode($_SESSION['cartData'], true);
            if ($cartData && isset($cartData['items'])) {
                $cartItems = $cartData['items'];
                $total = $this->calculateTotal($cartItems);
                $cartData['total'] = $total;
                $_SESSION['cartData'] = json_encode($cartData); 
            }
        }

        if (empty($cartItems)) {
            unset($_SESSION['popup_message'], $_SESSION['popup_type']);
            header('Location: index.php?page=shop');
            exit;
}

        return [
            'title' => 'Pagamento',
            'header' => 'Completa il tuo acquisto',
            'cartItems' => $cartItems,
            'total' => $total,
            'breadcrumb' => [
                ['name' => 'Home', 'url' => 'index.php?page=home'],
                ['name' => 'Negozio', 'url' => 'index.php?page=shop'],
                ['name' => 'Pagamento', 'url' => 'index.php?page=payment']
            ]
        ];
    }

    private function calculateTotal($cartItems) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['prezzo'] * $item['quantity'];
        }
        return $total;
    }

    private function updateCartData() {
        if (isset($_POST['cartData'])) {
            $_SESSION['cartData'] = $_POST['cartData'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Dati del carrello mancanti']);
        }
    }

    private function processPayment() {
        if (isset($_POST['cartData'])) {
            $_SESSION['cartData'] = $_POST['cartData'];
        }

        if (!isset($_SESSION['cartData'])) {
            setPopupMessage("Il carrello è vuoto. Aggiungi almeno un prodotto prima di procedere al pagamento.", "info");
            header('Location: index.php?page=payment');
            exit;
        }

        $cartData = json_decode($_SESSION['cartData'], true);
        if (!$cartData || empty($cartData['items']) || $cartData['total'] <= 0) {
    setPopupMessage("Il carrello è vuoto. Aggiungi almeno un prodotto prima di procedere al pagamento.", "info");

    $data = $this->getCartDataForEmptyCase();
    $this->view->render($data);
    return;
}


        $paymentData = [
            'card-holder' => $_POST['card-holder'],
            'card-number' => $_POST['card-number'],
            'expiry-date' => $_POST['expiry-date'],
            'cvv' => $_POST['cvv']
        ];

        $result = $this->model->processPayment($paymentData);

        if (is_array($result) && isset($result['error'])) {
            $data = $this->getCartData();
            $data['error'] = 'Si è verificato un errore durante il pagamento: ' . $result['error'];
            $this->view->render($data);
        } else {
            header('Location: index.php?page=payment_success&order_id=' . $result);
            exit;
        }
    }

    private function cancelOrder() {
        unset($_SESSION['cartData']);
        header('Location: index.php?page=shop');
        exit;
    }
    private function getCartDataForEmptyCase() {
    return [
        'title' => 'Pagamento',
        'header' => 'Completa il tuo acquisto',
        'cartItems' => [],
        'total' => 0,
        'breadcrumb' => [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Negozio', 'url' => 'index.php?page=shop'],
            ['name' => 'Pagamento', 'url' => 'index.php?page=payment']
        ]
    ];
}
}
?>
