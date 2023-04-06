<?php


require_once '../models/rondivo.php';

class RondivoController {
    public function index() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        switch ($requestMethod) {
          

            case 'GET':
                if (isset($_GET['client_date'])) {
                    $client_date = $_GET['client_date'];
                    $rondiVoList = getReservedHours($client_date);
                    echo $rondiVoList;
                } 
                break;
            

              
            case 'POST':
                $rondivo = json_decode(file_get_contents("php://input"), true);
                $addedRondivo = addRondivo($rondivo);
                echo $addedRondivo;
                break;
            
            case 'DELETE':
                $clientId = (int)$_GET['clientId'];
                $clientDate = $_GET['client_date'];
                $hour = $_GET['hour'];
                $deletedRondivo = deleteRondivo($clientId,$clientDate,$hour);
                echo $deletedRondivo;
                break;
                // case 'DELETE':
                //     $rdvid = (int)$_GET['id'];
                //     $deletedRondivo = deleteRondivo($rdvid);
                //     echo $deletedRondivo;
                //     break;
            default:
                $data = [
                    'status' => 405,
                    'message' => $requestMethod.'Method Not Allowed',
                ];
                // header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode($data);
                break;
        }
    }
}
