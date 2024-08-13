<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_salary':
        require 'api/create_salary.php';
        break;
    case 'get_salary':
        require 'api/get_salary.php';
        break;
    case 'update_salary':
        require 'api/update_salary.php';
        break;
    case 'delete_salary':
        require 'api/delete_salary.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
}
