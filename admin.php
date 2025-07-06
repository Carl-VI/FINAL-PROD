<?php
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';

$user = new User($pdo);
$requests = $user->getAllRequests();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel – Approve Requests</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Auto-refresh every 10 seconds
        setTimeout(() => {
            window.location.reload();
        }, 10000);
    </script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Admin Panel – Document Requests</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Student Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Document</th>
                <th>Status</th>
                <th>Requested On</th>
                <th>Approve</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($requests as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['student_number']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['course']) ?></td>
                <td><?= htmlspecialchars($r['year_level']) ?></td>
                <td><?= htmlspecialchars($r['document_request']) ?></td>
                <td><?= htmlspecialchars($r['request_status']) ?></td>
                <td><?= htmlspecialchars($r['request_date']) ?></td>
                <td>
                    <?php if ($r['request_status'] !== 'approved'): ?>
                        <a href="approve.php?id=<?= urlencode($r['id']) ?>" class="btn btn-success btn-sm">Approve</a>
                    <?php else: ?>
                        <span class="text-success">Approved</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="delete.php?id=<?= urlencode($r['id']) ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure you want to delete this request?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
