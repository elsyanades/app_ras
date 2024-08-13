<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generate_jwt($user_id) {
    $key = 'rahasia'; // Ganti dengan kunci rahasia Anda
    $payload = [
        'iss' => 'http://localhost',
        'iat' => time(),
        'exp' => time() + 3600, // Token valid untuk 1 jam
        'sub' => $user_id
    ];

    return JWT::encode($payload, $key, 'HS256');
}

// Include Composer autoload if not already included
require_once __DIR__ . '/../vendor/autoload.php';
?>
