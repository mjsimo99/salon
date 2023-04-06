<?php
require '../inc/dbcon.php';




// function getRondiVoList($client_date, $hour) {
//     global $conn;
//     try {
//       $stmt = $conn->prepare("SELECT * FROM rondivo WHERE client_date = :client_date AND hour = :hour");
//       $stmt->bindParam(':client_date', $client_date);
//       $stmt->bindParam(':hour', $hour);
//       $stmt->execute();
//       $num_rows = $stmt->rowCount();
//       if ($stmt) {
//         if ($num_rows > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//           $data = [
//             'status' => 200,
//             'message' => 'RondiVo list retrieved successfully',
//             'reservedHours' => $results,
//           ];
//           return json_encode($data);
//         } else {
//           $data = [
//             'status' => 404,
//             'message' => 'No RondiVo Found',
//           ];
//           header("HTTP/1.0 404 No RondiVo Found");
//           return json_encode($data);
//         }
//       } else {
//         $data = [
//           'status' => 500,
//           'message' => 'Internal Server Error',
//         ];
//         header("HTTP/1.0 500 Internal Server Error");
//         return json_encode($data);
//       }
//     } catch (PDOException $e) {
//       die("Query Failed: " . $e->getMessage());
//     }
//   }
function getReservedHours($client_date)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT  hour , rdvid FROM rondivo WHERE client_date = :client_date");
        $stmt->bindParam(':client_date', $client_date);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($stmt) {
            if ($num_rows > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $data = [
                    'status' => 200,
                    'message' => 'Reserved hours retrieved successfully',
                    'reservedHours' => $results,
                ];
                return json_encode($data);
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'No RondiVo Found',
                ];
                header("HTTP/1.0 404 No RondiVo Found");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}


function addRondiVo($rondiVo) {
    global $conn;
    try {
        // Check if the user already has a reservation for the selected date
        $stmt = $conn->prepare("SELECT * FROM rondivo WHERE clientId = :clientId AND client_date = :client_date");
        $stmt->bindParam(':clientId', $rondiVo['clientId']);
        $stmt->bindParam(':client_date', $rondiVo['client_date']);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $data = [
                'status' => 400,
                'message' => 'You already have an appointment for this date'
            ];
            return json_encode($data);
        }
        
        // Check if there is any existing reservation for the selected hour and date
        // $stmt = $conn->prepare("SELECT * FROM rondivo WHERE client_date = :client_date AND hour = :hour");
        // $stmt->bindParam(':client_date', $rondiVo['client_date']);
        // $stmt->bindParam(':hour', $rondiVo['hour']);
        // $stmt->execute();
        // $num_rows = $stmt->rowCount();
        // if ($num_rows > 0) {
        //     $data = [
        //         'status' => 400,
        //         'message' => 'Hour is already reserved'
        //     ];
        //     return json_encode($data);
        // } 
        else {
            $stmt = $conn->prepare("INSERT INTO rondivo (clientId, client_date, hour) VALUES (:clientId, :client_date, :hour)");
            $stmt->bindParam(':clientId', $rondiVo['clientId']);
            $stmt->bindParam(':client_date', $rondiVo['client_date']);
            $stmt->bindParam(':hour', $rondiVo['hour']);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            if ($num_rows > 0) {
                $data = [
                    'status' => 201,
                    'message' => 'RondiVo added successfully',
                    'rondiVo' => $rondiVo
                ];
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Failed to add RondiVo'
                ];
                return json_encode($data);
            }
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}








function deleteRondivo($clientId, $clientDate, $hour) {
    global $conn;
    try {
      $stmt = $conn->prepare("DELETE FROM rondivo WHERE clientId = :clientId AND client_date = :clientDate AND hour = :hour");
      $stmt->bindParam(':clientId', $clientId);
      $stmt->bindParam(':clientDate', $clientDate);
      $stmt->bindParam(':hour', $hour);
      $stmt->execute();
      $num_rows = $stmt->rowCount();
      if ($num_rows > 0) {
        $data = array(
          'status' => 200,
          'message' => 'Reservation deleted successfully',
          'clientId' => $clientId,
          'clientDate' => $clientDate,
          'hour' => $hour,
        );
        header("HTTP/1.0 200 Reservation deleted successfully");
        return json_encode($data);
      } else {
        $data = array(
          'status' => 404,
          'message' => 'Reservation not found',
        );
        header("HTTP/1.0 404 Reservation not found");
        return json_encode($data);
      }
    } catch (PDOException $e) {
      die("Query Failed: " . $e->getMessage());
    }
  }
