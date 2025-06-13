<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../views/ProductView.php';

class ProductController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ProductModel();
        $this->view = new ProductView();
    }

    private function isProductRecent($productDate) {
        $recentThreshold = new DateTime('-7 days');
        $productDateTime = new DateTime($productDate);
        return $productDateTime >= $recentThreshold;
    }

    private function formatItalianDate($date) {
        $mesiItaliani = [
            'January' => 'Gennaio',
            'February' => 'Febbraio',
            'March' => 'Marzo',
            'April' => 'Aprile',
            'May' => 'Maggio',
            'June' => 'Giugno',
            'July' => 'Luglio',
            'August' => 'Agosto',
            'September' => 'Settembre',
            'October' => 'Ottobre',
            'November' => 'Novembre',
            'December' => 'Dicembre'
        ];

        $dataInglese = date('d F Y', strtotime($date));
        return str_replace(array_keys($mesiItaliani), array_values($mesiItaliani), $dataInglese);
    }

    public function invoke() {
        $productId = $_GET['id'] ?? null;
        
        // Validazione dell'ID del prodotto
        if (empty($productId)) {
            // Reindirizza al negozio se l'ID non è fornito
            header('Location: index.php?page=shop');
            exit;
        }
        
        if (!is_numeric($productId) || $productId <= 0) {
            // Reindirizza al negozio se l'ID non è valido
            header('Location: index.php?page=shop');
            exit;
        }
        
        // Sanitizzazione dell'ID del prodotto
        $productId = (int)$productId;
        
        $data = $this->model->getProduct($productId);
        
        if ($data) {
            $data['isRecent'] = $this->isProductRecent($data['data_creazione']);
            $data['dataItaliana'] = $this->formatItalianDate($data['data_creazione']);
            $data['prezzo_formattato'] = number_format($data['prezzo'], 2);
            $data['prezzo_ritiro_formattato'] = $data['prezzo_ritiro_usato'] > 0 
                ? number_format($data['prezzo_ritiro_usato'], 2)
                : null;
            $data['breadcrumb'] = [
                ['name' => 'Home', 'url' => 'index.php?page=home'],
                ['name' => 'Negozio', 'url' => 'index.php?page=shop'],
                ['name' => 'Visualizza Prodotto', 'url' => 'index.php?page=product']
            ];
        }
        
        $this->view->render($data);
    }
}
?>