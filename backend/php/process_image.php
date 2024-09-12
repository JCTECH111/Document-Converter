<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $upload_path = "../../files/" . $file_name;

        move_uploaded_file($file_tmp, $upload_path);

        // Call Python script to process the image
        $command = escapeshellcmd("python ../python/process_sticker_removal.py " . $upload_path);
        $output = shell_exec($command);

        // Assuming the Python script saves the processed image with "_processed" suffix
        $processed_file = "../../files/" . pathinfo($file_name, PATHINFO_FILENAME) . "_processed." . pathinfo($file_name, PATHINFO_EXTENSION);
        if (file_exists($processed_file)) {
            echo json_encode(['success' => true, 'file' => $processed_file]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
