<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Pastikan ini memuat autoloader Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? null;

if ($email) {
    // Cek apakah email ada di database (contoh, ganti dengan logika sebenarnya)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Buat token reset password
        $token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare("INSERT INTO passwordresets (email, token, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        // Kirim email menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; // Ganti dengan server SMTP Anda
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your-email@example.com'; // Ganti dengan email Anda
            $mail->Password   = 'your-email-password'; // Ganti dengan password email Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('no-reply@example.com', 'Your App');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'To reset your password, please click <a href="http://localhost/app/frontend/reset_password.php?token=' . $token . '">here</a>.';

            $mail->send();
            echo json_encode(['success' => 'Password reset link sent']);
            http_response_code(200);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'No account found with that email address']);
        http_response_code(404);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Email address is required']);
    http_response_code(400);
}

$conn->close();
