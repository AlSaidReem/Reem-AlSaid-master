<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Retrieve a specific booking by ID
        $bookingId = $_GET['id'];
        $sql = "SELECT booking.id, tour.id AS tourID, booking.user_id, users.username, tour.name AS tour_name, booking.booking_date
        FROM booking
        INNER JOIN users ON booking.user_id = users.id
        INNER JOIN tour ON booking.tour_id = tour.id
        WHERE booking.id = $bookingId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $booking = $result->fetch_assoc();
            echo json_encode($booking);
        } else {
            echo json_encode(array("message" => "Booking with the provided ID not found."));
        }
    } else {
        // Retrieve all bookings
        $sql = "SELECT booking.id, booking.user_id, users.username, tour.id AS tour_id, tour.name AS tour_name, booking.booking_date
        FROM booking
        INNER JOIN users ON booking.user_id = users.id
        INNER JOIN tour ON booking.tour_id = tour.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $bookings = array();
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            echo json_encode($bookings);
        } else {
            echo json_encode(array("message" => "No booking records found."));
        }
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
