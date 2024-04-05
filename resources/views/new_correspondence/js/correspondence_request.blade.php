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


<script>
    $(document).ready(function() {
    $('#userlist').on('change', function() {
        var applicant_id = jQuery(this).val();
       
        if (applicant_id) {
           
            $.ajax({
                url: '/correspondence/applicationNumberList/' + applicant_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#application_number').empty();
                    $('#application_number').append(
                        '<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        $('#application_number').append(
                            '<option value="' + value['app_no'] + '">' + value['app_no'] +
                            '</option>');
                    });

                }
            });
        }

    });


});
</script>
