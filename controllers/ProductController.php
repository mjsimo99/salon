<?php
require_once '../models/function.php';






// class ProductController {
//     public function index() {
//         header('Access-Control-Allow-Origin:*');
//         header('Content-type: application/json');
//         header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
//         header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
//         $requestMethod = $_SERVER['REQUEST_METHOD'];

//         switch ($requestMethod) {
//             case 'GET':
//                 $productList = getProductList();
//                 echo $productList;
//                 break;
//             case 'POST':
//                 $product = json_decode(file_get_contents("php://input"), true);
//                 $addedProduct = addProduct($product);
//                 echo $addedProduct;
//                 break;
            
//             case 'DELETE':
//                 $productId = (int)$_GET['id'];
//                 $deletedProduct = deleteProduct($productId);
//                 echo $deletedProduct;
//                 break;
//             default:
//                 $data = [
//                     'status' => 405,
//                     'message' => $requestMethod.'Method Not Allowed',
//                 ];
//                 header("HTTP/1.0 405 Method Not Allowed");
//                 echo json_encode($data);
//                 break;
//         }
//     }
// }
class ProductController {
    public function index() {
        header('Access-Control-Allow-Origin:*');
        header('Content-type: application/json');
        header('Access-Control-Allow-Method: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        switch ($requestMethod) {
            case 'GET':
                $productList = getProductList();
                echo $productList;
                break;
            case 'POST':
                $product = json_decode(file_get_contents("php://input"), true);
                $addedProduct = addProduct($product);
                echo $addedProduct;
                break;
            case 'PUT':
                $productId = (int)$_GET['id'];
                $product = json_decode(file_get_contents("php://input"), true);
                $updatedProduct = updateProduct($productId, $product);
                echo $updatedProduct;
                break;
            case 'DELETE':
                $productId = (int)$_GET['id'];
                $deletedProduct = deleteProduct($productId);
                echo $deletedProduct;
                break;
            default:
                $data = [
                    'status' => 405,
                    'message' => $requestMethod.'Method Not Allowed',
                ];
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode($data);
                break;
        }
    }
}
