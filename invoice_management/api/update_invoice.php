<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $invoice_number = $data['invoice_number'] ?? null;
    $customer_id = $data['customer_id'] ?? null;
    $issue_date = $data['issue_date'] ?? null;
    $due_date = $data['due_date'] ?? null;
    $total_amount = $data['total_amount'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && ($invoice_number || $customer_id || $issue_date || $due_date || $total_amount !== null || $status)) {
        $updateFields = [];
        $params = [];

        if ($invoice_number) {
            $updateFields[] = "invoice_number = ?";
            $params[] = $invoice_number;
        }

        if ($customer_id) {
            $updateFields[] = "customer_id = ?";
            $params[] = $customer_id;
        }

        if ($issue_date) {
            $updateFields[] = "issue_date = ?";
            $params[] = $issue_date;
        }

        if ($due_date) {
            $updateFields[] = "due_date = ?";
            $params[] = $due_date;
        }

        if ($total_amount !== null) {
            $updateFields[] = "total_amount = ?";
            $params[] = $total_amount;
        }

        if ($status) {
            $updateFields[] = "status = ?";
            $params[] = $status;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Invoices SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Invoice updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
