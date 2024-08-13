<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $title = $data['title'] ?? null;
    $description = $data['description'] ?? null;
    $requirements = $data['requirements'] ?? null;
    $location = $data['location'] ?? null;

    if ($title && $description && $requirements && $location) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Job_Openings (title, description, requirements, location, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$title, $description, $requirements, $location]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'title' => $title,
                'description' => $description,
                'requirements' => $requirements,
                'location' => $location,
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
