<?php
$module = $_GET['module'] ?? 'frontend';  // Default to frontend if no module is specified

switch ($module) {
    case 'auth_management':
        require __DIR__ . '/auth_management/index.php';
        break;
    case 'budget_management':
        require __DIR__ . '/budget_management/index.php';
        break;
    case 'frontend':
    default:
        require __DIR__ . '/frontend/index.php';
        break;
}
