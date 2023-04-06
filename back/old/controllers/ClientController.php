 <?php




require_once '../models/function.php';
require_once '../models/login.php';

class ClientController
{
    public function index()
    {


        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
       

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        switch ($requestMethod) {
            case 'GET':
                $clientId = (int)$_GET['clientId'];
                $clientList = getClient($clientId);
                echo $clientList;
                break;
            case 'POST':
                $client = json_decode(file_get_contents("php://input"), true);
                $addedClient = addClient($client);
                echo $addedClient;
                break;
            case 'PUT':
                $clientId = (int)$_GET['id'];
                $client = json_decode(file_get_contents("php://input"), true);
                $updatedClient = updateClient($clientId, $client);
                echo $updatedClient;
                break;
            case 'DELETE':
                $clientId = (int)$_GET['id'];
                $deletedClient = deleteClient($clientId);
                echo $deletedClient;
                break;
            default:
                $data = [
                    'status' => 405,
                    'message' => $requestMethod . 'Method Not Allowed',
                ];
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode($data);
                break;
        }
    }
}
// } -->