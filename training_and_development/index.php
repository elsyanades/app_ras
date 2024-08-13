<?php
require_once 'config/database.php';

header("Content-Type: application/json");

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_training_program':
        require 'api/create_training_program.php';
        break;
    case 'get_training_program':
        require 'api/get_training_program.php';
        break;
    case 'update_training_program':
        require 'api/update_training_program.php';
        break;
    case 'delete_training_program':
        require 'api/delete_training_program.php';
        break;
    case 'create_certification':
        require 'api/create_certification.php';
        break;
    case 'get_certification':
        require 'api/get_certification.php';
        break;
    case 'update_certification':
        require 'api/update_certification.php';
        break;
    case 'delete_certification':
        require 'api/delete_certification.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
        break;
}

$conn->close();
?>
