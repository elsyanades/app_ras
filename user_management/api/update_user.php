<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;
    $email = $data['email'] ?? null;
    $role = $data['role'] ?? null;

    if ($id && ($username || $password || $email || $role)) {
        $updateFields = [];
        $params = [];

        if ($username) {
            $updateFields[] = "username = ?";
            $params[] = $username;
        }

        if ($password) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $updateFields[] = "password_hash = ?";
            $params[] = $password_hash;
        }

        if ($email) {
            $updateFields[] = "email = ?";
            $params[] = $email;
        }

        if ($role) {
            $updateFields[] = "role = ?";
            $params[] = $role;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Users SET " . implode(', ', $updateFields) . " WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'User updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
