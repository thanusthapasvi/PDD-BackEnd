<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$company_id = $data["company_id"] ?? null;
$user_id    = $data["user_id"]    ?? null;

if (!$company_id || !$user_id) {
    echo json_encode([
        "status"  => "error",
        "message" => "Missing company_id or user_id"
    ]);
    exit;
}

// Security: only admin can delete
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] !== 'admin') {
    echo json_encode([
        "status"  => "error",
        "message" => "Unauthorized: Only admins can delete companies"
    ]);
    exit;
}

$conn->begin_transaction();

try {
    // 1. Delete FAQ links
    $stmt = $conn->prepare("DELETE FROM company_faqs WHERE company_id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();

    // 2. (Optional) Delete actual FAQs if they are not shared
    // If FAQs are company-specific → uncomment if needed
    /*
    $stmt = $conn->prepare("
        DELETE FROM faqs 
        WHERE id IN (SELECT faq_id FROM company_faqs WHERE company_id = ?)
    ");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    */

    // 3. Delete all experiences related to this company
    $stmt = $conn->prepare("DELETE FROM interview_experiences WHERE company_id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();

    // 4. Finally delete the company itself
    $stmt = $conn->prepare("DELETE FROM companies WHERE id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();

    $conn->commit();

    echo json_encode([
        "status"  => "success",
        "message" => "Company and all related experiences deleted successfully"
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "status"  => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}

$conn->close();