
$(document).ready(function () {
    // Handle drag over event
    $('#dropArea').on('dragover', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).addClass('bg-gray-800');
    });

    // Handle drag leave event
    $('#dropArea').on('dragleave', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass('bg-gray-800');
    });

    // Handle file drop event
    $('#dropArea').on('drop', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass('bg-gray-800');

        // Assign the dropped files to the hidden input
        const files = event.originalEvent.dataTransfer.files;
        $('#fileInput').prop('files', files);

        submitForm(); // Trigger form submission
    });

    // Handle click to open file dialog
    $('#dropArea').on('click', function () {
        $('#fileInput').click();
    });

    // Submit form when file input changes (when a file is selected manually)
    $('#fileInput').on('change', function () {
        submitForm(); // Trigger form submission
    });

    // Function to submit the form using AJAX
    function submitForm() {
        var formData = new FormData($('#form')[0]);

        // Show progress bar
        $('#progressContainer').show();

        $.ajax({
            url: '../backend/php/html-to-xml.php', // URL to the PHP script that processes the data
            type: 'POST',
            data: formData,
            contentType: false, // Important for file uploads
            processData: false, // Important for file uploads
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        var percentComplete = Math.round((event.loaded / event.total) * 100);
                        $('#progressBar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                });
                return xhr;
            },
            beforeSend: function () {
                $('#progressBar').css('background', '#4caf50')
                document.getElementById('code-text').textContent = "";
            },
            success: function (response) {
                if (response) {
                    typeWriter(response, 10);
                } else {
                    $('#progressBar').css('background', 'red').text(result.error);
                    console.error('Conversion failed: ', result.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Request failed:', status, error);
                $('#progressBar').css('background', 'red').text('Error: ' + error);
            },
            complete: function () {
                // Hide progress bar after completion
                $('#spinner').addClass('hidden')
            }
        });
    }

    function typeWriter(text, speed) {
        let i = 0;

        function type() {
            if (i < text.length) {
                // Append the next character to the text
                document.getElementById('code-text').textContent += text.charAt(i);
                Prism.highlightElement(document.getElementById('code-text'));
                // Call this function whenever you need to scroll to the bottom
                i++;
                setTimeout(type, speed);
            }
        }
        scrollToBottom();
        type();
    }
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth' // Smooth scrolling behavior
        });
    }


});