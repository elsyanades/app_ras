<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $name = $data['name'] ?? null;
    $amount = $data['amount'] ?? null;
    $start_date = $data['start_date'] ?? null;
    $end_date = $data['end_date'] ?? null;

    if ($id && ($name || $amount || $start_date || $end_date)) {
        $updateFields = [];
        $params = [];

        if ($name) {
            $updateFields[] = "name = ?";
            $params[] = $name;
        }

        if ($amount) {
            $updateFields[] = "amount = ?";
            $params[] = $amount;
        }

        if ($start_date) {
            $updateFields[] = "start_date = ?";
            $params[] = $start_date;
        }

        if ($end_date) {
            $updateFields[] = "end_date = ?";
            $params[] = $end_date;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Budgets SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Budget updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
