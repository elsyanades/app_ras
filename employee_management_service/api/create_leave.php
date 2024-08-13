<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $employee_id = $data['employee_id'] ?? null;
    $leave_type = $data['leave_type'] ?? null;
    $start_date = $data['start_date'] ?? null;
    $end_date = $data['end_date'] ?? null;
    $status = $data['status'] ?? null;

    if ($employee_id && $leave_type && $start_date && $end_date && $status) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Leaves (employee_id, leave_type, start_date, end_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$employee_id, $leave_type, $start_date, $end_date, $status]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'employee_id' => $employee_id,
                'leave_type' => $leave_type,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status,
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
