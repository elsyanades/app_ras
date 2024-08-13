<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Job_Openings WHERE id = ?");
        $stmt->execute([$id]);
        $job_opening = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($job_opening) {
            echo json_encode($job_opening);
        } else {
            echo json_encode(['error' => 'Job opening not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
