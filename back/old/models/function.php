<?php
require '../inc/dbcon.php';

function getClient($clientId) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM client WHERE clientId=:clientId");
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'client found',
                'res' => $results,
            ];
            header("HTTP/1.0 200 client found");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'client not found',
            ];
            header("HTTP/1.0 404 client not found");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}



function addClient($client) {
    global $conn;
    try {
        // generate a random reference
        $reference = rand(100000000, 999999999);
        
        $stmt = $conn->prepare("INSERT INTO client (first_name,last_name,phone,reference) VALUES (:first_name, :last_name, :phone,:reference)");
        $stmt->bindParam(':first_name', $client['first_name']);
        $stmt->bindParam(':last_name', $client['last_name']);
        $stmt->bindParam(':phone', $client['phone']);
        $stmt->bindParam(':reference', $reference);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 201,
                'message' => 'Client added successfully',
                'client' => $client,
                'reference' => $reference // return the generated reference in the response
            ];
            
            header('Content-Type: application/json'); // set the response header to JSON
            echo json_encode($data); // return the JSON response
            exit;
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to add client'
            ];
            
            header('Content-Type: application/json'); // set the response header to JSON
            echo json_encode($data); // return the JSON response
            exit;
        }
    } catch (PDOException $e) {
        $data = [
            'status' => 500,
            'message' => 'Query Failed: ' . $e->getMessage()
        ];
        
        header('Content-Type: application/json'); // set the response header to JSON
        echo json_encode($data); // return the JSON response
        exit;
    }
}



function deleteClient($clientId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM client WHERE clientId=:clientId");
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'client deleted successfully',
                'id' => $clientId
            ];
            header("HTTP/1.0 200 client deleted successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'client not found'
            ];
            header("HTTP/1.0 404 client not found");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
function updateClient($clientId, $client) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE client SET  first_name=:first_name, last_name=:last_name, phone=:phone WHERE clientId=:clientId");
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':first_name', $client['first_name']);
        $stmt->bindParam(':last_name', $client['last_name']);
        $stmt->bindParam(':phone', $client['phone']);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'client updated successfully',
                'client' => $client
            ];
            header("HTTP/1.0 200 client updated successfully");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Failed to update client'
            ];
            header("HTTP/1.0 500 Failed to update client");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }

}

//     function getClientByReference($reference)
// {
//     global $conn;
//     try {
//         $stmt = $conn->prepare("SELECT * FROM client WHERE reference=:reference");
//         $stmt->bindParam(':reference', $reference);
//         $stmt->execute();
//         $num_rows = $stmt->rowCount();
//         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         if ($num_rows > 0) {
//             $data = [
//                 'status' => 200,
//                 'message' => 'client found',
//                 'res' => $results,
//             ];
//             header("HTTP/1.0 200 client found");
//             return json_encode($data);
//         } else {
//             $data = [
//                 'status' => 404,
//                 'message' => 'client not found',
//             ];
//             header("HTTP/1.0 404 client not found");
//             return json_encode($data);
//         }
//     } catch (PDOException $e) {
//         die("Query Failed: " . $e->getMessage());
//     }
// }



