<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && isset($data['booking_id'])) {
        $userid = $data['id'];
        $bookingId = $data['booking_id'];

        // Retrieve booking information before deletion
        $selectSql = "SELECT * FROM booking WHERE user_id = $userid AND id = $bookingId";
        $selectResult = $conn->query($selectSql);

        if ($selectResult->num_rows > 0) {
            $bookingData = $selectResult->fetch_assoc();
            $tourId = $bookingData['tour_id'];

            // Delete the booking
            $deleteSql = "DELETE FROM booking WHERE user_id = $userid AND id = $bookingId";
            $deleteResult = $conn->query($deleteSql);

            if ($deleteResult) {
                // Increase available seats for the tour
                
                 $updateSeatsSql = "UPDATE tour SET seats = seats + 1 WHERE id = $tourId";
                 $updateSeatsResult = $conn->query($updateSeatsSql);


                if ($updateSeatsResult) {
                    echo json_encode(array("message" => "Booking deleted successfully. Available seats updated."));
                } else {
                    echo json_encode(array("error" => "Failed to update available seats."));
                }
            } else {
                echo json_encode(array("error" => "Failed to delete booking."));
            }
        } else {
            echo json_encode(array("error" => "Booking not found for the specified user and booking id."));
        }
    } else {
        echo json_encode(array("error" => "Please provide both the user id and booking id to delete."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}

$conn->close();
?>
