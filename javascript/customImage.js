document.getElementById('image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const label = document.querySelector('label[for="image"]');
    const image = document.getElementById('selectedImage');
    
    if (file) {
        // Hide the label
        label.style.display = 'none';
        
        // Display the selected image
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            image.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        // Show the label if no file is selected
        label.style.display = 'block';
        image.classList.add('hidden');
    }
});
document.getElementById("submitImage").addEventListener('click', submitForm)
// Function to submit the form using AJAX
function submitForm() {
    var formData = new FormData($('#customImageForm')[0]);

    // Show progress bar
    $('#progressContainer').show();

    $.ajax({
        url: '../backend/php/customimage.php', // URL to the PHP script that processes the data
        type: 'POST',
        data: formData,
        contentType: false, // Important for file uploads
        processData: false, // Important for file uploads
        xhr: function() {
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(event) {

            });
            return xhr;
        },
        beforeSend: function() {
            $('#spinner').removeClass('hidden')
            // Show shimmer effect on the image container
            $('#shimmerOverlay').removeClass('hidden');
        },
        success: function(response) {
            var result = JSON.parse(response);

            if (result.success) {
                $('#convertedFileLink').attr('href', result.outputFile);
                $('#downloadLink').removeClass('hidden');
                $('#submitImage').removeClass('hidden');
                $('#selectedImage').attr('src', result.outputFile);
            } else {
                $('#pageCount').text(result.message); // Display the page count
                console.log('====================================');
                console.log(result);
                console.log('====================================');
                console.error('Conversion failed: ', result.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Request failed:', status, error);
        },
        complete: function() {
            // Hide progress bar after completion
            $('#spinner').addClass('hidden')
            $('#shimmerOverlay').addClass('hidden');
        }
    });
}