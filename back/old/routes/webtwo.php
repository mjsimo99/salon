<?php
require_once '../controllers/RondivoController.php';

$controller = new RondivoController();
$action = 'index';

if(isset($_GET['action'])) {
   $action = $_GET['action'];
}

$controller->$action();
