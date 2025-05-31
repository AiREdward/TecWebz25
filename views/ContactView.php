<?php
class ContactView {
    public function render($data) {
        // Carica il template HTML come stringa
        $templatePath = __DIR__ . '/../template/ContactTemplate.html';
        $html = file_get_contents($templatePath);

        // Prepara i sostituti per i segnaposto
        $replacements = [
            '{{menu}}' => $this->getMenu($data),
            '{{footer}}' => $this->getFooter(),
            '{{title}}' => $data['title'],
            '{{header}}' => $data['header'],
            '{{phone}}' => $data['phone'],
            '{{email}}' => $data['email'],
            '{{address}}' => str_replace('PD', '<abbr title="Padova">PD</abbr>', $data['address']),
            '{{content}}' => $data['content'],
        ];

        // Sostituisci i segnaposto nel template
        $output = str_replace(array_keys($replacements), array_values($replacements), $html);

        // Stampa l'output finale
        echo $output;
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