<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $format = "docx";
    $pdfFile = $_FILES['file']['tmp_name'];

    // Define the output folder
    $outputFolder = '../../files/'; // Ensure this directory exists or is writable

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
    // Define the output file path
    $outputFile = $outputFolder . 'output.' . $format;

    // Get the absolute path of the PDF file
    $pdfFilePath = realpath($pdfFile);
    
    // Set up the Python script command
    $command = escapeshellcmd("python ../python/pdfToWord.py " . escapeshellarg($pdfFilePath) . " " . escapeshellarg($format) . " " . escapeshellarg($outputFolder));
    $output = shell_exec($command);

    // Check for 'too_big' message in the output
    if (strpos($output, 'too_big') !== false) {
        // If the file is too large, send an error message
        preg_match('/(\d+) pages/', $output, $matches);
        $num_pages = $matches[1];
        echo json_encode(['error' => "File too big: {$num_pages} pages. It shuoldn't exceed 20 Pages or Pay for Premiun features"]);
    } elseif (strpos($output, 'success') !== false) {
        $outputParts = explode(",", trim($output));
        $pageCount = isset($outputParts[1]) ? $outputParts[1] : 'unknown';
        $outputFile = $outputFolder . 'output.' . $format;
        echo json_encode(['success' => true, 'file_url' => '../../files/' . basename($outputFile), 'fileCount' => $pageCount]);
    } else {
        // Handle other errors or invalid format
        echo json_encode(['error' => $output]);
    }
}
