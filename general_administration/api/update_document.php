<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $title = $data['title'] ?? null;
    $description = $data['description'] ?? null;

    if ($id && ($title || $description)) {
        $updateFields = [];
        $params = [];

        if ($title) {
            $updateFields[] = "title = ?";
            $params[] = $title;
        }

        if ($description) {
            $updateFields[] = "description = ?";
            $params[] = $description;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Documents SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Document updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
