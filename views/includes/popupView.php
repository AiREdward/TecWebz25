<?php

class PopupView {
    private $message;
    private $type;
    private $templatePath;
    
    public function __construct($message, $type = "info") {
        $this->message = $message;
        $this->type = $type;
        $this->templatePath = __DIR__ . '/../../template/include/popup.html';
    }
    
    public function render() {
        $template = file_get_contents($this->templatePath);
        
        $icon = $this->getIcon();
        
        $html = str_replace('{{TYPE}}', $this->type, $template);
        $html = str_replace('{{ICON}}', $icon, $html);
        $html = str_replace('{{MESSAGE}}', htmlspecialchars($this->message, ENT_QUOTES, 'UTF-8'), $html);
        
        return $html;
    }
    
    private function getIcon() {
        $icons = [
            "info" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
            "success" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"></path></svg>',
            "error" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>'
        ];
        
        return isset($icons[$this->type]) ? $icons[$this->type] : $icons["info"];
    }
}

// Funzione di compatibilità per mantenere il codice esistente funzionante
function getPopupHtml($message, $type = "info") {
    $popupView = new PopupView($message, $type);
    return $popupView->render();
}

?>