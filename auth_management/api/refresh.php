<?php
session_start();

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

        // Proses untuk membuat token baru
        $now = new DateTimeImmutable();
        $future = $now->modify('+1 hour');
        $serverName = "http://localhost/app/"; // ganti dengan domain server Anda

        $newTokenPayload = [
            'iat' => $now->getTimestamp(),  // waktu dibuat
            'nbf' => $now->getTimestamp(),  // waktu mulai berlaku
            'exp' => $future->getTimestamp(), // waktu kadaluarsa
            'iss' => $serverName,           // siapa yang mengeluarkan token
            // 'data' => [
            //     'userId' => $decoded->data->userId,
            //     'role' => $decoded->data->role,
            // ]
        ];

        $newToken = JWT::encode($newTokenPayload, 'rahasia', 'HS256');

        // Simpan token baru di session
        $_SESSION['token'] = $newToken;

        echo json_encode(['token' => $newToken]);
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
