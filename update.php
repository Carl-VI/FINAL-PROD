<?php
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

$user = new User($pdo);
$id = $_GET['id'] ?? null;
$message = '';

if (!$id || !is_numeric($id)) {
    die("Invalid request ID.");
}

$request = $user->getRequestById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_document = $_POST['document_request'];

    $stmt = $pdo->prepare("UPDATE requests SET document_request = ? WHERE id = ?");
    if ($stmt->execute([$new_document, $id])) {
        header("Location: index.php?updated=1");
        exit;
    } else {
        $message = "❌ Failed to update.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Request</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4 text-center">Update Document Request</h2>
    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form method="post" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
            <label class="form-label">Requested Document</label>
            <select class="form-select" name="document_request" required>
                <option value="COG" <?= $request['document_request'] == 'COG' ? 'selected' : '' ?>>Copy of Grades</option>
                <option value="COR" <?= $request['document_request'] == 'COR' ? 'selected' : '' ?>>Certificate of Registration</option>
                <option value="COE" <?= $request['document_request'] == 'COE' ? 'selected' : '' ?>>Certificate of Enrollment</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Request</button>
    </form>
</div>
</body>
</html>
