<?php
require_once 'views/includes/MenuView.php';

$menuView = new MenuView();
echo $menuView->render();
?>

<?php include 'breadcrumb.php'; ?>