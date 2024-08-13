<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_purchase_order':
        require 'api/create_purchase_order.php';
        break;
    case 'get_purchase_order':
        require 'api/get_purchase_order.php';
        break;
    case 'update_purchase_order':
        require 'api/update_purchase_order.php';
        break;
    case 'delete_purchase_order':
        require 'api/delete_purchase_order.php';
        break;
    case 'add_purchase_order_item':
        require 'api/add_purchase_order_item.php';
        break;
    case 'get_purchase_order_items':
        require 'api/get_purchase_order_items.php';
        break;
    case 'update_purchase_order_item':
        require 'api/update_purchase_order_item.php';
        break;
    case 'delete_purchase_order_item':
        require 'api/delete_purchase_order_item.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
}
?>
