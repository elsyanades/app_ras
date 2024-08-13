<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $employee_id = $data['employee_id'] ?? null;
    $pay_period_start = $data['pay_period_start'] ?? null;
    $pay_period_end = $data['pay_period_end'] ?? null;
    $gross_salary = $data['gross_salary'] ?? null;
    $deductions = $data['deductions'] ?? null;
    $net_salary = $data['net_salary'] ?? null;
    $payment_date = $data['payment_date'] ?? null;

    if ($id && ($employee_id || $pay_period_start || $pay_period_end || $gross_salary !== null || $deductions !== null || $net_salary !== null || $payment_date)) {
        $updateFields = [];
        $params = [];

        if ($employee_id) {
            $updateFields[] = "employee_id = ?";
            $params[] = $employee_id;
        }

        if ($pay_period_start) {
            $updateFields[] = "pay_period_start = ?";
            $params[] = $pay_period_start;
        }

        if ($pay_period_end) {
            $updateFields[] = "pay_period_end = ?";
            $params[] = $pay_period_end;
        }

        if ($gross_salary !== null) {
            $updateFields[] = "gross_salary = ?";
            $params[] = $gross_salary;
        }

        if ($deductions !== null) {
            $updateFields[] = "deductions = ?";
            $params[] = $deductions;
        }

        if ($net_salary !== null) {
            $updateFields[] = "net_salary = ?";
            $params[] = $net_salary;
        }

        if ($payment_date) {
            $updateFields[] = "payment_date = ?";
            $params[] = $payment_date;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Salaries SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";
        
        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Salary updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
