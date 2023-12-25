<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
$conn = mysqli_connect("localhost", "root", "", "tourism_agency");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $destination_id = $_POST['destination_id'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $seats = $_POST['seats'];
    $tour_guide_id = $_POST['tour_guide_id'];

    // Handle multiple image upload
    $imageArray = array();

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $value) {
            $img_name = time() . '_' . $_FILES['images']['name'][$key];
            $img_path = 'C:\xampp\htdocs\tourism\images\\' . $img_name; // Use a relative path

            move_uploaded_file($_FILES['images']['tmp_name'][$key], $img_path);

            // Add the image name to the array
            $imageArray[] = $img_name;
        }
    }   

    // Check if images were uploaded
    $img = (!empty($imageArray)) ? implode(', ', $imageArray) : null;

    // Fixed the query and removed extra comma at the end of the columns
    $query = 'INSERT INTO tour (name, image, date, destination_id, description, price, seats, tour_guide_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($query);

    $stmt->bind_param('sssissii', $name, $img, $date, $destination_id, $description, $price, $seats, $tour_guide_id);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['message' => 'Tour inserted successfully']);
    } else {
        echo json_encode(['message' => 'Failed to insert the tour']);
    }

    $stmt->close();
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
