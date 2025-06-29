<!DOCTYPE html>
<html>
<head>
    <title>Copy of Grades (COG)</title>
    <style>
        body { font-family: Arial,sans-serif; padding:40px; background:#f8f8f8; }
        .certificate { background:#fff; padding:40px; border:1px solid #ccc; max-width:800px; margin:auto; }
        .header { text-align:center; }
        .header h1 { margin:0; font-size:28px; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table th, table td { padding:8px; border:1px solid #ccc; }
        table th { background:#eee; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>Copy of Grades (COG)</h1>
            <p>Institution Name: CCSFP</p>
        </div>
        <div class="student-info">
            <h3>Student Information</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($request_data['name']) ?></p>
            <p><strong>Program:</strong> <?= htmlspecialchars($request_data['course']) ?></p>
        </div>
        <h3>Grades:</h3>
        <table>
            <tr><th>Subject</th><th>Grade</th></tr>
            <tr><td>IT 201</td><td>1.25</td></tr>
            <tr><td>IT 202</td><td>1.50</td></tr>
        </table>
    </div>
</body>
</html>
