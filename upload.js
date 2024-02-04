$(document).ready(function() {
    $('#uploadButton').on('click', function() {
        var fileInput = $('#fileInput')[0];
        var file = fileInput.files[0];

        if (!file) {
            showMessage('error', 'Please select a file.');
            return;
        }

        var formData = new FormData();
        formData.append('file', file);

        $.ajax({
            url: '/upload-api',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    showMessage('success', 'File uploaded successfully.');
                } else {
                    showMessage('error', response.message || 'An error occurred.');
                }
            },
            error: function(xhr, status, error) {
                showMessage('error', 'An error occurred while uploading the file.');
            }
        });
    });

    function showMessage(type, text) {
        var messageContainer = $('#messageContainer');
        messageContainer.empty();
        
        var messageDiv = $('<div>').addClass('message').addClass(type).text(text);
        messageContainer.append(messageDiv);
    }
});