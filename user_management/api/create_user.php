<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;
    $email = $data['email'] ?? null;
    $role = $data['role'] ?? null;

    if ($username && $password && $email && $role) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO Users (username, password_hash, email, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $password_hash, $email, $role]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s')
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
