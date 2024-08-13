<?php
require_once __DIR__ . '/../../config/database.php'; // Menyertakan file koneksi database
require_once __DIR__ . '/../../config/jwt.php'; // Menyertakan file JWT untuk token

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? null;
$new_password = $data['password'] ?? null;

if ($token && $new_password) {
    // Verifikasi token
    $stmt = $conn->prepare("SELECT user_id, expires_at FROM passwordresets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        $user_id = $reset['user_id'];

        // Hash password baru
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        // Update password pengguna
        $stmt = $conn->prepare("UPDATE Users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $user_id);

        if ($stmt->execute()) {
            // Hapus token reset setelah berhasil
            $stmt = $conn->prepare("DELETE FROM PasswordResets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            echo json_encode(['success' => 'Password updated successfully']);
            http_response_code(200);
        } else {
            echo json_encode(['error' => 'Failed to update password']);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid or expired token']);
        http_response_code(400);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Token and new password are required']);
    http_response_code(400);
}

$conn->close();
?>
