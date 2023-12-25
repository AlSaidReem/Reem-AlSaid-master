<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['tour_guide_id'])) {
        $tourGuideId = $_GET['tour_guide_id'];

        // Select all tours related to the specified tour guide
        $sql = "SELECT name, image, date, description, price FROM tour WHERE tour_guide_id = $tourGuideId";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tours = array();
            while ($row = $result->fetch_assoc()) {
                $tours[] = $row;
            }
            echo json_encode($tours);
        } else {
            echo json_encode(array("message" => "No tours found for the specified tour guide."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the tour guide id."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
