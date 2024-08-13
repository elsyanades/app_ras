<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM Attendance WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            echo json_encode(['message' => 'Attendance deleted successfully']);
        } else {
            echo json_encode(['error' => 'Attendance record not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}