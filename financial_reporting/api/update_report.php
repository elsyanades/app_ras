<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $report_type = $data['report_type'] ?? null;
    $report_date = $data['report_date'] ?? null;
    $content = $data['content'] ?? null;

    if ($id && ($report_type || $report_date || $content)) {
        $updateFields = [];
        $params = [];

        if ($report_type) {
            $updateFields[] = "report_type = ?";
            $params[] = $report_type;
        }

        if ($report_date) {
            $updateFields[] = "report_date = ?";
            $params[] = $report_date;
        }

        if ($content) {
            $updateFields[] = "content = ?";
            $params[] = $content;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Financial_Reports SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Report updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
