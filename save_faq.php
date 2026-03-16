<?php
header("Content-Type: application/json");
include "db.php";  // your database connection file

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

// ──────────────────────────────────────────────
// CASE 1: UPDATE EXISTING FAQ (when editing)
// Payload has 'id'
if (isset($data['id']) && is_numeric($data['id'])) {
    
    $id       = (int)$data['id'];
    $question = trim($data['question'] ?? '');
    $answer   = trim($data['answer'] ?? '');
    $is_code  = isset($data['is_code']) ? (int)$data['is_code'] : 0;
    $java     = $is_code ? trim($data['java'] ?? '')   : null;
    $cpp      = $is_code ? trim($data['cpp'] ?? '')    : null;
    $python   = $is_code ? trim($data['python'] ?? '') : null;

    if (empty($question) || empty($answer)) {
        echo json_encode(["status" => "error", "message" => "Question and answer are required"]);
        exit;
    }

    if ($is_code && (empty($java) || empty($cpp) || empty($python))) {
        echo json_encode(["status" => "error", "message" => "All code fields are required when is_code is enabled"]);
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE faqs 
        SET question = ?, 
            answer   = ?, 
            is_code  = ?, 
            java     = ?, 
            cpp      = ?, 
            python   = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ssisssi", $question, $answer, $is_code, $java, $cpp, $python, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "FAQ updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No changes made or FAQ not found"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
    exit;
}

// ──────────────────────────────────────────────
// CASE 2: CREATE NEW FAQ(S) + link to company
// Payload has 'company_id' and 'faqs' array
if (isset($data['company_id']) && is_numeric($data['company_id']) && isset($data['faqs']) && is_array($data['faqs'])) {

    $company_id = (int)$data['company_id'];
    $faqs_list  = $data['faqs'];

    if (empty($faqs_list)) {
        echo json_encode(["status" => "error", "message" => "No FAQs provided"]);
        exit;
    }

    $conn->begin_transaction();

    try {
        foreach ($faqs_list as $faq) {
            $question = trim($faq['question'] ?? '');
            $answer   = trim($faq['answer']   ?? '');
            $is_code  = isset($faq['is_code']) ? (int)$faq['is_code'] : 0;
            $java     = $is_code ? trim($faq['java']   ?? '') : null;
            $cpp      = $is_code ? trim($faq['cpp']    ?? '') : null;
            $python   = $is_code ? trim($faq['python'] ?? '') : null;

            if (empty($question) || empty($answer)) {
                throw new Exception("Question and answer are required for all FAQs");
            }

            if ($is_code && (empty($java) || empty($cpp) || empty($python))) {
                throw new Exception("All code fields are required when is_code is enabled");
            }

            // Insert into faqs table
            $stmt = $conn->prepare("
                INSERT INTO faqs (question, answer, is_code, java, cpp, python)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssisss", $question, $answer, $is_code, $java, $cpp, $python);
            $stmt->execute();

            $faq_id = $conn->insert_id;

            // Link to company
            $stmt_link = $conn->prepare("
                INSERT INTO company_faqs (company_id, faq_id)
                VALUES (?, ?)
            ");
            $stmt_link->bind_param("ii", $company_id, $faq_id);
            $stmt_link->execute();

            $stmt->close();
            $stmt_link->close();
        }

        $conn->commit();
        echo json_encode([
            "status"  => "success",
            "message" => "FAQs saved successfully",
            "count"   => count($faqs_list)
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }

    exit;
}

// Invalid request
echo json_encode(["status" => "error", "message" => "Invalid request format"]);
$conn->close();