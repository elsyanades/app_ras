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
$password = $data['password'] ?? null;

if ($username && $password) {
    // Query untuk mendapatkan id, password_hash, dan role pengguna
    $stmt = $conn->prepare("SELECT id, password_hash, role FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash, $role);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            // Generate JWT Token
            $token = generate_jwt($id);

            // Kirimkan respons JSON dengan token dan role
            echo json_encode([
                'success' => 'Login successful',
                'token' => $token,
                'role' => $role,
                'username' => $username,

            ]);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'Invalid username or password']);
            http_response_code(401);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
        http_response_code(404);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Missing required fields']);
    http_response_code(400);
}

$conn->close();
?>
