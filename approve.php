<?php
session_start();
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request ID.");
}

$id = (int) $_GET['id'];

$stmtCheck = $pdo->prepare("SELECT student_number FROM requests WHERE id = ?");
$stmtCheck->execute([$id]);
$request = $stmtCheck->fetch();

if (!$request) {
    die("Request ID not found.");
}

$studentNumber = $request['student_number'];

// Approve the request
$stmtUpdate = $pdo->prepare("UPDATE requests SET request_status = 'completed' WHERE id = ?");
if ($stmtUpdate->execute([$id])) {
    $_SESSION['approved_student'] = $studentNumber;

    // ✅ FIX: Make sure this path points to your correct project folder
    header("Location: admin.php?success=1"); 
    exit;
} else {
    die("❌ Failed to update request_status.");
}
