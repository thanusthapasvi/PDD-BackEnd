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

$sql = "
    SELECT 
        ie.id,
        ie.user_id,
        ie.company_id,
        ie.overview,
        ie.title,
        ie.questions_asked,
        ie.preparation_tips,
        ie.advice,
        ie.role,
        ie.hired_role,
        ie.difficulty,
        ie.created_at,
        u.name,
        u.profile_pic
    FROM interview_experiences ie
    JOIN users u ON ie.user_id = u.id
    WHERE ie.company_id = ?
    ORDER BY ie.created_at DESC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

$experiences = [];

while ($row = $result->fetch_assoc()) {

    $row["questions_asked"] = $row["questions_asked"]
        ? json_decode($row["questions_asked"], true)
        : [];

    $row["preparation_tips"] = $row["preparation_tips"]
        ? json_decode($row["preparation_tips"], true)
        : [];

    $row["advice"] = $row["advice"]
        ? json_decode($row["advice"], true)
        : [];

    $experiences[] = $row;
}

echo json_encode([
    "status" => "success",
    "experiences" => $experiences
]);
?>
