<?php
$module = $_GET['module'] ?? null;
$endpoint = $_GET['endpoint'] ?? null;

if ($module && $endpoint) {
    $path = "$module/api/$endpoint.php";
    if (file_exists($path)) {
        require $path;
    } else {
        echo json_encode(['error' => 'Endpoint not found']);
        http_response_code(404);
    }
} else {
    // Default to login page
    header("Location: /app/frontend/index.php?page=login");
    exit();
}

?>
