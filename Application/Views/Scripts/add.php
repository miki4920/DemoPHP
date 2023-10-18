<script>
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            event.preventDefault();

            var actionUrl = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: formData,
                success: function() {
                    showMessage("Operation Successful", 'success');
                    $('form')[0].reset();
                },
                error: function(response) {
                    let result = JSON.parse(response.responseText);
                    let message = result.message;
                    showMessage(message, 'danger');
                }
            });
        });

        function showMessage(message, type) {
            let messageBox = $('#messageBox');
            messageBox.removeClass('alert-success alert-danger');
            messageBox.addClass('alert-' + type).addClass('show');
            $('#messageContent').text(message);
            messageBox.fadeIn();

            setTimeout(function() {
                messageBox.fadeOut();
            }, 2500);
        }
    });
</script>