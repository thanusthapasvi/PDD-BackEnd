<?php
    header("Content-Type: application/json");
    include "db.php";

    require_once __DIR__ . '/send_email.php';

    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data["email"] ?? "";

    if (!$email) {
        echo json_encode(["status"=>"error","message"=>"Email required"]);
        exit;
    }

    // Generate 6-digit OTP
    $otp = rand(100000, 999999);
    $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // Save OTP
    $stmt = $conn->prepare(
        "UPDATE users SET email_otp=?, otp_expires_at=? WHERE email=?"
    );
    $stmt->bind_param("sss", $hashedOtp, $expiry, $email);
    $stmt->execute();

    // Send email (simple mail())
    //for development mail is not used
    // mail("OTP for Interview Assist OTP, Your OTP is: $otp\n");
    // instead
    // file_put_contents("otp_log.txt", "OTP for Interview Assist OTP, Your OTP is: $otp\n", FILE_APPEND);

    // echo json_encode(["status"=>"success"]);

    // Replace logging with real email
    if (sendOTPEmail($email, $otp)) {
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Failed to send OTP email"]);
    }
?>