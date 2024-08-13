<?php
session_start(); // Start session

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['token']);
}

// Function to get user role from session
function getUserRole() {
    return $_SESSION['role'] ?? null;
}

// Check if the user is logged in for protected pages
$page = isset($_GET['page']) ? $_GET['page'] : 'login'; // Default to login page if 'page' is not set
$protectedPages = [
    'dashboard',
    'dashboard-admin',
    'dashboard-manager',
    'dashboard-finance',
    'dashboard-employee',
];

if (in_array($page, $protectedPages) && !isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

// Check if the user has access to the requested page
$role = getUserRole();
$allowedPages = [
    'admin' => ['dashboard-admin'],
    'Superuser' => ['dashboard', 'dashboard-admin', 'dashboard-manager', 'dashboard-finance', 'dashboard-employee'],
    'manager' => ['dashboard-manager'],
    'finance' => ['dashboard-finance', 'dashboard'],
    'employee' => ['dashboard-employee']
];

if (isset($allowedPages[$role]) && !in_array($page, $allowedPages[$role])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'You do not have permission to access this page.';
    exit();
}

switch ($page) {
    case "":
    case "login":
        include "page/auth/login.php";
        break;
    case "dashboard":
        include "page/dashboard/dashboard.php";
        break;
    case "dashboard-admin":
        include "page/dashboard/dashboard_admin.php";
        break;
    case "dashboard-manager":
        include "page/dashboard/dashboard_manager.php";
        break;
    case "dashboard-finance":
        include "page/dashboard/dashboard_finance.php";
        break;
    case "dashboard-employee":
        include "page/dashboard/dashboard_employee.php";
        break;
    case "register":
        include "page/auth/register.php";
        break;
    case "forgot":
        include "page/auth/forgot_password.php";
        break;
    case "reset":
        include "page/auth/reset_password.php";
        break;
    default:
        include "page/404.php";
        break;
}
?>
