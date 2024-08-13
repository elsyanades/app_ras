<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $job_id = $data['job_id'] ?? null;
    $applicant_name = $data['applicant_name'] ?? null;
    $resume_path = $data['resume_path'] ?? null;
    $application_date = $data['application_date'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && ($job_id || $applicant_name || $resume_path || $application_date || $status)) {
        $updateFields = [];
        $params = [];

        if ($job_id) {
            $updateFields[] = "job_id = ?";
            $params[] = $job_id;
        }

        if ($applicant_name) {
            $updateFields[] = "applicant_name = ?";
            $params[] = $applicant_name;
        }

        if ($resume_path) {
            $updateFields[] = "resume_path = ?";
            $params[] = $resume_path;
        }

        if ($application_date) {
            $updateFields[] = "application_date = ?";
            $params[] = $application_date;
        }

        if ($status) {
            $updateFields[] = "status = ?";
            $params[] = $status;
        }

        $params[] = $id;

        $updateQuery = "UPDATE Applications SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE id = ?";

        try {
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($params);

            echo json_encode(['message' => 'Application updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
