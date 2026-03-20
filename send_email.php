<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// These three lines load the classes manually (no Composer)
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

function sendOTPEmail($toEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'interviewassist.team@gmail.com';          // ← your Gmail
        $mail->Password   = 'palyxsnhbwibyadt';           // ← your 16-char App Password (no spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    // 'tls'
        $mail->Port       = 587;

        // Optional: helps with some Windows/XAMPP SSL issues
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        );

        // Sender & receiver
        $mail->setFrom('yourname@gmail.com', 'Interview Assist');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Interview Assist - OTP';
        $mail->Body    = "Hello,<br><br>Your Verification OTP is: <b>$otp</b><br>This code expires in 10 minutes.<br><br>Thank you,<br>The Interview Assist Team";
        $mail->AltBody = "Your OTP is: $otp\nValid for 10 minutes.";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email failed: " . $mail->ErrorInfo);
        return false;
    }
}