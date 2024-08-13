<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $invoice_id = $data['invoice_id'] ?? null;
    $payment_date = $data['payment_date'] ?? null;
    $amount = $data['amount'] ?? null;
    $payment_method = $data['payment_method'] ?? null;

    if ($invoice_id && $payment_date && $amount !== null && $payment_method) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Payments (invoice_id, payment_date, amount, payment_method, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$invoice_id, $payment_date, $amount, $payment_method]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'invoice_id' => $invoice_id,
                'payment_date' => $payment_date,
                'amount' => $amount,
                'payment_method' => $payment_method,
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
