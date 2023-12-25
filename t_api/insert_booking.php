<?php
include 'connect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
   
    $requiredFields = ["user_id", "tour_id"];
    $allFieldsPresent = true;

    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            $allFieldsPresent = false;
            break;
        }
    }

    if ($allFieldsPresent) {
        // Sanitize and escape data to prevent SQL injection
        $userId = mysqli_real_escape_string($conn, $data['user_id']);
        $tourId = mysqli_real_escape_string($conn, $data['tour_id']);
        $bookingDate = date('Y-m-d'); // Set booking date to the current date

        // Check the available seats
        $checkSeatsQuery = "SELECT seats FROM tour WHERE id = '$tourId'";
        $checkSeatsResult = $conn->query($checkSeatsQuery);

        if ($checkSeatsResult->num_rows > 0) {
            $tourData = $checkSeatsResult->fetch_assoc();
            $availableSeats = $tourData['seats'];

            if ($availableSeats > 0) {
                // Update available seats and insert booking record
                $updatedSeats = $availableSeats - 1;

                $updateSeatsQuery = "UPDATE tour SET seats = $updatedSeats WHERE id = '$tourId'";
                $conn->query($updateSeatsQuery);

                $sql = "INSERT INTO booking (user_id, tour_id, booking_date) VALUES (
                    '$userId', '$tourId', '$bookingDate'
                )";

                if ($conn->query($sql) === TRUE) {
                    $message = "Booking successful. ";

                    if ($updatedSeats <= 3) {
                        $message .= "<span style='color: red;'>Only $updatedSeats seats left.</span>";
                    } else {
                        $message .= "Booking record created successfully.";
                    }

                    echo json_encode(array("message" => $message));
                } else {
                    echo json_encode(array("error" => "Error: " . $conn->error));
                }
            } else {
                echo json_encode(array("error" => "No available seats for the selected tour."));
            }
        } else {
            echo json_encode(array("error" => "Error checking available seats."));
        }
    } else {
        echo json_encode(array("error" => "Please provide all required fields."));
    }
} else {
    echo json_encode(array("error" => "No data received."));
}

$conn->close();
?>
