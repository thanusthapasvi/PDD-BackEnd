<?php
header("Content-Type: application/json");
include "db.php";

$company_id = $_GET["company_id"] ?? 0;

if (!$company_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Company ID required"
    ]);
    exit;
}

$sql = "SELECT f.id, f.question, f.answer, f.is_code, f.cpp, f.python, f.java
        FROM faqs f
        JOIN company_faqs cf ON f.id = cf.faq_id
        WHERE cf.company_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();

$result = $stmt->get_result();

$faqs = [];

while ($row = $result->fetch_assoc()) {
    $faqs[] = $row;
}

echo json_encode([
    "status" => "success",
    "faqs" => $faqs
]);