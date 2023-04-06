<?php
$user = "root";
$pass = "";

try {
$conn = new PDO('mysql:host=localhost;dbname=salon', $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
?>