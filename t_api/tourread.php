<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Retrieve a specific tour by ID
        $tourId = $_GET['id'];
        $sql = "SELECT tour.*, users.username AS tour_guide_username
                FROM tour
                INNER JOIN users ON tour.tour_guide_id = users.id
                WHERE tour.id = $tourId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tour = $result->fetch_assoc();
            echo json_encode($tour);
        } else {
            echo json_encode(array("message" => "Tour with the provided ID not found."));
        }
    } elseif (isset($_GET['destination_id'])) {
        // Retrieve tours based on destination_id
        $destinationId = $_GET['destination_id'];
        $sql = "SELECT tour.*, users.username AS tour_guide_username
                FROM tour
                INNER JOIN users ON tour.tour_guide_id = users.id
                WHERE tour.destination_id = $destinationId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tours = array();
            while ($row = $result->fetch_assoc()) {
                $tours[] = $row;
            }
            echo json_encode($tours);
        } else {
            echo json_encode(array("message" => "No tours found for destination_id = $destinationId."));
        }
    } else {
        echo json_encode(array("error" => "The 'destination_id' parameter is required."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
