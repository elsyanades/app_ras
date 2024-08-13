<?php
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

if ($token) {
    try {
        $decoded = JWT::decode($token, new Key('rahasia', 'HS256'));
        echo json_encode(['success' => 'Token is valid', 'data' => $decoded]);
        http_response_code(200);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Invalid token']);
        http_response_code(401);
    }
} else {
    echo json_encode(['error' => 'Missing token']);
    http_response_code(400);
}
?>
