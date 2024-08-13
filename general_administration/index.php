<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'create_document':
        require 'api/create_document.php';
        break;
    case 'get_document':
        require 'api/get_document.php';
        break;
    case 'update_document':
        require 'api/update_document.php';
        break;
    case 'delete_document':
        require 'api/delete_document.php';
        break;
    case 'upload_document':
        require 'api/upload_document.php';
        break;
    default:
        echo json_encode(['error' => 'Invalid endpoint']);
        break;
}
