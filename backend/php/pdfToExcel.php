<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Define the command to run the Python script
    $command = escapeshellcmd("python ../python/pdfToExcel.py " . escapeshellarg($pdfFile) . " " . escapeshellarg($outputFolder));
    $output = shell_exec($command);

    // Check if the command output indicates success
    if (trim($output) === "success") {
        // Return the converted file URL
        $outputFile = $outputFolder . $_FILES['file']['name'];
        echo json_encode(['success' => true, 'file_url' => '../../files/' . basename($outputFile)]);
    } else {
        // Handle errors
        echo json_encode(['error' => 'Pdf must be in a Table format']);
    }
}
