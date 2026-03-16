<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"] ?? 0;
$experience_id = $data["experience_id"] ?? 0;

if(!$user_id || !$experience_id){
    echo json_encode(["status"=>"error"]);
    exit;
}

$check = $conn->prepare("SELECT * FROM experience_bookmarks WHERE user_id=? AND experience_id=?");
$check->bind_param("ii",$user_id,$experience_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){

    $delete = $conn->prepare("DELETE FROM experience_bookmarks WHERE user_id=? AND experience_id=?");
    $delete->bind_param("ii",$user_id,$experience_id);
    $delete->execute();

    echo json_encode(["status"=>"removed"]);

}else{

    $insert = $conn->prepare("INSERT INTO experience_bookmarks(user_id,experience_id) VALUES(?,?)");
    $insert->bind_param("ii",$user_id,$experience_id);
    $insert->execute();

    echo json_encode(["status"=>"added"]);
}