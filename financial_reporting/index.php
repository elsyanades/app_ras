<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_report':
        require 'api/create_report.php';
        break;
    case 'get_report':
        require 'api/get_report.php';
        break;
    case 'update_report':
        require 'api/update_report.php';
        break;
    case 'delete_report':
        require 'api/delete_report.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
}
