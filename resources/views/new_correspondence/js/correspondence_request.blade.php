
<script>
    $(document).ready(function() {
        $(document).on("change", "#category", function() {
            // dd('pk1');
            var category = $(this).val();
            //    alert('/category/' + category);
            if (category) {
                $.ajax({
                    url: '/category/' + category,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // alert(category);
                        if (category == 3) {
                            $("#compNmLabel").show();
                            $("#company_nm").show();
                            $("#pan").hide();
                            $("#panLabel").hide();
                            $("#dp_folio").hide();
                            $("#dpLabel").hide();
                            $("#emp_id").hide();
                            $("#empIdLabel").hide()
                            $("#desig").hide();
                            $("#desigLabel").hide();
                        } else {
                            if (category == 4) {
                                $("#emp_id").show();
                                $("#empIdLabel").show();
                                $("#desig").show();
                                $("#desigLabel").show();
                                $("#pan").hide();
                                $("#panLabel").hide();
                                $("#dp_folio").hide();
                                $("#dpLabel").hide();
                                $("#compNmLabel").hide();
                                $("#company_nm").hide();
                            } else {
                                $("#emp_id").hide();
                                $("#empIdLabel").hide();
                                $("#desig").hide();
                                $("#desigLabel").hide();
                                $("#compNmLabel").hide();
                                $("#company_nm").hide();
                                $("#pan").show();
                                $("#panLabel").show();
                                $("#dp_folio").show();
                                $("#dpLabel").show();
                            }
                        }
                        $('#catsubtype').empty();
                        $('#catsubtype').append(
                            '<option value="">Please Choose..</option>');
                        $.each(data, function(key, value) {
                            $('#catsubtype').append(
                                '<option value="' + value + '">' + key +
                                '</option>');
                        });
                    }
                });
            } else {
                $('#catsubtype').empty();
            }

            $(document).on("change", "#catsubtype", function() {
                // dd('pk1');
                var catsubtype = $(this).val();
                // alert(catsubtype);
                if (category) {
                    $.ajax({
                        url: '/reqtype/' + category + '/' + catsubtype,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // alert(category);
                            $('#reqtype').empty();
                            $('#reqtype').append(
                                '<option value="">Please Choose..</option>');
                            $.each(data, function(key, value) {
                                $('#reqtype').append(
                                    '<option value="' + value + '">' +
                                    key +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#reqtype').empty();
                }
            });
        });
    });


    var i = 0;
    $("#add").click(function() {
        ++i;
        $("#dynamicTable").append(
            '<div class="row pb-2"><div class="col-md-8 "><div class="form"><input type="file" name="reqdoc[]" class="form-control" multiple></div></div><div class="col-md-2"><div class="form"><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-minus"></i></button></div></div></div>'
        );
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).closest(".row").remove();
    });
</script>
<script>
    updateList = function() {
        var input = document.getElementById('file');
        var output = document.getElementById('fileList');

        output.innerHTML = '<ul>';
        for (var i = 0; i < input.files.length; ++i) {
            output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
        }
        output.innerHTML += '</ul>';
    }
</script>

<script>
    $(document).ready(function() {
        const btn_modal = document.getElementById("submitshareper");

        $('.prevent_multiple_submit').on('submit', function() {
            $(".prevent_multiple_submit").parent().append(
                '<div class="offset-md-4 msg"><span class="text-danger text-sm text-center">Please wait while your request is being processed. &nbsp&nbsp&nbsp<i class="fa fa-spinner fa-spin" style="font-size:24px;color:black"></i></span></div>'
                );

          
            btn_modal.disabled = true;
            setTimeout(function() {
                btn.disabled = false;
            }, (1000 * 50));
            setTimeout(function() {
                btn_modal.disabled = false;
            }, (1000 * 50));
            setTimeout(function() {
                $(".msg").hide()
            }, (1000 * 50));
        });

    });
</script>
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
                        $.each(data.applicantData, function(key, value) {
                            $('#application_number').append(
                                '<option value="' + value['app_no'] + '">' +
                                value['app_no'] +
                                '</option>');
                        });
                      
                    }
                });
            }

        });


    });
</script>

<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
         
            var userlist_id = $('#userlist').val();
            if (userlist_id) {
                $.ajax({
                    url: '/correspondence/ClaimNumberList/' + userlist_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var categoryvalue = $('#category').val();
                        $('#claim_no').empty();
                        $('#claim_show_dv').hide();
                       if(categoryvalue==4){
                        $('#claim_show_dv').show();
                       
                        $('#claim_no').append(
                            '<option value="">Select</option>');
                        $.each(data.claim_no, function(key, value) {
                            $('#claim_no').append(
                                '<option value="' + value['claim_id'] + '">' + value[
                                    'claim_number'] +
                                '</option>');
                        });
                    }

                    }
                });
            }

        });


    });
</script>
