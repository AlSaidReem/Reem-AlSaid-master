<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve tour guide usernames
    $sql = "SELECT id, username FROM users WHERE role = 'tour guide'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
    } else {
        echo json_encode(array("message" => "No records found for the specified role."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
