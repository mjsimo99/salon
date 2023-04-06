<?php
require '../inc/dbcon.php';

function getClientByReference($reference)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM client WHERE reference=:reference");
        $stmt->bindParam(':reference', $reference);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($num_rows > 0) {
            $data = [
                'status' => 200,
                'message' => 'Client found',
                'client' => $results[0],
            ];
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Client not found',
            ];
            // header("HTTP/1.0 404 Client not found");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}





