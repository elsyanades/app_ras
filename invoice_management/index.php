<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_invoice':
        require 'api/create_invoice.php';
        break;
    case 'get_invoice':
        require 'api/get_invoice.php';
        break;
    case 'update_invoice':
        require 'api/update_invoice.php';
        break;
    case 'delete_invoice':
        require 'api/delete_invoice.php';
        break;
    case 'create_payment':
        require 'api/create_payment.php';
        break;
    case 'get_payment':
        require 'api/get_payment.php';
        break;
    case 'update_payment':
        require 'api/update_payment.php';
        break;
    case 'delete_payment':
        require 'api/delete_payment.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
}
