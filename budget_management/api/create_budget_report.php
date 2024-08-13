<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $budget_id = $data['budget_id'] ?? null;
    $report_date = $data['report_date'] ?? null;
    $total_spent = $data['total_spent'] ?? null;
    $remaining_budget = $data['remaining_budget'] ?? null;

    if ($budget_id && $report_date && $total_spent !== null && $remaining_budget !== null) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Budget_Reports (budget_id, report_date, total_spent, remaining_budget, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$budget_id, $report_date, $total_spent, $remaining_budget]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'budget_id' => $budget_id,
                'report_date' => $report_date,
                'total_spent' => $total_spent,
                'remaining_budget' => $remaining_budget,
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
