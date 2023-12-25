<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['from']) && isset($_GET['to'])) {
        $startDate = $_GET['from'];
        $endDate = $_GET['to'];
        $destinationId = 1;  // Set the destination ID to 1

        // Using prepared statements to prevent SQL injection
        $sql = "SELECT * FROM tour WHERE date BETWEEN ? AND ? AND destination_id = ? ORDER BY date ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $startDate, $endDate, $destinationId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tours = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($tours);
        } else {
            echo json_encode(array("message" => "No tours found between the provided dates and destination ID."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "The 'from' and 'to' parameters are required."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
?>
