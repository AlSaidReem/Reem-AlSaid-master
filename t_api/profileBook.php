<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $userid = $data['id'];
        $sql = "SELECT booking.id as booking_id, tour.name, tour.image, tour.date, tour.description, tour.price, booking.booking_date 
        FROM booking 
        JOIN users ON users.id = booking.user_id 
        JOIN tour ON tour.id = booking.tour_id 
        WHERE users.id = $userid";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $events = array();
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
            echo json_encode($events);
        } else {
            echo json_encode(array("message" => "category with the provided ID not found."));
        }
    } else {
        echo json_encode(array("error" => "Please provide the user id."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
$conn->close();




//<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");
// include 'connect.php';


// if ($_SERVER['REQUEST_METHOD'] == "POST") {

//     $data = json_decode(file_get_contents('php://input'), true);
//     if (isset($data['id'])) {
//         $userid = $data['id'];
//         $sql = "SELECT  tour.name,tour.image,tour.date,tour.description,tour.price,booking.booking_date booking FROM booking JOIN users
//          ON users.id=booking.user_id JOIN tour ON tour.id=booking.tour_id WHERE users.id =$userid";
//         $result = $conn->query($sql);
//         if ($result->num_rows > 0) {
//             $events = array();
//             while ($row = $result->fetch_assoc()) {
//                 $events[] = $row;
//             }
//             echo json_encode($events);
//         } else {
//             echo json_encode(array("message" => "category with the provided ID not found."));
//         }
//     } else {
//         echo json_encode(array("error" => "Please provide the user id."));
//     }
// } else {
//     echo json_encode(array("error" => "Invalid request method."));
// }
// $conn->close();



