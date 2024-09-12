<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticker Removal Tool</title>
    <style>
        body {
            text-align: center;
        }
        canvas {
            border: 1px solid black;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Upload your Image to Remove Stickers</h1>
    <input type="file" id="uploadImage" accept="image/*">
    <br><br>
    <button id="processImage">Process Image</button>
    <br><br>
    <canvas id="imageCanvas"></canvas>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let canvas = document.getElementById('imageCanvas');
        let ctx = canvas.getContext('2d');
        let image = new Image();

        document.getElementById('uploadImage').addEventListener('change', function(event) {
            let file = event.target.files[0];
            let reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });

        image.onload = function() {
            canvas.width = image.width;
            canvas.height = image.height;
            ctx.drawImage(image, 0, 0);
        };

        document.getElementById('processImage').addEventListener('click', function() {
            let formData = new FormData();
            formData.append('image', document.getElementById('uploadImage').files[0]);

            fetch('../backend/php/process_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    image.src = data.file;
                } else {
                    alert('Error processing image');
                }
            });
        });
    </script>
</body>
</html>
