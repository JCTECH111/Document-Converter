<?php
// Sanitize the password input
$input_password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Retrieve the uploaded PDF file and set output folder
$pdfFile = $_FILES['file']['tmp_name'];
$outputFolder = '../../files/'; // Ensure this directory exists or is writable
$password = $input_password;

// Ensure the output folder exists and is writable
if (!file_exists($outputFolder)) {
    if (!mkdir($outputFolder, 0777, true)) {
        echo json_encode(['error' => 'Failed to create output folder.']);
        exit;
    }
}

// Define the output file path
$outputFile = $outputFolder . 'output_locked.pdf';

// Get the absolute path of the PDF file
$pdfFilePath = realpath($pdfFile);

if (!$pdfFilePath) {
    echo json_encode(['error' => 'PDF file not found.']);
    exit;
}

// Build the command to execute the Python script
$command = escapeshellcmd("python ../python/lockPdf.py " . escapeshellarg($pdfFilePath) . " " . escapeshellarg($outputFile) . " " . escapeshellarg($password));

// Execute the Python script
$output = shell_exec($command);

// Check if the output file was successfully created
if (file_exists($outputFile)) {
    echo json_encode(['success' => true, 'file_url' => $outputFile]);
} else {
    echo json_encode(['error' => 'Failed to lock the PDF. Error: ' . $output]);
}
