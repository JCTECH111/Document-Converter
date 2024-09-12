<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imageFileTmp = $_FILES['file']['tmp_name'];
    $outputPdfDir = '../../files/';
    $outputPdfFile = $outputPdfDir . 'output.pdf';

    // Ensure the output folder exists
    if (!file_exists($outputPdfDir)) {
        mkdir($outputPdfDir, 0777, true);
    }

    // Validate the uploaded file is an image
    $fileInfo = pathinfo($_FILES['file']['name']);
    $extension = strtolower($fileInfo['extension']);
    $validExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

    if (!in_array($extension, $validExtensions)) {
        echo json_encode(['error' => 'Invalid file format. Please upload an image.']);
        exit;
    }

    // Define the new file path with the correct extension
    $imageFile = $outputPdfDir . basename($_FILES['file']['name']);

    // Move the uploaded image to the new location
    if (move_uploaded_file($imageFileTmp, $imageFile)) {
        // Set up the Python script command
        $command = escapeshellcmd("python ../python/imageToPdf.py " . escapeshellarg($imageFile) . " " . escapeshellarg($outputPdfFile));
        $output = shell_exec($command);

        // Check if the output PDF file exists
        if (file_exists($outputPdfFile)) {
            echo json_encode(['success' => true, 'file_url' => '../../files/' . basename($outputPdfFile)]);
        } else {
            echo json_encode(['error' => 'Conversion failed: ' . $output]);
        }
    } else {
        echo json_encode(['error' => 'Failed to move the uploaded file.']);
    }
}
