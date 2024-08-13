<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$upload_dir = '../uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $uploaded_by = $_POST['uploaded_by'] ?? null;

        $file_name = basename($file['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            if ($title && $description && $uploaded_by) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO Documents (title, description, file_path, uploaded_by, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                    $stmt->execute([$title, $description, $file_path, $uploaded_by]);

                    $response = [
                        'id' => $pdo->lastInsertId(),
                        'title' => $title,
                        'description' => $description,
                        'file_path' => $file_path,
                        'uploaded_by' => $uploaded_by,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    echo json_encode($response);
                } catch (PDOException $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Invalid input']);
            }
        } else {
            echo json_encode(['error' => 'Failed to upload file']);
        }
    } else {
        echo json_encode(['error' => 'No file uploaded or file upload error']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
