<?php
class ChiSiamoView {
    public function render($data) {
        // Carica il template HTML come stringa
        $templatePath = __DIR__ . '/../template/ChiSiamoTemplate.html';
        $html = file_get_contents($templatePath);

        // Prepara i sostituti per i segnaposto
        $replacements = [
            '{{menu}}' => $this->getMenu($data),
            '{{footer}}' => $this->getFooter(),
            '{{content1}}' => $data['content1'],
            '{{content2}}' => $data['content2'],
            '{{content3}}' => $data['content3'],
            '{{content5}}' => $data['content5'],
            '{{content6}}' => $data['content6'],
            '{{content7}}' => $data['content7'],
            // aggiungi altri segnaposto se necessario
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