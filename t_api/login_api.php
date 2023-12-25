<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST,PUT');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

class Connection {
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $dbname = "tourism_agency";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

class Login extends Connection {
    private $id;

    public function login($email, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM users WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
    
        if (mysqli_num_rows($result) > 0) {
            if (password_verify($password, $row["password"])) {
                // Assuming you want to return both user id and role
                $user_id = $row["id"];
                $role = $row["role"];
                
                return ['user_id' => $user_id, 'role' => $role];
            } else {
                return ['status' => 10, 'message' => 'Password is incorrect'];
            }
        } else {
            return ['status' => 10, 'message' => 'User not found'];
        }
    }
    

    public function getUserId() {
        return $this->id;
    }
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data["email"]) && isset($data["password"])) {
        $email = $data["email"];
        $password = $data["password"];

        $login = new Login();
        $result = $login->login($email, $password);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    } else {
        // Invalid JSON input
        $response = ['status' => 'error', 'message' => 'Invalid JSON input'];

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}


?>