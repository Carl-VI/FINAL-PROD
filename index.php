<?php
session_start();
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

$user = new User($pdo);
$requests = $user->getAllRequests();

$approvedStudent = $_SESSION['approved_student'] ?? null;
unset($_SESSION['approved_student']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Document Requests</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-out {
            transition: opacity 5s ease-out;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📄 Document Requests</h2>

    <!-- ✅ SUCCESS / APPROVED MESSAGES -->
    <?php if (isset($_GET['requested'])): ?>
        <div id="success-alert" class="alert alert-success">
            ✅ Your request was submitted successfully. Wait for the admin to accept your request. Thank you.
        </div>
    <?php elseif (!empty($approvedStudent)): ?>
        <div id="approved-alert" class="alert alert-info">
            🎉 Your request (<?= htmlspecialchars($approvedStudent) ?>) has been approved by the admin.
            You may now generate your document.
        </div>
    <?php endif; ?>

    <script>
        // Show messages for 15s, then fade out over 5s
        setTimeout(() => {
            const success = document.getElementById('success-alert');
            const approved = document.getElementById('approved-alert');
            if (success) success.classList.add('fade-out');
            if (approved) approved.classList.add('fade-out');

            setTimeout(() => {
                if (success) success.remove();
                if (approved) approved.remove();
            }, 5000);
        }, 15000);

        // Optional: Reload index after success/approval once
        if (
            (window.location.search.includes('requested') || window.location.search.includes('approved')) &&
            !sessionStorage.getItem('reloaded')
        ) {
            sessionStorage.setItem('reloaded', 'yes');
            setTimeout(() => window.location.href = 'index.php', 1000);
        } else {
            sessionStorage.removeItem('reloaded');
        }
    </script>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>Student Number</th>
                <th>Full Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Document</th>
                <th>Status</th>
                <th>Requested On</th>
                <th>Generate PDF</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($requests as $r): ?>
            <tr class="align-middle text-center">
                <td><?= htmlspecialchars($r['student_number']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['course']) ?></td>
                <td><?= htmlspecialchars($r['year_level']) ?></td>
                <td><?= htmlspecialchars($r['document_request']) ?></td>
                <td>
                    <?php if ($r['request_status'] === 'completed'): ?>
                        <span class="badge bg-success">Completed</span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= htmlspecialchars($r['request_status']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($r['request_date']) ?></td>
                <td>
                    <?php if (
                        in_array($r['document_request'], ['COR', 'COE', 'COG']) &&
                        $r['request_status'] === 'completed'
                    ): ?>
                        <a href="generate.php?id=<?= urlencode($r['id']) ?>" target="_blank" class="btn btn-sm btn-primary">
                            Generate <?= htmlspecialchars($r['document_request']) ?>
                        </a>
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-start">
        <a href="request.php" class="btn btn-success">➕ Make a new request</a>
    </div>
</div>
</body>
</html>
