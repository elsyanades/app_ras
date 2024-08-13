<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_budget':
        require 'api/create_budget.php';
        break;
    case 'get_budget':
        require 'api/get_budget.php';
        break;
    case 'update_budget':
        require 'api/update_budget.php';
        break;
    case 'delete_budget':
        require 'api/delete_budget.php';
        break;
    case 'create_budget_report':
        require 'api/create_budget_report.php';
        break;
    case 'get_budget_report':
        require 'api/get_budget_report.php';
        break;
    case 'update_budget_report':
        require 'api/update_budget_report.php';
        break;
    case 'delete_budget_report':
        require 'api/delete_budget_report.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
}
