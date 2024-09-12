<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $docxFileTmp = $_FILES['file']['tmp_name'];
    $outputPdfDir = '../../files/';
    $outputPdfFile = $outputPdfDir . 'output.pdf';

    // Ensure the output folder exists
    if (!file_exists($outputPdfDir)) {
        mkdir($outputPdfDir, 0777, true);
    }
    // Validate the uploaded file is an Excel file
    $fileInfo = pathinfo($_FILES['file']['name']);
    $extension = strtolower($fileInfo['extension']);
    
    if ($extension !== 'docx') {
        echo json_encode(['error' => 'Invalid file format. Please upload a Pdf Document.']);
        exit;
    }

    // Define the new file path with the correct .docx extension
    $docxFile = $outputPdfDir . basename($_FILES['file']['name']);

    // Move the uploaded file to the new location with the correct extension
    move_uploaded_file($docxFileTmp, $docxFile);

    // Set up the Python script command
    $command = escapeshellcmd("python ../python/wordToPdf.py " . escapeshellarg($docxFile) . " " . escapeshellarg($outputPdfFile));
    $output = shell_exec($command);

    // Check if the output PDF file exists
    if (file_exists($outputPdfFile)) {
        echo json_encode(['success' => true, 'file_url' => '../../files/' . basename($outputPdfFile)]);
    } else {
        echo json_encode(['error' => 'Conversion failed: ' . $output]);
    }
}
