<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_expense':
        require 'api/create_expense.php';
        break;
    case 'get_expense':
        require 'api/get_expense.php';
        break;
    case 'update_expense':
        require 'api/update_expense.php';
        break;
    case 'delete_expense':
        require 'api/delete_expense.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
}
?>
