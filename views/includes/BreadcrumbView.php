<?php

class BreadcrumbView {
    private $breadcrumb;
    private $templatePath;
    
    public function __construct($breadcrumb = []) {
        $this->breadcrumb = $breadcrumb;
        $this->templatePath = __DIR__ . '/../../template/include/breadcrumb.html';
    }
    
    public function render() {
        $template = file_get_contents($this->templatePath);
        
        $breadcrumbItems = $this->generateBreadcrumbItems();
        
        $template = str_replace('{{BREADCRUMB_ITEMS}}', $breadcrumbItems, $template);
        
        return $template;
    }
    
    private function generateBreadcrumbItems() {
        $items = '';
        
        foreach ($this->breadcrumb as $key => $item) {
            if ($key === array_key_last($this->breadcrumb)) {
                $items .= '<span class="active" aria-current="page">' .(htmlspecialchars($item['name']) === "Home" ? '<span lang="en">Home</span>' : htmlspecialchars($item['name'])) . '</span>';
            } else {
                $items .= '<a href="' . htmlspecialchars($item['url']) . '">' . (htmlspecialchars($item['name']) === "Home" ? '<span lang="en">Home</span>' : htmlspecialchars($item['name'])) . '</a> <span class="separator" aria-hidden="true">&gt;</span> ';
            }
        }
        
        return $items;
    }
}

?>