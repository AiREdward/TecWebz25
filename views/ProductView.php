<?php
class ProductView {
    public function render($data) {
        if ($data) {
            // Carica il template HTML come stringa
            $templatePath = __DIR__ . '/../template/ProductTemplate.html';
            $html = file_get_contents($templatePath);

            // Prepara i sostituti per i segnaposto
            $replacements = [
                '{{menu}}' => $this->getMenu($data),
                '{{footer}}' => $this->getFooter(),
                '{{isRecent}}' => $data['isRecent'] ? 'recent-product' : '',
                '{{badge}}' => $data['isRecent'] ? '<span class="badge" aria-label="Prodotto nuovo">Nuovo!</span>' : '',
                '{{img_src}}' => htmlspecialchars($data['immagine']),
                '{{img_alt}}' => 'Prodotto ' . htmlspecialchars($data['nome']),
                '{{nome}}' => htmlspecialchars($data['nome']),
                '{{genere}}' => htmlspecialchars($data['genere']),
                '{{prezzo}}' => '$' . htmlspecialchars($data['prezzo_formattato']),
                '{{prezzo_ritiro}}' => $data['prezzo_ritiro_formattato']
                    ? '$' . htmlspecialchars($data['prezzo_ritiro_formattato'])
                    : 'Non è possibile effettuare il ritiro per questo prodotto.',
                '{{descrizione}}' => htmlspecialchars($data['descrizione']),
                '{{data_italiana}}' => htmlspecialchars($data['dataItaliana']),
            ];

            // Sostituisci i segnaposto nel template
            $output = str_replace(array_keys($replacements), array_values($replacements), $html);
            echo $output;
        } else {
            echo '<p aria-label="Messaggio di errore">Prodotto non trovato.</p>';
        }
    }

    private function getMenu($data) {
        ob_start();
        $breadcrumb = $data['breadcrumb'];
        include __DIR__ . '/includes/menu.php';
        return ob_get_clean();
    }

    private function getFooter() {
        ob_start();
        include __DIR__ . '/includes/footer.php';
        return ob_get_clean();
    }
}
?>