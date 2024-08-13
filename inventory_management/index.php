<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_inventory_item':
        require 'api/create_inventory_item.php';
        break;
    case 'get_inventory_item':
        require 'api/get_inventory_item.php';
        break;
    case 'update_inventory_item':
        require 'api/update_inventory_item.php';
        break;
    case 'delete_inventory_item':
        require 'api/delete_inventory_item.php';
        break;
    case 'create_supplier':
        require 'api/create_supplier.php';
        break;
    case 'get_supplier':
        require 'api/get_supplier.php';
        break;
    case 'update_supplier':
        require 'api/update_supplier.php';
        break;
    case 'delete_supplier':
        require 'api/delete_supplier.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
}
?>
