<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $first_name = $data['first_name'] ?? null;
    $last_name = $data['last_name'] ?? null;
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $hire_date = $data['hire_date'] ?? null;
    $position = $data['position'] ?? null;
    $department = $data['department'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && ($first_name || $last_name || $email || $phone || $hire_date || $position || $department || $status)) {
        $updateFields = [];
        $params = [];

        if ($first_name) {
            $updateFields[] = "first_name = ?";
            $params[] = $first_name;
        }

        if ($last_name) {
            $updateFields[] = "last_name = ?";
            $params[] = $last_name;
        }

        if ($email) {
            $updateFields[] = "email = ?";
            $params[] = $email;
        }

        if ($phone) {
            $updateFields[] = "phone = ?";
            $params[] = $phone;
        }

        if ($hire_date) {
            $updateFields[] = "hire_date = ?";
            $params[] = $hire_date;
        }

        if ($position) {
            $updateFields[] = "position = ?";
            $params[] = $position;
        }

        if ($department) {
            $updateFields[] = "department = ?";
            $params[] = $department;
        }

        if ($status) {
            $updateFields[] = "status = ?";
            $params[] = $status;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Employees SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";

        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Employee updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
