<?php
    header("Content-Type: application/json");
    include "db.php";

    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"] ?? "";

    if (!$email) {
        echo json_encode(["status"=>"error","message"=>"Email required"]);
        exit;
    }

    // First check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status"=>"error","message"=>"User not found"]);
        exit;
    }

    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo json_encode(["status"=>"success","message"=>"Account deleted"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Delete failed"]);
    }
?>
