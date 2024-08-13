<?php
require_once 'config/database.php';

$endpoint = $_GET['endpoint'] ?? null;

switch ($endpoint) {
    case 'create_delivery_note':
        require 'api/create_delivery_note.php';
        break;
    case 'get_delivery_note':
        require 'api/get_delivery_note.php';
        break;
    case 'update_delivery_note':
        require 'api/update_delivery_note.php';
        break;
    case 'delete_delivery_note':
        require 'api/delete_delivery_note.php';
        break;
    case 'create_delivery_note_item':
        require 'api/create_delivery_note_item.php';
        break;
    case 'get_delivery_note_item':
        require 'api/get_delivery_note_item.php';
        break;
    case 'update_delivery_note_item':
        require 'api/update_delivery_note_item.php';
        break;
    case 'delete_delivery_note_item':
        require 'api/delete_delivery_note_item.php';
        break;
    default:
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
}
?>
