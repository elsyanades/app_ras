<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $title = $data['title'] ?? null;
    $description = $data['description'] ?? null;
    $uploaded_by = $data['uploaded_by'] ?? null;

    if ($title && $description && $uploaded_by) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Documents (title, description, file_path, uploaded_by, created_at, updated_at) VALUES (?, ?, NULL, ?, NOW(), NOW())");
            $stmt->execute([$title, $description, $uploaded_by]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'title' => $title,
                'description' => $description,
                'file_path' => null,
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
    echo json_encode(['error' => 'Invalid request method']);
}
