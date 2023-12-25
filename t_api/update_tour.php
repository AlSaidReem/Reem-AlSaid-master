<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
$conn = mysqli_connect("localhost", "root", "", "tourism_agency");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Retrieve raw input data
    $input_data = file_get_contents("php://input");

    if (!$input_data) {
        echo json_encode(['message' => 'No data received']);
        exit;
    }

    $data = json_decode($input_data, true);

    if ($data === null || !isset($data['id'])) {
        echo json_encode(['message' => 'Invalid JSON data or missing ID']);
        exit;
    }

    // Extract data from JSON
    $id = $data['id'];

    // Fetch existing data based on ID
    $querySelect = 'SELECT * FROM tour WHERE id = ?';
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param('i', $id);
    $stmtSelect->execute();

    $resultSelect = $stmtSelect->get_result();
    $existingData = $resultSelect->fetch_assoc();

    $stmtSelect->close();

    // Check if the record exists
    if (!$existingData) {
        echo json_encode(['message' => 'Tour not found']);
        exit;
    }

    // Use existing data to populate form fields if not provided in the request
    $name = isset($data['name']) ? $data['name'] : $existingData['name'];
    $description = isset($data['description']) ? $data['description'] : $existingData['description'];
    $destination_id = isset($data['destination_id']) ? $data['destination_id'] : $existingData['destination_id'];
    $date = isset($data['date']) ? $data['date'] : $existingData['date'];
    $price = isset($data['price']) ? $data['price'] : $existingData['price'];
    $seats = isset($data['seats']) ? $data['seats'] : $existingData['seats'];
    $tour_guide_id = isset($data['tour_guide_id']) ? $data['tour_guide_id'] : $existingData['tour_guide_id'];

    // Handle multiple image upload
    $existingImages = []; // You might need to fetch existing images if stored

    // Handle image upload only if new images are provided
    if (!empty($data['images'])) {
        $imageArray = array();

        foreach ($data['images'] as $key => $value) {
            $img_name = time() . '_' . $value['name'];
            $img_path = './tourism-agency/tourism/src/' . $img_name;

            file_put_contents($img_path, base64_decode($value['data']));

            // Add the image name to the array
            $imageArray[] = $img_name;
        }

        // Check if images were uploaded
        $img = (!empty($imageArray)) ? implode(', ', $imageArray) : null;
    } else {
        // Use existing images if no new images are provided
        $img = $existingData['image'];
    }

    // Update query
    $query = 'UPDATE tour SET name=?, image=?, date=?, destination_id=?, description=?, price=?, seats=?, tour_guide_id=? WHERE id=?';
    $stmt = $conn->prepare($query);

    $stmt->bind_param('sssissiii', $name, $img, $date, $destination_id, $description, $price, $seats, $tour_guide_id, $id);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['message' => 'Tour updated successfully']);
    } else {
        echo json_encode(['message' => 'Failed to update the tour']);
    }

    $stmt->close();
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>


