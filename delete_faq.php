<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$faq_id   = $data["faq_id"]   ?? null;
$user_id  = $data["user_id"]  ?? null;

if (!$faq_id || !$user_id) {
    echo json_encode([
        "status"  => "error",
        "message" => "Missing faq_id or user_id"
    ]);
    exit;
}

// Optional: Only allow admins to delete FAQs
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] !== 'admin') {
    echo json_encode([
        "status"  => "error",
        "message" => "Unauthorized: Only admins can delete FAQs"
    ]);
    exit;
}

$conn->begin_transaction();

try {
    // 1. Delete the FAQ → company link
    $stmt = $conn->prepare("DELETE FROM company_faqs WHERE faq_id = ?");
    $stmt->bind_param("i", $faq_id);
    $stmt->execute();

    // 2. Delete the FAQ itself
    $stmt = $conn->prepare("DELETE FROM faqs WHERE id = ?");
    $stmt->bind_param("i", $faq_id);
    $stmt->execute();

    $conn->commit();

    echo json_encode([
        "status"  => "success",
        "message" => "FAQ deleted successfully"
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "status"  => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}

$conn->close();