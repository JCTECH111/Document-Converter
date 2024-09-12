<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the file was uploaded successfully
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $xlsxFileTmp = $_FILES['file']['tmp_name'];
        $outputPdfDir = '../../files/';
        $outputPdfFile = $outputPdfDir . 'output.pdf';

        // Ensure the output folder exists
        if (!file_exists($outputPdfDir)) {
            mkdir($outputPdfDir, 0777, true);
        }

        // Validate the uploaded file is an Excel file
        $fileInfo = pathinfo($_FILES['file']['name']);
        $extension = strtolower($fileInfo['extension']);
        
        if ($extension !== 'xlsx' && $extension !== 'xls') {
            echo json_encode(['error' => 'Invalid file format. Please upload an Excel file.']);
            exit;
        }

        // Define the new file path with the correct .xlsx extension
        $xlsxFile = $outputPdfDir . basename($_FILES['file']['name']);

        // Move the uploaded file to the new location
        if (move_uploaded_file($xlsxFileTmp, $xlsxFile)) {
            // Set up the Python script command
            $command = escapeshellcmd("python ../python/excelToPdf.py " . escapeshellarg($xlsxFile) . " " . escapeshellarg($outputPdfFile));
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
    } else {
        echo json_encode(['error' => 'No file was uploaded or there was an error uploading the file.']);
    }
}
