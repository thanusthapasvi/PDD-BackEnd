<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    include "db.php";

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data["action"] ?? "";

    // SEND OTP
    if ($action === "send_otp") {

        $email = $data["email"] ?? "";

        if (!$email) {
            echo json_encode(["status"=>"error","message"=>"Email required"]);
            exit;
        }

        // Check if user already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            echo json_encode(["status"=>"error","message"=>"Email already registered"]);
            exit;
        }

        $otp = rand(100000, 999999);
        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Insert or update OTP
        $stmt = $conn->prepare(
            "INSERT INTO signup_otps (email, otp, otp_expires_at)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE otp=?, otp_expires_at=?"
        );
        $stmt->bind_param("sssss", $email, $hashedOtp, $expiry, $hashedOtp, $expiry);
        $stmt->execute();

        // for development this is commented
        // mail($email, "Interview Assist OTP", "Your OTP is: $otp");
        // TEMP: log OTP instead of mail
        file_put_contents("otp_log.txt", "OTP for Interview Assist OTP, Your OTP is: $otp\n", FILE_APPEND);

        echo json_encode(["status"=>"success"]);
        exit;
    }

    // VERIFY OTP
    if ($action === "verify_otp") {

        $email = $data["email"] ?? "";
        $otp = $data["otp"] ?? "";

        $stmt = $conn->prepare(
            "SELECT otp, otp_expires_at FROM signup_otps WHERE email=?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            echo json_encode(["status"=>"error","message"=>"OTP not found"]);
            exit;
        }

        if (strtotime($row["otp_expires_at"]) < time()) {
            echo json_encode(["status"=>"error","message"=>"OTP expired"]);
            exit;
        }

        if (!password_verify($otp, $row["otp"])) {
            echo json_encode(["status"=>"error","message"=>"Invalid OTP"]);
            exit;
        } else {
            $update = $conn->prepare(
                "UPDATE signup_otps SET verified=1 WHERE email=?"
            );
            $update->bind_param("s", $email);
            $update->execute();
        }

        echo json_encode(["status"=>"success"]);
        exit;
    }

    // FINAL SIGNUP
    if ($action === "signup") {

        $name = $data["name"] ?? "";
        $email = $data["email"] ?? "";
        $password = $data["password"] ?? "";

        // OTP must exist
        error_log("SIGNUP CHECK: $email");

        $stmt = $conn->prepare(
            "SELECT id FROM signup_otps WHERE email=? AND verified=1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            echo json_encode(["status"=>"error","message"=>"OTP not verified"]);
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $insert = $conn->prepare(
            "INSERT INTO users (name, email, password_hash, email_verified)
             VALUES (?, ?, ?, 1)"
        );
        $insert->bind_param("sss", $name, $email, $hash);

        if ($insert->execute()) {
            $userId = $conn->insert_id;

            $fetch = $conn->prepare(
                "SELECT id, name, email, role, profile_pic, current_year 
                 FROM users 
                 WHERE id=?"
            );
            $fetch->bind_param("i", $userId);
            $fetch->execute();
            $user = $fetch->get_result()->fetch_assoc();

            // Cleanup signup OTP
            $del = $conn->prepare("DELETE FROM signup_otps WHERE email=?");
            $del->bind_param("s", $email);
            $del->execute();

            echo json_encode([
                "status" => "success",
                "user" => $user
            ]);
            exit;

        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Signup failed"
            ]);
            exit;
        }

        exit;
    }
?>