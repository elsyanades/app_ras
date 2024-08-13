<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'] ?? null;
    $amount = $data['amount'] ?? null;
    $start_date = $data['start_date'] ?? null;
    $end_date = $data['end_date'] ?? null;

    if ($name && $amount && $start_date && $end_date) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Budgets (name, amount, start_date, end_date, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$name, $amount, $start_date, $end_date]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'name' => $name,
                'amount' => $amount,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            echo json_encode($response);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
