<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_job_opening':
        require 'api/create_job_opening.php';
        break;
    case 'get_job_opening':
        require 'api/get_job_opening.php';
        break;
    case 'update_job_opening':
        require 'api/update_job_opening.php';
        break;
    case 'delete_job_opening':
        require 'api/delete_job_opening.php';
        break;
    case 'create_application':
        require 'api/create_application.php';
        break;
    case 'get_application':
        require 'api/get_application.php';
        break;
    case 'update_application':
        require 'api/update_application.php';
        break;
    case 'delete_application':
        require 'api/delete_application.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
}
