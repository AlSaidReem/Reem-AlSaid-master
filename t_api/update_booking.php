<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Extract booking ID from the URL
    $bookingId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($bookingId !== null) {
        // Check if the booking exists
        $checkBookingQuery = "SELECT * FROM booking WHERE id = $bookingId";
        $checkBookingResult = $conn->query($checkBookingQuery);

        if ($checkBookingResult->num_rows > 0) {
            $existingData = $checkBookingResult->fetch_assoc();

            $data = json_decode(file_get_contents('php://input'), true);

            $updateFields = array();

            // Loop through all columns in the 'booking' table and construct the update query
            foreach ($existingData as $key => $value) {
                if (isset($data[$key]) && $key !== 'id') {
                    $updateFields[] = "$key = '" . ($data[$key] !== null ? $data[$key] : $value) . "'";
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE booking SET " . implode(', ', $updateFields) . " WHERE id = $bookingId";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(array("message" => "Booking details updated successfully."));
                } else {
                    echo json_encode(array("error" => "Error updating booking details: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "No fields to update provided."));
            }
        } else {
            echo json_encode(array("error" => "Booking not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the booking ID in the URL."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}

$conn->close();
?>

