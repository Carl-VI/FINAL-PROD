<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Enrollment (COE)</title>
    <style>
        body { font-family: Arial,sans-serif; padding:40px; background:#f8f8f8; }
        .certificate { background:#fff; padding:40px; border:1px solid #ccc; max-width:800px; margin:auto; }
        .header { text-align:center; }
        .header h1 { margin:0; font-size:28px; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>Certificate of Enrollment (COE)</h1>
            <p>Institution Name: CCSFP</p>
        </div>
        <div class="student-info">
            <h3>Student Information</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($request_data['name']) ?></p>
            <p><strong>Program:</strong> <?= htmlspecialchars($request_data['course']) ?></p>
            <p><strong>Year Level:</strong> <?= htmlspecialchars($request_data['year_level']) ?></p>
        </div>
        <div class="body">
            <p>This is to certify that the student named above is officially enrolled for the current academic period.</p>
        </div>
    </div>
</body>
</html>
