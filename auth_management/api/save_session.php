<?php
session_start(); // Start session

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? null;
$role = $data['role'] ?? null;

if ($token && $role) {
    try {
        // Decode the token
        $decoded = JWT::decode($token, new Key('rahasia', 'HS256'));
        $_SESSION['token'] = $token; // Save token in session
        $_SESSION['role'] = $role; // Save role in session

        echo json_encode(['success' => 'Token saved and session updated']);
        http_response_code(200);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Invalid token']);
        http_response_code(401);
    }
} else {
    echo json_encode(['error' => 'Missing token or role']);
    http_response_code(400);
}
