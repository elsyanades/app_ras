<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $job_id = $data['job_id'] ?? null;
    $applicant_name = $data['applicant_name'] ?? null;
    $resume_path = $data['resume_path'] ?? null;
    $application_date = $data['application_date'] ?? null;
    $status = $data['status'] ?? null;

    if ($job_id && $applicant_name && $resume_path && $application_date && $status) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Applications (job_id, applicant_name, resume_path, application_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$job_id, $applicant_name, $resume_path, $application_date, $status]);

            $response = [
                'id' => $pdo->lastInsertId(),
                'job_id' => $job_id,
                'applicant_name' => $applicant_name,
                'resume_path' => $resume_path,
                'application_date' => $application_date,
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
