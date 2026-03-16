<?php
header("Content-Type: application/json");
include "db.php";

$user_id = $_GET["user_id"] ?? 0;

if(!$user_id){
    echo json_encode(["status"=>"error"]);
    exit;
}

$stmt = $conn->prepare("
SELECT 
    e.*,
    u.name,
    u.profile_pic,
    c.id AS company_id,
    c.name AS company_name
FROM experience_bookmarks b
JOIN interview_experiences e ON e.id = b.experience_id
JOIN users u ON u.id = e.user_id
JOIN companies c ON c.id = e.company_id
WHERE b.user_id = ?
ORDER BY e.created_at DESC
");

$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

$bookmarks = [];

while($row = $result->fetch_assoc()){
    $bookmarks[] = $row;
}

echo json_encode([
    "status"=>"success",
    "bookmarks"=>$bookmarks
]);