<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

/* Handle preflight */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"] ?? "";
$newPassword = $data["password"] ?? "";

if (!$email || !$newPassword) {
    echo json_encode([
        "status" => "error",
        "message" => "Email and password required"
    ]);
    exit;
}

// Hash new password (same as signup)
$hashedPass = password_hash($newPassword, PASSWORD_BCRYPT);

// Correct column name here
$stmt = $conn->prepare(
    "UPDATE users 
     SET password_hash=? WHERE email=?"
);

$stmt->bind_param("ss", $hashedPass, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode([
        "status" => "success",
        "message" => "Password updated"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not found or same password"
    ]);
}
?>
