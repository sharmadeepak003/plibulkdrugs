<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '[name^="btnUpd"]', function() {
        var id = $(this).attr('name').replace('btnUpd', '');
        var twentyperamount = $('[name="twentyperamount' + id + '"]').val();
        var twentyperdisbursementdate = $('[name="twentyperdisbursementdate' + id + '"]').val();
        var date_of_submission_by_bene = $('[name="date_of_submission_by_bene' + id + '"]').val();
        var percentage = $('[name="percentage' + id + '"]').val();
        var remark = $('[name="remark' + id + '"]').val();
        console.log(id, twentyperamount, twentyperdisbursementdate, date_of_submission_by_bene, percentage,
            remark);
        // AJAX request

        var data = {
    id: id,
    twentyperamount: twentyperamount,
    twentyperdisbursementdate: twentyperdisbursementdate,
    date_of_submission_by_bene: date_of_submission_by_bene,
    percentage: percentage,
    remark: remark
};
        $.ajax({
            url: '/admin/claims/twentyper/', // Specify your endpoint
            method: 'POST', // Or 'GET' depending on your server setup
            data: data,
            success: function(response) {
                // Handle success response

                if (response.code) {
                    swal("Success", "Record updated successfully.", "success");
                    location.reload();
                } else {
                    swal("Warning", "Failed to update record", "warning");
                    location.reload();

                }
            },
            error: function(xhr, status, error) {
                var response = xhr.responseJSON;
                //alert(data.id)
                console.log(response);
                //alert(response.errors.twentyperamountT +'----'+ data.id);

                if(response && response.errors && response.errors.twentyperamount) 
                {
                    $("#twentyperamount"+data.id).removeClass('d-none');
                    $("#twentyperamount"+data.id).text('This field is required');
                }

                if(response && response.errors && response.errors.twentyperdisbursementdate) 
                {
                    $("#twentyperdisbursementdate"+data.id).removeClass('d-none');
                    $("#twentyperdisbursementdate"+data.id).text('This field is required');
                }
                if(response && response.errors && response.errors.date_of_submission_by_bene ) 
                {
                    $("#date_of_submission_by_bene"+data.id).removeClass('d-none');
                    $("#date_of_submission_by_bene"+data.id).text('This field is required');
                }
                if(response && response.errors && response.errors.percentage ) 
                {
                    $("#percentage"+data.id).removeClass('d-none');
                    $("#percentage"+data.id).text('This field is required');
                }
                
                 return false;
                alert('An error occurred while updating the record.');
            }
        });
    });
</script>