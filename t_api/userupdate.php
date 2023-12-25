<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Extract user ID from the URL
    $userId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($userId !== null) {
        // Check if the user exists
        $checkUserQuery = "SELECT * FROM users WHERE id = $userId";
        $checkUserResult = $conn->query($checkUserQuery);

        if ($checkUserResult->num_rows > 0) {
            $existingData = $checkUserResult->fetch_assoc();

            $data = json_decode(file_get_contents('php://input'), true);

            $updateFields = array();

            // Loop through all columns in the 'users' table and construct the update query
            foreach ($existingData as $key => $value) {
                if ($key === 'password' && isset($data[$key])) {
                    // Hash the updated password
                    $updateFields[] = "$key = '" . password_hash($data[$key], PASSWORD_DEFAULT) . "'";
                } elseif (isset($data[$key]) && $key !== 'Id') {
                    $updateFields[] = "$key = '" . ($data[$key] !== null ? $data[$key] : $value) . "'";
                }
            }

            if (!empty($updateFields)) {
                $updateQuery = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = $userId";

                if ($conn->query($updateQuery) === TRUE) {
                    echo json_encode(array("message" => "User details updated successfully."));
                } else {
                    echo json_encode(array("error" => "Error updating user details: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "No fields to update provided."));
            }
        } else {
            echo json_encode(array("error" => "User not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the user ID in the URL."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method. Please use PUT method."));
}

$conn->close();
?>
