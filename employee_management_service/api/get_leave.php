<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Leaves WHERE id = ?");
        $stmt->execute([$id]);
        $leave = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($leave) {
            echo json_encode($leave);
        } else {
            echo json_encode(['error' => 'Leave record not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
