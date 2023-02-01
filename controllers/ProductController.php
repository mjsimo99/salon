<?php
require_once '../models/function.php';


class ProductController {
    public function index() {
        header('Access-Control-Allow-Origin:*');
        header('Content-type: application/json');
        header('Access-Control-Allow-Method: GET');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === "GET") {
            $productList = getProductList();
            echo $productList;
        } else if ($requestMethod === "POST") {
            $product = json_decode(file_get_contents("php://input"), true);
            $addedProduct = addProduct($product);
            echo $addedProduct;
        } else {
            $data = [
                'status' => 405,
                'message' => $requestMethod.'Method Not Allowed',
            ];
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode($data);
        }
    }
}



