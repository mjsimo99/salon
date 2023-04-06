<?php
require_once '../controllers/LoginController.php';

$controller = new LoginController();
$action = 'index';

if(isset($_GET['action'])) {
   $action = $_GET['action'];
}

$controller->$action();
