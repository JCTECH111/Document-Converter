<?php
// Ensure the file and output format are provided
if (isset($_FILES['image']) && isset($_POST['outputFormat'])) {
    $file = $_FILES['image'];
    $outputFormat = strtoupper($_POST['outputFormat']); // Ensure format is uppercase

    // Define allowed formats (including SVG for input and output)
    $allowedFormats = ['JPEG', 'PNG', 'GIF', 'BMP', 'TIFF', 'WEBP', 'SVG'];

    // Check if the selected format is valid
    if (!in_array($outputFormat, $allowedFormats)) {
        echo json_encode(['success' => false, 'message' => 'Invalid output format']);
        exit();
    }

    // Ensure the file is an image (allow SVG as an input type)
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg'];

    if (!in_array($imageFileType, $validExtensions)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit();
    }

    // Move the uploaded file to a temporary location
    $inputFile = '../../files/' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $inputFile);

    // Define the output file path (same name, but different extension)
    $outputFile = '../../files/' . pathinfo($inputFile, PATHINFO_FILENAME) . '.' . strtolower($outputFormat);

    // Run the Python script to convert the image
    $command = escapeshellcmd("python ../python/customImage.py $inputFile $outputFile $outputFormat");
    $output = shell_exec($command);

    // Check if the conversion was successful
    if (file_exists($outputFile)) {
        echo json_encode(['success' => true, 'outputFile' => $outputFile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Image conversion failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file or format specified']);
}
?>
