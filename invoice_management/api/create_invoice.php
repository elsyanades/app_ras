<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $invoice_number = $data['invoice_number'] ?? null;
    $customer_id = $data['customer_id'] ?? null;
    $issue_date = $data['issue_date'] ?? null;
    $due_date = $data['due_date'] ?? null;
    $total_amount = $data['total_amount'] ?? null;
    $status = $data['status'] ?? null;

    if ($invoice_number && $customer_id && $issue_date && $due_date && $total_amount !== null && $status) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Invoices (invoice_number, customer_id, issue_date, due_date, total_amount, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$invoice_number, $customer_id, $issue_date, $due_date, $total_amount, $status]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'invoice_number' => $invoice_number,
                'customer_id' => $customer_id,
                'issue_date' => $issue_date,
                'due_date' => $due_date,
                'total_amount' => $total_amount,
                'status' => $status,
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
