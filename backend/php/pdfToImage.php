<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdfFile = $_FILES['file']['tmp_name'];
    $imageFormat = "jpg"; // You can change this to 'png' if needed

    // Define the output folder
    $outputFolder = '../../files/images/'; // Ensure this directory exists or is writable

    // Ensure the output folder exists
    if (!file_exists($outputFolder)) {
        mkdir($outputFolder, 0777, true);
    }

    // Set up the Python script command
    $command = escapeshellcmd("python ../python/pdfToImage.py " . escapeshellarg($pdfFile) . " " . escapeshellarg($outputFolder) . " " . escapeshellarg($imageFormat));
    $output = shell_exec($command);

    // Capture the image file paths printed by the Python script
    $lines[] =  $output;
    $image_urls = [];


     // Iterate through the output lines and capture all image paths
     foreach ($lines as $line) {
        if (strpos($line, 'Saved image:') !== false) {
            // Extract the file path from the printed line
            $image_urls = trim(str_replace('Saved image:', '', $line));
        }
    }

    // // Check if any images were found
    if (isset($image_urls)) {
        echo json_encode(['success' => true, 'image_urls' => $image_urls]);
    } else {
        echo json_encode(['error' => 'No images were found after conversion']);
    }
}
