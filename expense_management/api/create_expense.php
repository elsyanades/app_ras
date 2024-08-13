<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$expense_number = $data['expense_number'] ?? null;
$employee_id = $data['employee_id'] ?? null;
$amount = $data['amount'] ?? null;
$date = $data['date'] ?? null;
$description = $data['description'] ?? null;

if ($expense_number && $employee_id && $amount !== null && $date && $description !== null) {
    $stmt = $conn->prepare("INSERT INTO Expenses (expense_number, employee_id, amount, date, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("siiss", $expense_number, $employee_id, $amount, $date, $description);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'expense_number' => $expense_number,
            'employee_id' => $employee_id,
            'amount' => $amount,
            'date' => $date,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        http_response_code(201);
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
