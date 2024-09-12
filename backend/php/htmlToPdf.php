<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $websiteUrl = $_POST['websiteUrl'];
    $outputPdfDir = '../../files/';
    $outputPdfFile = $outputPdfDir . 'output.pdf';

    // Ensure the output folder exists
    if (!file_exists($outputPdfDir)) {
        mkdir($outputPdfDir, 0777, true);
    }

    // Validate the input is a valid URL
    if (filter_var($websiteUrl, FILTER_VALIDATE_URL) === false) {
        echo json_encode(['error' => 'Invalid URL.']);
        exit;
    }

    // Set up the Python script command
    $command = escapeshellcmd("python ../python/htmlToPdf.py " . escapeshellarg($websiteUrl) . " " . escapeshellarg($outputPdfFile));
    $output = shell_exec($command);

    // Check if the output PDF file exists
    if (file_exists($outputPdfFile)) {
        echo json_encode(['success' => true, 'file_url' => '../../files/' . basename($outputPdfFile)]);
    } else {
        echo json_encode(['error' => 'Conversion failed: ' . $output]);
    }
}
