<?php
require __DIR__ . '/database/db_config.php';
require __DIR__ . '/user.php';
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

$user = new User($pdo);
$id = $_GET['id'];
$request = $user->getRequestById($id);

if (!$request) {
    die('Request not found.');
}

// Choose template file based on document_request
switch ($request['document_request']) {
    case 'COR':
        $template_file = 'cor.php';
        break;
    case 'COE':
        $template_file = 'coe.php';
        break;
    case 'COG':
        $template_file = 'cog.php';
        break;
    default:
        die('Unknown document type.');
}

// Capture template output
$request_data = $request; // pass into template
ob_start();
include __DIR__ . '/document/' . $template_file;
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// ✅ IMPORTANT: use student_number here
$dompdf->stream(
    $request['document_request'] . '_' . $request['student_number'] . '.pdf',
    ["Attachment" => false]
);
