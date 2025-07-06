<?php
session_start();
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

$user = new User($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number    = trim($_POST['student_number']);
    $name              = trim($_POST['name']);
    $course            = trim($_POST['course']);
    $year_level        = trim($_POST['year_level']);
    $document_request  = trim($_POST['document_request']);

    // ✅ Validate format: 2022-00123
    if (!preg_match('/^\d{4}-\d{5}$/', $student_number)) {
        $error = "Invalid student number format. Use format: 2022-00123.";
    } else {
        $existing = $user->studentExists($student_number);

        if ($existing) {
            if (strcasecmp($existing['name'], $name) !== 0) {
                $error = "Error: Student number $student_number is already in use by {$existing['name']}.";
            } else {
                if ($user->addRequest($student_number, $document_request)) {
                    header("Location: index.php?requested=1");
                    exit;
                } else {
                    $error = "Error submitting request.";
                }
            }
        } else {
            if ($user->addStudent($student_number, $name, $course, $year_level)) {
                if ($user->addRequest($student_number, $document_request)) {
                    header("Location: index.php?requested=1");
                    exit;
                } else {
                    $error = "Error submitting request.";
                }
            } else {
                $error = "Error creating student record.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Request Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4 text-center">📄 Request a Document</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
            <label for="student_number" class="form-label">Student Number</label>
            <input type="text" class="form-control" id="student_number" name="student_number"
                   placeholder="e.g., 2022-00123" required
                   pattern="\d{4}-\d{5}"
                   title="Format: 2022-00123">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <label for="course" class="form-label">Course</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Course" required>
        </div>
        <div class="mb-3">
            <label for="year_level" class="form-label">Year Level</label>
            <input type="text" class="form-control" id="year_level" name="year_level" placeholder="Year Level" required>
        </div>
        <div class="mb-3">
            <label for="document_request" class="form-label">Document Type</label>
            <select class="form-select" id="document_request" name="document_request" required>
                <option value="">-- Select Document --</option>
                <option value="COG">📚 Copy of Grades (COG)</option>
                <option value="COR">📝 Certificate of Registration (COR)</option>
                <option value="COE">📄 Certificate of Enrollment (COE)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit Request</button>
    </form>
</div>
</body>
</html>
