<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Salaries WHERE id = ?");
        $stmt->execute([$id]);
        $salary = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($salary) {
            echo json_encode($salary);
        } else {
            echo json_encode(['error' => 'Salary record not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
