<?php
header("Content-Type: application/json");
include "db.php";

// Read JSON payload
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "status"  => "error",
        "message" => "Invalid JSON: " . json_last_error_msg()
    ]);
    exit;
}

// Extract fields (with safe defaults)
$id           = $data["id"]           ?? null;
$name         = trim($data["name"]    ?? "");
$hiring_roles = $data["hiring_roles"] ?? [];
$roles        = $data["roles"]        ?? [];
$locations    = $data["locations"]    ?? [];
$exam_pattern = $data["exam_pattern"] ?? [];
$info         = $data["info"]         ?? [];

// Basic validation
if (empty($name)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Company name is required"
    ]);
    exit;
}

// Convert arrays to JSON strings for DB
$hiring_roles_json = json_encode($hiring_roles, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$roles_json        = json_encode($roles,        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$locations_json    = json_encode($locations,    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$exam_pattern_json = json_encode($exam_pattern, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$info_json         = json_encode($info,         JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$conn->begin_transaction();

try {
    if ($id) {
        // ── UPDATE ────────────────────────────────────────
        $stmt = $conn->prepare("
            UPDATE companies
               SET name         = ?,
                   hiring_roles = ?,
                   roles        = ?,
                   locations    = ?,
                   exam_pattern = ?,
                   info         = ?
             WHERE id = ?
        ");
        $stmt->bind_param(
            "ssssssi",
            $name,
            $hiring_roles_json,
            $roles_json,
            $locations_json,
            $exam_pattern_json,
            $info_json,
            $id
        );
        $stmt->execute();
        $company_id = $id;
    } else {
        // ── INSERT ────────────────────────────────────────
        $stmt = $conn->prepare("
            INSERT INTO companies
            (name, hiring_roles, roles, locations, exam_pattern, info)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssss",
            $name,
            $hiring_roles_json,
            $roles_json,
            $locations_json,
            $exam_pattern_json,
            $info_json
        );
        $stmt->execute();
        $company_id = $conn->insert_id;
    }

    // ── If you later bring back FAQs, add that logic here ──
    // For now we intentionally skip faqs processing

    $conn->commit();

    echo json_encode([
        "status"      => "success",
        "company_id"  => (int)$company_id,
        "message"     => $id ? "Company updated" : "Company created"
    ]);

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        "status"  => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}

$conn->close();