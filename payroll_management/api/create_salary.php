<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $employee_id = $data['employee_id'] ?? null;
    $pay_period_start = $data['pay_period_start'] ?? null;
    $pay_period_end = $data['pay_period_end'] ?? null;
    $gross_salary = $data['gross_salary'] ?? null;
    $deductions = $data['deductions'] ?? null;
    $net_salary = $data['net_salary'] ?? null;
    $payment_date = $data['payment_date'] ?? null;

    if ($employee_id && $pay_period_start && $pay_period_end && $gross_salary !== null && $deductions !== null && $net_salary !== null && $payment_date) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Salaries (employee_id, pay_period_start, pay_period_end, gross_salary, deductions, net_salary, payment_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$employee_id, $pay_period_start, $pay_period_end, $gross_salary, $deductions, $net_salary, $payment_date]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'employee_id' => $employee_id,
                'pay_period_start' => $pay_period_start,
                'pay_period_end' => $pay_period_end,
                'gross_salary' => $gross_salary,
                'deductions' => $deductions,
                'net_salary' => $net_salary,
                'payment_date' => $payment_date,
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
