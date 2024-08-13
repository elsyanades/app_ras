<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'create_employee':
        require 'api/create_employee.php';
        break;
    case 'get_employee':
        require 'api/get_employee.php';
        break;
    case 'update_employee':
        require 'api/update_employee.php';
        break;
    case 'delete_employee':
        require 'api/delete_employee.php';
        break;
    case 'create_attendance':
        require 'api/create_attendance.php';
        break;
    case 'get_attendance':
        require 'api/get_attendance.php';
        break;
    case 'update_attendance':
        require 'api/update_attendance.php';
        break;
    case 'delete_attendance':
        require 'api/delete_attendance.php';
        break;
    case 'create_leave':
        require 'api/create_leave.php';
        break;
    case 'get_leave':
        require 'api/get_leave.php';
        break;
    case 'update_leave':
        require 'api/update_leave.php';
        break;
    case 'delete_leave':
        require 'api/delete_leave.php';
        break;
    default:
        echo json_encode(['error' => 'Invalid endpoint']);
        break;
}
