<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $employee_id = $data['employee_id'] ?? null;
    $leave_type = $data['leave_type'] ?? null;
    $start_date = $data['start_date'] ?? null;
    $end_date = $data['end_date'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && ($employee_id || $leave_type || $start_date || $end_date || $status)) {
        $updateFields = [];
        $params = [];

        if ($employee_id) {
            $updateFields[] = "employee_id = ?";
            $params[] = $employee_id;
        }

        if ($leave_type) {
            $updateFields[] = "leave_type = ?";
            $params[] = $leave_type;
        }

        if ($start_date) {
            $updateFields[] = "start_date = ?";
            $params[] = $start_date;
        }

        if ($end_date) {
            $updateFields[] = "end_date = ?";
            $params[] = $end_date;
        }

        if ($status) {
            $updateFields[] = "status = ?";
            $params[] = $status;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Leaves SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";

        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Leave updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
