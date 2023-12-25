<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Extract review ID from the URL
    $reviewId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($reviewId !== null) {
        // Check if the review exists
        $checkReviewQuery = "SELECT * FROM reviews WHERE id = $reviewId";
        $checkReviewResult = $conn->query($checkReviewQuery);

        if ($checkReviewResult->num_rows > 0) {
            $existingData = $checkReviewResult->fetch_assoc();

            $data = json_decode(file_get_contents('php://input'), true);

            $updateFields = array();

            // Loop through all columns in the 'reviews' table and construct the update query
            foreach ($existingData as $key => $value) {
                if (isset($data[$key]) && $key !== 'id') {
                    $updateFields[] = "$key = '" . ($data[$key] !== null ? $data[$key] : $value) . "'";
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE reviews SET " . implode(', ', $updateFields) . " WHERE id = $reviewId";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(array("message" => "Review details updated successfully."));
                } else {
                    echo json_encode(array("error" => "Error updating review details: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "No fields to update provided."));
            }
        } else {
            echo json_encode(array("error" => "Review not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the review ID in the URL."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}

$conn->close();
?>
