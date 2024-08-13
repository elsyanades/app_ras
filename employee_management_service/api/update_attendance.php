<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $employee_id = $data['employee_id'] ?? null;
    $date = $data['date'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && ($employee_id || $date || $status)) {
        $updateFields = [];
        $params = [];

        if ($employee_id) {
            $updateFields[] = "employee_id = ?";
            $params[] = $employee_id;
        }

        if ($date) {
            $updateFields[] = "date = ?";
            $params[] = $date;
        }

        if ($status) {
            $updateFields[] = "status = ?";
            $params[] = $status;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Attendance SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";

        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Attendance updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
