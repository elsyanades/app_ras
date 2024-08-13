<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$employee_id = $data['employee_id'];
$review_date = $data['review_date'];
$reviewer_id = $data['reviewer_id'];
$rating = $data['rating'];
$comments = $data['comments'];

$sql = "UPDATE performance_reviews SET employee_id = ?, review_date = ?, reviewer_id = ?, rating = ?, comments = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issisi", $employee_id, $review_date, $reviewer_id, $rating, $comments, $id);

if ($stmt->execute()) {
    $response = [
        'id' => $id,
        'employee_id' => $employee_id,
        'review_date' => $review_date,
        'reviewer_id' => $reviewer_id,
        'rating' => $rating,
        'comments' => $comments,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    echo json_encode($response);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>
