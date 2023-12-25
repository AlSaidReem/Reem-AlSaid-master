<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    // Assuming you're sending the id as a query parameter
    $id = $_GET['id'];

    if (!empty($id)) {
        // For deleting a user
        $sql = "DELETE FROM tour WHERE id = $id"; 

        // Uncomment and modify the following lines for deleting a tour
        // $sql = "DELETE FROM tours WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record deleted successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "No ID provided for deletion."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use DELETE method."));
}
