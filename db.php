<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "interview_assist";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "type" => "server",
            "message" => "Database connection failed"
        ]);
        exit;
    }
?>
