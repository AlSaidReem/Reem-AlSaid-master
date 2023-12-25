<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Retrieve a specific user by ID
        $userId = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = $userId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            echo json_encode(array("message" => "User with the provided ID not found."));
        }
    } else {
        if (isset($_GET['role'])) {
            $role = $_GET['role'];

            if ($role === 'users') {
                // Retrieve all regular users
                $sql = "SELECT * FROM users WHERE role = 'users'";
            } elseif ($role === 'tour guide') {
                // Retrieve all tour guides
                $sql = "SELECT * FROM users WHERE role = 'tour guide'";
            } elseif ($role === 'admin') {
              
                    $sql = "SELECT * FROM users WHERE role = 'admin'";
            } else {
                echo json_encode(array("error" => "Invalid 'role' parameter value."));
                exit;
            }

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
            echo json_encode(array("error" => "Please provide the 'role' parameter."));
        }
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
