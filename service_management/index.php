<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_service':
        require 'api/create_service.php';
        break;
    case 'get_service':
        require 'api/get_service.php';
        break;
    case 'update_service':
        require 'api/update_service.php';
        break;
    case 'delete_service':
        require 'api/delete_service.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
}
?>
