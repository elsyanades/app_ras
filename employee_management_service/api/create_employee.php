<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $first_name = $data['first_name'] ?? null;
    $last_name = $data['last_name'] ?? null;
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $hire_date = $data['hire_date'] ?? null;
    $position = $data['position'] ?? null;
    $department = $data['department'] ?? null;
    $status = $data['status'] ?? null;

    if ($first_name && $last_name && $email && $phone && $hire_date && $position && $department && $status) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Employees (first_name, last_name, email, phone, hire_date, position, department, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$first_name, $last_name, $email, $phone, $hire_date, $position, $department, $status]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'hire_date' => $hire_date,
                'position' => $position,
                'department' => $department,
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
