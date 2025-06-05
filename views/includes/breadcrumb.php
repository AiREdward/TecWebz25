<?php
require_once __DIR__ . '/BreadcrumbView.php';

$breadcrumb = isset($breadcrumb) ? $breadcrumb : [];
$breadcrumbView = new BreadcrumbView($breadcrumb);
echo $breadcrumbView->render();
?>