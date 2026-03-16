<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? null;
$user_id = $data["user_id"];
$company_id = $data["company_id"];
$title = $data["title"];
$overview = $data["overview"];
$questions = json_encode($data["questions_asked"]);
$tips = json_encode($data["preparation_tips"]);
$advice = json_encode($data["advice"]);
$role = $data["role"];
$hired_role = $data["hired_role"];
$difficulty = $data["difficulty"];

if ($id) {
    // UPDATE
    $sql = "UPDATE interview_experiences SET
            title=?,
            overview=?,
            questions_asked=?,
            preparation_tips=?,
            advice=?,
            role=?,
            hired_role=?,
            difficulty=?
            WHERE id=? AND user_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssii",
        $title,
        $overview,
        $questions,
        $tips,
        $advice,
        $role,
        $hired_role,
        $difficulty,
        $id,
        $user_id
    );
} else {
    // INSERT
    $sql = "INSERT INTO interview_experiences
            (user_id, company_id, title, overview, questions_asked,
             preparation_tips, advice, role, hired_role, difficulty)
            VALUES (?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iissssssss",
        $user_id,
        $company_id,
        $title,
        $overview,
        $questions,
        $tips,
        $advice,
        $role,
        $hired_role,
        $difficulty
    );
}

if ($stmt->execute()) {
    echo json_encode([
        "status"=>"success",
        "insert_id"=>$conn->insert_id
    ]);
} else {
    echo json_encode(["status"=>"error","message"=>$conn->error]);
}
?>