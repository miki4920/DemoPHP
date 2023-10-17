<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            const schoolId = $('#schoolSelect').val();
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: { school_id: schoolId }, // data to be sent to the server
                success: function(response) {
                    // Check if the response is valid and contains the expected data
                    if (response && response.message) {
                        let membersList = '<ul class="list-group">';
                        let members = JSON.parse(response.message)["data"]["members"];
                        members["data"].forEach(function(member) {
                            membersList += '<li class="list-group-item">' + member.name + '</li>'; // assuming 'name' is a property of member
                        });

                        membersList += '</ul>';
                        $('#results').html(membersList); // Inserting the members list into the "results" div
                    } else {
                        $('#results').html('<p>No members found for this school.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    $('#results').html('<p>Error occurred while fetching members.</p>');
                }
            });
        });
    });
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            event.preventDefault();

            var actionUrl = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: formData,
                success: function(response) {
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
</body>
</html>
