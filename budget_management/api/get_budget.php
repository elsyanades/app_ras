<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Budgets WHERE id = ?");
        $stmt->execute([$id]);
        $budget = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($budget) {
            echo json_encode($budget);
        } else {
            echo json_encode(['error' => 'Budget not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
