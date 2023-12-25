<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

$response = array();

if ($conn) {
    $destinationId = 2; // Replace with the desired destination ID

    $sql = "SELECT COUNT(*) FROM tour WHERE destination_id = $destinationId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Content-Type: application/json");

        $row = mysqli_fetch_assoc($result);

        $response['number_tour'] = $row['COUNT(*)'];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
} else {
    echo "Database connection failed";
}
?>

