
<?php
// require_once '../controllers/ProductController.php';
// require_once '.htaccess';


require_once '../controllers/ClientController.php';


$controller = new ClientController();
$action = 'index';

if(isset($_GET['action'])) {
   $action = $_GET['action'];
}

$controller->$action();


