<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';

        // Update the destination_id condition to the desired value (in this case, destination_id = 2)
        $sql = "SELECT * FROM tour WHERE name LIKE ? AND destination_id = 2";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tours = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($tours);
        } else {
            echo json_encode(array("message" => "No tours found with the provided name and destination ID."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "The 'search' parameter is required."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
?>
