<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '[name^="btnAdd"]', function() {
        var $modal = $(this).closest('.modal');

        var id = $modal.find('[name="id"]').val();
        var claim_id = $modal.find('[name="claim_id"]').val();
        var app_id = $modal.find('[name="app_id"]').val();
        var user_id = $modal.find('[name="user_id"]').val();
        var twentyperamount = $modal.find('[name="twentyperamount"]').val();
        var twentyperdisbursementdate = $modal.find('[name="twentyperdisbursementdate"]').val();
        var date_of_submission_by_bene = $modal.find('[name="date_of_submission_by_bene"]').val();
        var percentage = $modal.find('[name="percentage"]').val();
        var remark = $modal.find('[name="remark"]').val();

        var data = {
            id: id,
            claim_id: claim_id,
            app_id: app_id,
            user_id: user_id,
            twentyperamount: twentyperamount,
            twentyperdisbursementdate: twentyperdisbursementdate,
            date_of_submission_by_bene: date_of_submission_by_bene,
            percentage: percentage,
            remark: remark
        };



        // AJAX request
        $.ajax({
            url: '/admin/claims/twentyperclaim/' + id,
            method: 'POST',
            data: data,
            success: function(response) {
                console.log(response);

                if (response.code) {
                    swal("Success", "Record Inserted successfully.", "success");
                    location.reload();
                } else {
                    swal("Warning", "Failed to Insert record", "warning");
                    location.reload();

                }
            },
            error: function(xhr, status, error) {
                
                var response = xhr.responseJSON;
                if (response && response.errors && response.errors.twentyperamount) {
                    $(".twentyperamount").removeClass('d-none');
                    $(".twentyperamount").text('This field is required');
                }
                if (response && response.errors && response.errors.twentyperdisbursementdate) {
                    $(".twentyperdisbursementdate").removeClass('d-none');
                    $(".twentyperdisbursementdate").text('This field is required');
                }
                if (response && response.errors && response.errors.date_of_submission_by_bene) {
                    $(".date_of_submission_by_bene").removeClass('d-none');
                    $(".date_of_submission_by_bene").text('This field is required');
                }
                if (response && response.errors && response.errors.percentage) {
                    $(".percentage").removeClass('d-none');
                    $(".percentage").text('This field is required');
                }

                return false;
                alert('An error occurred while updating the record.');
            }
        });
    });

    // Refresh the page when the modal is hidden
    $('#addtransict{{ $data->id }}').on('hidden.bs.modal', function() {
        location.reload();
    });
</script>
