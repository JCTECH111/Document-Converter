<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    // Directory to store uploaded files
    $uploadDir = '../../files/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    
    // Move uploaded file to the directory
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        // Run the Python script with the uploaded file as an argument
        $output = shell_exec("python ../python/jsToTs.py " . escapeshellarg($uploadFile));
        
        // Show the TypeScript output to the user
        echo $output;
    } else {
        echo "File upload failed!";
    }
} else {
    echo "No file uploaded!";
}

