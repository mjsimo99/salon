<?php


require_once '../models/login.php';

class LoginController
{


    public function index()
    {


        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');


        $requestMethod = $_SERVER['REQUEST_METHOD'];

        switch ($requestMethod) {
            // ...
        
            case 'GET':
                if (isset($_GET['reference'])) {
                    $reference = $_GET['reference'];
                    $clientList = getClientByReference($reference);
                    echo $clientList;

                } else {
                    $clientId = (int)$_GET['id'];
                    $clientList = getClient($clientId);
                    echo $clientList;
                }
                break;
        
            // ...
        }
        
    }
}
