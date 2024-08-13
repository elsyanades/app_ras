<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $invoice_id = $data['invoice_id'] ?? null;
    $payment_date = $data['payment_date'] ?? null;
    $amount = $data['amount'] ?? null;
    $payment_method = $data['payment_method'] ?? null;

    if ($id && ($invoice_id || $payment_date || $amount !== null || $payment_method)) {
        $updateFields = [];
        $params = [];

        if ($invoice_id) {
            $updateFields[] = "invoice_id = ?";
            $params[] = $invoice_id;
        }

        if ($payment_date) {
            $updateFields[] = "payment_date = ?";
            $params[] = $payment_date;
        }

        if ($amount !== null) {
            $updateFields[] = "amount = ?";
            $params[] = $amount;
        }

        if ($payment_method) {
            $updateFields[] = "payment_method = ?";
            $params[] = $payment_method;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Payments SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Payment updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
