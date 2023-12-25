<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Extract destination ID from the URL
    $destinationId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($destinationId !== null) {
        // Check if the destination exists
        $checkDestinationQuery = "SELECT * FROM destinations WHERE id = $destinationId";
        $checkDestinationResult = $conn->query($checkDestinationQuery);

        if ($checkDestinationResult->num_rows > 0) {
            $existingData = $checkDestinationResult->fetch_assoc();

            $data = json_decode(file_get_contents('php://input'), true);

            $updateFields = array();

            // Loop through all columns in the 'destinations' table and construct the update query
            foreach ($existingData as $key => $value) {
                if (isset($data[$key]) && $key !== 'id') {
                    $updateFields[] = "$key = '" . ($data[$key] !== null ? $data[$key] : $value) . "'";
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE destinations SET " . implode(', ', $updateFields) . " WHERE id = $destinationId";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(array("message" => "Destination details updated successfully."));
                } else {
                    echo json_encode(array("error" => "Error updating destination details: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "No fields to update provided."));
            }
        } else {
            echo json_encode(array("error" => "Destination not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the destination ID in the URL."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}

$conn->close();
?>
