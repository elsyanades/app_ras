<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $report_type = $data['report_type'] ?? null;
    $report_date = $data['report_date'] ?? null;
    $content = $data['content'] ?? null;

    if ($report_type && $report_date && $content) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Financial_Reports (report_type, report_date, content, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->execute([$report_type, $report_date, $content]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'report_type' => $report_type,
                'report_date' => $report_date,
                'content' => $content,
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
