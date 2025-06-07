<?php
class TradeView {
    public function render($data) {
        // Carica il template HTML
        $template = file_get_contents(__DIR__ . '/../template/Trade.html');

        // Genera il menu e il footer tramite include e output buffering
        ob_start();
        $breadcrumb = $data['breadcrumb'];
        include 'includes/menu.php';
        $menu = ob_get_clean();

        ob_start();
        include 'includes/footer.php';
        $footer = ob_get_clean();

        // Genera la sezione categorie dinamicamente
        ob_start();
        foreach ($data['categories'] as $category):
        ?>
        <fieldset class="nes-radio-group">
            <legend class="form-legend"><?php echo ucfirst(htmlspecialchars($category[0])); ?></legend>
            <div class="radio-group-wrapper" role="radiogroup">
                <?php foreach ($data['ratings'] as $item): ?>
                <?php if ($item['categoria'] == $category[0]): ?>
                <label class="nes-radio">
                    <input type="radio" 
                        name="<?php echo htmlspecialchars($item['categoria']); ?>" 
                        value="<?php echo htmlspecialchars($item['nome']); ?>" 
                        class="sr-only"
                        required>
                    <span class="nes-btn" role="presentation">
                        <span class="nes-led" aria-hidden="true"></span>
                        <?php echo ucfirst(htmlspecialchars($item['nome'])); ?>
                    </span>
                </label>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </fieldset>
        <?php
        endforeach;
        $categoriesHtml = ob_get_clean();

        // Sostituisci i segnaposto nel template
        $output = str_replace(
            ['{{menu}}', '{{footer}}', '{{categories}}'],
            [$menu, $footer, $categoriesHtml],
            $template
        );

        echo $output;
    }
}
?>