<?php
require __DIR__ . '/database/db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request ID.");
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM requests WHERE id = ?");
if ($stmt->execute([$id])) {
    header("Location: admin.php?deleted=1");
    exit;
} else {
    die("❌ Failed to delete request.");
}
