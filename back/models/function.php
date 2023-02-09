<?php
require '../inc/dbcon.php';

function getProductList()
{
global $conn;
try {
    $stmt = $conn->prepare("SELECT date , time FROM appointment");
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    // $results = $stmt->fetchAll();

    if ($stmt) {
        if ($num_rows > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Product list Succesful',
                'res' => $results,
            ];
            // header("HTTP/1.0 405 Product list Succesful");
            return json_encode($data);
        } else {
            $data = [
                'status' => 5,
                'message' => 'No Product Found',
            ];
            header("HTTP/1.0 405 No Product Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 5,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 405 Internal Server Error");
        return json_encode($data);
    }
    // return $results;
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
}


function addProduct($product) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO appointment (client_id,date,time) VALUES (:client_id, :date, :time)");
        $stmt->bindParam(':client_id', $product['client_id']);
        $stmt->bindParam(':date', $product['date']);
        $stmt->bindParam(':time', $product['time']);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 201,
                'message' => 'Product added successfully',
                'product' => $product
            ];
            header("HTTP/1.0 201 Product added successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to add product'
            ];
            header("HTTP/1.0 500 Failed to add product");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}


function deleteProduct($id_app) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM appointment WHERE id_app=:id_app");
        $stmt->bindParam(':id_app', $id_app);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'Product deleted successfully',
                'id' => $id_app
            ];
            header("HTTP/1.0 200 appointments deleted successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'appointments not found'
            ];
            header("HTTP/1.0 404 appointments not found");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
function updateProduct($id_app, $product) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE appointment SET client_id=:client_id, date=:date, time=:time WHERE id_app=:id_app");
        $stmt->bindParam(':id_app', $id_app);
        $stmt->bindParam(':client_id', $product['client_id']);
        $stmt->bindParam(':date', $product['date']);
        $stmt->bindParam(':time', $product['time']);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'Product updated successfully',
                'product' => $product
            ];
            header("HTTP/1.0 200 Product updated successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to update product'
            ];
            header("HTTP/1.0 500 Failed to update product");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
