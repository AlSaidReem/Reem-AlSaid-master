<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $reviewId = isset($_GET['id']) ? $_GET['id'] : null;

    if (!empty($reviewId)) {
        $sql = "DELETE FROM reviews WHERE id = $reviewId";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Review record deleted successfully."));
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
