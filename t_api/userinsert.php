<?php

include 'connect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    $requiredFields = ['username', 'password', 'email', 'phone_number','role'];
    $allFieldsPresent = true;
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            $allFieldsPresent = false;
            break;
        }
    }

    if ($allFieldsPresent) {
        // Default role is "users" unless specified
        // $role = isset($data['role']) ? $data['role'] : 'users';

        $sql = "INSERT INTO users (username, password, email, phone_number, role) VALUES (
            '{$data['username']}',
            '{$hashedPassword}',
            '{$data['email']}',
            '{$data['phone_number']}',
            '{$data['role']}'
        )";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "User record created successfully."));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Please provide all required fields."));
    }
} else {
    echo json_encode(array("error" => "No data received."));
}
?>
