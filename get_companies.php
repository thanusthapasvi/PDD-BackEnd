<?php
    header("Content-Type: application/json");
    include "db.php";

    $query = "SELECT id, name, hiring_roles, roles, locations, exam_pattern, info FROM companies";
    $result = $conn->query($query);

    $companies = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $companies[] = [
                "id" => $row["id"],
                "name" => $row["name"],
                "hiring_roles" => json_decode($row["hiring_roles"], true),
                "roles" => json_decode($row["roles"], true),
                "locations" => json_decode($row["locations"], true),
                "exam_pattern" => json_decode($row["exam_pattern"], true),
                "info" => json_decode($row["info"], true)
            ];
        }

        echo json_encode([
            "status" => "success",
            "companies" => $companies
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to fetch companies"
        ]);
    }
?>
