<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $total_spent = $data['total_spent'] ?? null;
    $remaining_budget = $data['remaining_budget'] ?? null;

    if ($id && ($total_spent !== null || $remaining_budget !== null)) {
        $updateFields = [];
        $params = [];

        if ($total_spent !== null) {
            $updateFields[] = "total_spent = ?";
            $params[] = $total_spent;
        }

        if ($remaining_budget !== null) {
            $updateFields[] = "remaining_budget = ?";
            $params[] = $remaining_budget;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Budget_Reports SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Budget report updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
