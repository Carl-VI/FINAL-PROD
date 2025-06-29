<?php
session_start();
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

$user = new User($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number    = trim($_POST['student_number']);
    $name              = trim($_POST['name']);
    $course            = trim($_POST['course']);
    $year_level        = trim($_POST['year_level']);
    $document_request  = trim($_POST['document_request']);

    $existing = $user->studentExists($student_number);

    if ($existing) {
        // Student number exists — check the name
        if (strcasecmp($existing['name'], $name) !== 0) {
            $message = "<div class='alert alert-danger'>Error: Student number $student_number is already in use by {$existing['name']}.</div>";
        } else {
            // Names match — add request
            if ($user->addRequest($student_number, $document_request)) {
                $message = "<div class='alert alert-success'>Request successfully submitted! <a href='index.php'>Go to Dashboard</a></div>";
            } else {
                $message = "<div class='alert alert-danger'>Error submitting request.</div>";
            }
        }
    } else {
        // New student — add student then add request
        if ($user->addStudent($student_number, $name, $course, $year_level)) {
            if ($user->addRequest($student_number, $document_request)) {
                $message = "<div class='alert alert-success'>Request successfully submitted! <a href='index.php'>Go to Dashboard</a></div>";
            } else {
                $message = "<div class='alert alert-danger'>Error submitting request.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Error creating student record.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Request Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4 text-center">Request a Document</h2>

    <?= $message ?>

    <form method="post" action="" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
            <label for="student_number" class="form-label">Student Number</label>
            <input type="text" class="form-control" id="student_number" name="student_number" placeholder="2022-00123" required>
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
                <option value="COG">Copy of Grades</option>
                <option value="COR">Certificate of Registration</option>
                <option value="COE">Certificate of Enrollment</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Request Document</button>
    </form>
</div>

</body>
</html>
