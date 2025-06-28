<?php

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=auth&action=login");
    exit();
}

require_once __DIR__ . '/../models/PaymentModel.php';
require_once __DIR__ . '/../views/PaymentView.php';

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
            if (json_last_error() === JSON_ERROR_NONE && $cartData && isset($cartData['items']) && is_array($cartData['items'])) {
                // Validazione degli elementi del carrello
                $validItems = [];
                foreach ($cartData['items'] as $item) {
                    if (isset($item['id'], $item['quantity'], $item['prezzo']) && 
                        is_numeric($item['id']) && $item['id'] > 0 &&
                        is_numeric($item['quantity']) && $item['quantity'] > 0 &&
                        is_numeric($item['prezzo']) && $item['prezzo'] > 0) {
                        $validItems[] = $item;
                    }
                }
                if (!empty($validItems)) {
                    $cartItems = $validItems;
                    $total = $this->calculateTotal($cartItems);
                    $cartData['items'] = $cartItems;
                    $cartData['total'] = $total;
                    $_SESSION['cartData'] = json_encode($cartData);
                }
            }
        }
        else if (isset($_SESSION['cartData'])) {
            $cartData = json_decode($_SESSION['cartData'], true);
            if (json_last_error() === JSON_ERROR_NONE && $cartData && isset($cartData['items']) && is_array($cartData['items'])) {
                // Validazione degli elementi del carrello dalla sessione
                $validItems = [];
                foreach ($cartData['items'] as $item) {
                    if (isset($item['id'], $item['quantity'], $item['prezzo']) && 
                        is_numeric($item['id']) && $item['id'] > 0 &&
                        is_numeric($item['quantity']) && $item['quantity'] > 0 &&
                        is_numeric($item['prezzo']) && $item['prezzo'] > 0) {
                        $validItems[] = $item;
                    }
                }
                if (!empty($validItems)) {
                    $cartItems = $validItems;
                    $total = $this->calculateTotal($cartItems);
                    $cartData['items'] = $cartItems;
                    $cartData['total'] = $total;
                    $_SESSION['cartData'] = json_encode($cartData);
                }
            }
        }

        if (empty($cartItems)) {
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
        if (!isset($_POST['cartData']) || empty($_POST['cartData'])) {
            echo json_encode(['success' => false, 'error' => 'Dati del carrello mancanti']);
            return;
        }

        $cartData = json_decode($_POST['cartData'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'error' => 'Formato dati del carrello non valido']);
            return;
        }

        if (!isset($cartData['items']) || !is_array($cartData['items'])) {
            echo json_encode(['success' => false, 'error' => 'Elementi del carrello non validi']);
            return;
        }

        // Validazione degli elementi del carrello
        foreach ($cartData['items'] as $item) {
            if (!isset($item['id']) || !is_numeric($item['id']) || $item['id'] <= 0) {
                echo json_encode(['success' => false, 'error' => 'ID prodotto non valido']);
                return;
            }
            if (!isset($item['quantity']) || !is_numeric($item['quantity']) || $item['quantity'] <= 0) {
                echo json_encode(['success' => false, 'error' => 'Quantità prodotto non valida']);
                return;
            }
            if (!isset($item['prezzo']) || !is_numeric($item['prezzo']) || $item['prezzo'] <= 0) {
                echo json_encode(['success' => false, 'error' => 'Prezzo prodotto non valido']);
                return;
            }
        }

        $_SESSION['cartData'] = $_POST['cartData'];
        echo json_encode(['success' => true]);
    }

    private function processPayment() {
        if (isset($_POST['cartData'])) {
            $_SESSION['cartData'] = $_POST['cartData'];
        } else if (!isset($_SESSION['cartData'])) {
            header('Location: index.php?page=shop');
            exit;
        }

        // Validazione dei dati di pagamento
        $errors = [];

        // Validazione nome titolare carta
        if (!isset($_POST['card-holder']) || empty(trim($_POST['card-holder']))) {
            $errors[] = 'Nome titolare carta è obbligatorio';
        } else {
            $cardHolder = trim($_POST['card-holder']);
            if (!preg_match('/^[a-zA-ZÀ-ÿ\s]{2,50}$/', $cardHolder)) {
                $errors[] = 'Nome titolare carta non valido (solo lettere e spazi, 2-50 caratteri)';
            }
        }

        // Validazione numero carta
        if (!isset($_POST['card-number']) || empty(trim($_POST['card-number']))) {
            $errors[] = 'Numero carta è obbligatorio';
        } else {
            $cardNumber = preg_replace('/\s+/', '', trim($_POST['card-number']));
            if (!preg_match('/^\d{16}$/', $cardNumber)) {
                $errors[] = 'Numero carta deve contenere esattamente 16 cifre';
            }
        }

        // Validazione data scadenza
        if (!isset($_POST['expiry-date']) || empty(trim($_POST['expiry-date']))) {
            $errors[] = 'Data di scadenza è obbligatoria';
        } else {
            $expiryDate = trim($_POST['expiry-date']);
            if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiryDate)) {
                $errors[] = 'Data di scadenza deve essere nel formato MM/YY';
            } else {
                list($month, $year) = explode('/', $expiryDate);
                $currentYear = date('y');
                $currentMonth = date('m');
                if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                    $errors[] = 'La carta è scaduta';
                }
            }
        }

        // Validazione CVV
        if (!isset($_POST['cvv']) || empty(trim($_POST['cvv']))) {
            $errors[] = 'CVV è obbligatorio';
        } else {
            $cvv = trim($_POST['cvv']);
            if (!preg_match('/^\d{3,4}$/', $cvv)) {
                $errors[] = 'CVV deve contenere 3 o 4 cifre';
            }
        }

        // Se ci sono errori, mostra la pagina di pagamento con gli errori
        if (!empty($errors)) {
            $data = $this->getCartData();
            $data['error'] = implode('<br>', $errors);
            $this->view->render($data);
            return;
        }

        $paymentData = [
            'card-holder' => htmlspecialchars(trim($_POST['card-holder']), ENT_QUOTES, 'UTF-8'),
            'card-number' => preg_replace('/\s+/', '', trim($_POST['card-number'])),
            'expiry-date' => trim($_POST['expiry-date']),
            'cvv' => trim($_POST['cvv'])
        ];

        $result = $this->model->processPayment($paymentData);

        if (is_array($result) && isset($result['error'])) {
            $data = $this->getCartData();
            $data['error'] = 'Si è verificato un errore durante il pagamento: ' . htmlspecialchars($result['error'], ENT_QUOTES, 'UTF-8');
            $this->view->render($data);
        } else {
            header('Location: index.php?page=payment_success&order_id=' . intval($result));
            exit;
        }
    }
    
    private function cancelOrder() {
        unset($_SESSION['cartData']);
        header('Location: index.php?page=shop');
        exit;
    }
}
?>
