
$(document).ready(function() {
    // Submit form when file input changes (when a file is selected manually)
    $('#formUrl').on('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData(this);

        // Show progress bar
        $('#progressContainer').show();
        closeModalBtn.click();


        $.ajax({
            url: '../backend/php/htmlToPdf.php', // URL to the PHP script that processes the data
            type: 'POST',
            data: formData,
            contentType: false, // Important for file uploads
            processData: false, // Important for file uploads
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(event) {
                    if (event.lengthComputable) {
                        var percentComplete = Math.round((event.loaded / event.total) * 100);
                        $('#progressBar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                });
                return xhr;
            },
            beforeSend: function() {
                $('#progressBar').css('background', '#4caf50')
                $('#spinner').removeClass('hidden')
            },
            success: function(response) {
                var result = JSON.parse(response);

                if (result.success) {
                    $('#convertedFileLink').attr('href', result.file_url);
                    $('#downloadLink').removeClass('hidden');
                    $('#pageCount').text("Your Documents is ready Click here to download 👇 "); // Display the page count
                } else {
                    $('#progressBar').css('background', 'red').text(result.error);
                    console.error('Conversion failed: ', result.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Request failed:', status, error);
                $('#progressBar').css('background', 'red').text('Error: ' + error);
            },
            complete: function() {
                // Hide progress bar after completion
                $('#spinner').addClass('hidden')
            }
        });
    
    });
});