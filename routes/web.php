
<?php
// require_once '../controllers/ProductController.php';

// $controller = new ProductController();
// $action = 'index';
// $controller->$action();


require_once '../controllers/ProductController.php';

$controller = new ProductController();
$action = 'index';

if(isset($_GET['action'])) {
   $action = $_GET['action'];
}

$controller->$action();
