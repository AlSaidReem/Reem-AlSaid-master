<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $bookingId = isset($_GET['id']) ? $_GET['id'] : null;

    if (!empty($bookingId)) {
        $sql = "DELETE FROM booking WHERE id = $bookingId";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Booking record deleted successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "No ID provided for deletion."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use DELETE method."));
}
?>


