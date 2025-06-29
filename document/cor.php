<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Registration (COR)</title>
    <style>
        body { font-family: Arial,sans-serif; margin:40px; background:#f8f8f8; }
        .certificate { background:#fff; padding:40px; border:1px solid #ccc; max-width:800px; margin:auto; }
        .header { text-align:center; }
        .header h1 { margin:0; font-size:28px; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        table th,table td { padding:8px; border:1px solid #ccc; }
        table th { background:#eee; }
    </style>
</head>
<body>
<div class="certificate">
    <div class="header">
        <h1>Certificate of Registration (COR)</h1>
        <p>Academic Year: 2025-2026 | 1st Semester</p>
        <p>Institution Name: CCSFP</p>
    </div>
    <div class="student-info">
        <h3>Student Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($request_data['name']) ?></p>
        <p><strong>Program:</strong> <?= htmlspecialchars($request_data['course']) ?></p>
        <p><strong>Year Level:</strong> <?= htmlspecialchars($request_data['year_level']) ?></p>
    </div>
    <div class="registration-info">
        <h3>Registration Details</h3>
        <table>
            <tr><th>Course Code</th><th>Description</th><th>Schedule</th><th>Units</th></tr>
            <tr><td>IT 201</td><td>Data Structures</td><td>MWF 9:00-10:00 AM</td><td>3</td></tr>
            <tr><td>IT 202</td><td>Database Systems</td><td>TTh 10:00-11:30 AM</td><td>3</td></tr>
            <tr><td>IT 203</td><td>Web Development</td><td>MWF 11:00-12:00 PM</td><td>3</td></tr>
        </table>
    </div>
</div>
</body>
</html>
