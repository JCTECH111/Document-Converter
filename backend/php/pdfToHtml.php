<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdfFile = $_FILES['file']['tmp_name'];
    $outputFolder = '../../files/'; // Define output folder

    // Ensure the output folder exists
    if (!file_exists($outputFolder)) {
        mkdir($outputFolder, 0777, true);
    }
    // Validate the uploaded file is an Excel file
    $fileInfo = pathinfo($_FILES['file']['name']);
    $extension = strtolower($fileInfo['extension']);
    
    if ($extension !== 'pdf') {
        echo json_encode(['error' => 'Invalid file format. Please upload a Pdf Document.']);
        exit;
    }

    // Define the Python script command
    $command = escapeshellcmd("python ../python/pdfToHtml.py " . escapeshellarg($pdfFile) . " " . escapeshellarg($outputFolder));
    $output = shell_exec($command);

    // Parse the output from Python
    if (preg_match('/HTML file saved at: (.+)/', $output, $matches)) {
        $htmlFile = $matches[1];
        echo json_encode(['success' => true, 'html_file' => $htmlFile]);
    } else {
        echo json_encode(['error' => 'Failed to convert PDF to HTML']);
    }
}

