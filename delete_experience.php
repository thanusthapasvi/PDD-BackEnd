<?php
    header("Content-Type: application/json");
    include "db.php";

    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    $experience_id = $data["id"] ?? 0;
    $user_id = $data["user_id"] ?? 0;

    if (!$experience_id || !$user_id) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid request"
        ]);
        exit;
    }

    // Check if experience exists and belongs to user
    $checkSql = "SELECT id FROM interview_experiences 
                 WHERE id = ? AND user_id = ?";

    $checkStmt = $conn->prepare($checkSql);

    if (!$checkStmt) {
        echo json_encode([
            "status" => "error",
            "message" => "Prepare failed: " . $conn->error
        ]);
        exit;
    }

    $checkStmt->bind_param("ii", $experience_id, $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Unauthorized or experience not found"
        ]);
        exit;
    }

    // Delete experience
    $deleteSql = "DELETE FROM interview_experiences WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);

    if (!$deleteStmt) {
        echo json_encode([
            "status" => "error",
            "message" => "Delete prepare failed: " . $conn->error
        ]);
        exit;
    }

    $deleteStmt->bind_param("i", $experience_id);

    if ($deleteStmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Experience deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Delete failed"
        ]);
    }
?>
