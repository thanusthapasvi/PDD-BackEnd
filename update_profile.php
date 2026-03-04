<?php
header("Content-Type: application/json");
include "db.php";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(["status"=>"error","message"=>"Invalid JSON"]);
    exit;
}

$id = $data["id"] ?? null;
$name = $data["name"] ?? "";
$email = $data["email"] ?? "";
$role = $data["role"] ?? "fresher";
$current_year = (int)($data["current_year"] ?? 0);
$profile_pic = (int)($data["profile_pic"] ?? 1);

if (!$id) {
    echo json_encode(["status"=>"error","message"=>"Missing user ID"]);
    exit;
}

$sql = "UPDATE users 
        SET name=?, email=?, role=?, current_year=?, profile_pic=? 
        WHERE id=?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status"=>"error",
        "message"=>"SQL prepare failed",
        "sql_error"=>$conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "sssiii",
    $name,
    $email,
    $role,
    $current_year,
    $profile_pic,
    $id
);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode([
        "status"=>"error",
        "message"=>"Update failed",
        "db_error"=>$stmt->error
    ]);
}
