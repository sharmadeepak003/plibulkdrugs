<script>
    $('#user_type').on('change', function() {
        var user_type = jQuery(this).val();
        if (user_type) {
            jQuery.ajax({
                url: '/correspondence/usersList/' + user_type,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#userlist').empty();
                    $('#userlist').append(
                        '<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        $('#userlist').append(
                            '<option value="' + value['id'] + '">' + value['name'] +
                            '</option>');
                    });

                }
            });
        }

    });
</script>
