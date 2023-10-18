
<script>
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            event.preventDefault();
            const schoolId = $('#schoolSelect').val();
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: { school_id: schoolId },
                success: function(response) {
                    if (response) {
                        let membersList = '<ul class="list-group">';
                        let members = JSON.parse(response)["data"]["members"];
                        members.forEach(function(member) {
                            membersList += `<li class="list-group-item">ID: ${member.id}; Name: ${member.name}; Email: ${member.email}</li>`;
                        });

                        membersList += '</ul>';
                        $('#results').html(membersList);
                    } else {
                        $('#results').html('<p>No members found for this school.</p>');
                    }
                },
                error: function() {
                    $('#results').html('<p>Error occurred while fetching members.</p>');
                }
            });
        });
    });

</script>