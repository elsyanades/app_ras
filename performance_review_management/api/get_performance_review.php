<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT * FROM performance_reviews WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $review = $result->fetch_assoc();
    echo json_encode($review);
    http_response_code(200);
} else {
    echo json_encode(['error' => 'Performance review not found.']);
    http_response_code(404);
}

$stmt->close();
$conn->close();
?>
