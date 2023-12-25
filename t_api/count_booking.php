<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

$response = array();

if ($conn) {
    $sql = "SELECT COUNT(*) FROM booking";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Content-Type: application/json");

        $row = mysqli_fetch_assoc($result); 

        $response['number_booking'] = $row['COUNT(*)'];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
} else {
    echo "Database connection failed";
}
?>