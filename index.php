<?php
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';
$user = new User($pdo);
$requests = $user->getAllRequests();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Document Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Document Requests</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
            <tr>
                <td><?= htmlspecialchars($r['student_number']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['course']) ?></td>
                <td><?= htmlspecialchars($r['year_level']) ?></td>
                <td><?= htmlspecialchars($r['document_request']) ?></td>
                <td><?= htmlspecialchars($r['request_status']) ?></td>
                <td><?= htmlspecialchars($r['request_date']) ?></td>
                <td>
                    <?php if (in_array($r['document_request'], ['COR','COE','COG'])): ?>
                        <a href="generate.php?id=<?= urlencode($r['id']) ?>" target="_blank" class="btn btn-sm btn-primary">
                            Generate <?= htmlspecialchars($r['document_request']) ?>
                        </a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="request.php" class="btn btn-success">Make a new request</a>
</div>

</body>
</html>
