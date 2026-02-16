<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

/* Handle preflight (VERY IMPORTANT) */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"] ?? "";
$otp   = $data["otp"] ?? "";

if (!$email || !$otp) {
    echo json_encode([
        "status" => "error",
        "message" => "Email and OTP required"
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT email_otp, otp_expires_at FROM users WHERE email=?"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo json_encode(["status"=>"error","message"=>"User not found"]);
    exit;
}

/* Expiry check */
if (!$user["otp_expires_at"] || strtotime($user["otp_expires_at"]) < time()) {
    echo json_encode(["status"=>"error","message"=>"OTP expired"]);
    exit;
}

/* OTP check */
if (!password_verify($otp, $user["email_otp"])) {
    echo json_encode(["status"=>"error","message"=>"Invalid OTP"]);
    exit;
}

/* Clear OTP after success */
$update = $conn->prepare(
    "UPDATE users 
     SET email_otp=NULL, otp_expires_at=NULL 
     WHERE email=?"
);
$update->bind_param("s", $email);
$update->execute();

echo json_encode(["status"=>"success"]);
