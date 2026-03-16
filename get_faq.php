<?php
header("Content-Type: application/json");
include "db.php";  // your database connection file

// Only allow GET requests with ?id= parameter
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Invalid request. Use GET with ?id= parameter"
    ]);
    exit;
}

$id = (int)$_GET['id'];

if ($id <= 0) {
    echo json_encode([
        "status"  => "error",
        "message" => "Invalid FAQ ID"
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT id, question, answer, is_code, java, cpp, python 
    FROM faqs 
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Make sure is_code is treated as boolean/int consistently
    $row['is_code'] = (int)$row['is_code'];

    echo json_encode([
        "status" => "success",
        "faq"    => $row
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => "FAQ not found"
    ]);
}

$stmt->close();
$conn->close();