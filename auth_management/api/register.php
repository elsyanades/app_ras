<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? null;
$name = $data['name'] ?? null;
$password = $data['password'] ?? null;
$email = $data['email'] ?? null;
$role = $data['role'] ?? 'employee'; // Default role jika tidak ada yang diberikan

if ($username && $password && $email && $role) {
    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (username, name, password_hash, email, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("sssss", $username, $name, $password_hash, $email, $role);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'User registered successfully']);
        http_response_code(201);
    } else {
        echo json_encode(['error' => 'Database error: ' . $stmt->error]);
        http_response_code(500);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Missing required fields']);
    http_response_code(400);
}

$conn->close();
?>
