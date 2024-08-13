<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'create_user':
        require 'api/create_user.php';
        break;
    case 'get_user':
        require 'api/get_user.php';
        break;
    case 'update_user':
        require 'api/update_user.php';
        break;
    case 'delete_user':
        require 'api/delete_user.php';
        break;
    default:
        echo json_encode(['error' => 'Invalid endpoint']);
        break;
}
