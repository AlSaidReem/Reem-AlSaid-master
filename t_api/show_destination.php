<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Retrieve a specific destination by ID
        $destinationId = $_GET['id'];
        $sql = "SELECT * FROM destinations WHERE id = $destinationId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $destination = $result->fetch_assoc();
            echo json_encode($destination);
        } else {
            echo json_encode(array("message" => "Destination with the provided ID not found."));
        }
    } else {
        // Retrieve all destinations
        $sql = "SELECT * FROM destinations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $destinations = array();
            while ($row = $result->fetch_assoc()) {
                $destinations[] = $row;
            }
            echo json_encode($destinations);
        } else {
            echo json_encode(array("message" => "No destination records found."));
        }
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
