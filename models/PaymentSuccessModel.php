<?php

class PaymentSuccessModel {
    public function getSuccessData($orderId) {
        return [
            'title' => 'Pagamento Completato',
            'header' => 'Pagamento Completato con Successo',
            'message' => 'Grazie per il tuo acquisto! Il tuo ordine è stato elaborato con successo.',
            'order_id' => $orderId
        ];
    }
}
?>
