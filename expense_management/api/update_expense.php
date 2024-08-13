<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$expense_number = $data['expense_number'] ?? null;
$employee_id = $data['employee_id'] ?? null;
$amount = $data['amount'] ?? null;
$date = $data['date'] ?? null;
$description = $data['description'] ?? null;

if ($id && $expense_number && $employee_id && $amount !== null && $date && $description !== null) {
    $stmt = $conn->prepare("UPDATE Expenses SET expense_number = ?, employee_id = ?, amount = ?, date = ?, description = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("siissi", $expense_number, $employee_id, $amount, $date, $description, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Expense updated successfully']);
        http_response_code(200);
    } else {
        echo json_encode(['error' => $stmt->error]);
        http_response_code(500);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Missing required fields']);
    http_response_code(400);
}

$conn->close();
?>
