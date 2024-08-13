<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_performance_review':
        require 'api/create_performance_review.php';
        break;
    case 'get_performance_review':
        require 'api/get_performance_review.php';
        break;
    case 'update_performance_review':
        require 'api/update_performance_review.php';
        break;
    case 'delete_performance_review':
        require 'api/delete_performance_review.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
        break;
}
?>
