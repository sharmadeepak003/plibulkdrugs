{{-- Add --}}
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
    $(document).ready(function() {
    $('#addtransict{{ $data->id }}').on('closemodal', function() {
        location.reload();
    });

    $('.closemodal').on('click', function() {
        $('#addtransict{{ $data->id }}').trigger('closemodal');
    });
});
</script>

{{--End Add  --}}

{{-- Update --}}
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
            method: "POST", // Or 'GET' depending on your server setup
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

     // Refresh the page when the modal is hidden
     $(document).ready(function() {
    $('#addtransict{{ $data->id }}').on('closemodal', function() {
        location.reload();
    });

    $('.closemodal').on('click', function() {
        $('#addtransict{{ $data->id }}').trigger('closemodal');
    });
});
</script>
{{-- End Update --}}

{{--  --}}

<script>
    async function checkDate(input, claimIndex) {
        var reportInfo = document.getElementById('reportInfo' + claimIndex).value;
        await new Promise(resolve => setTimeout(resolve, 1000)); // Simulating 1 second delay
        var reportMeitytoPMA = input.value;
        var reportInfoObj = new Date(reportInfo);
        var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
        var timeDiff = reportMeitytoPMAObj - reportInfoObj;
        var diffDays = timeDiff / (1000 * 3600 * 24);

        if (diffDays < 0) {
            swal({
                title: "Invalid Date",
                text: 'Report to Ministry by PMA date cannot be earlier than Report Info Date',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            });
            // alert('Report MeitytoPMA date cannot be earlier than Filing Date');
            input.value = '';
            $('#noOfDaysSubReport' + claimIndex).val('');
            $('#noOfDaysCompData' + claimIndex).val('');
        }
    }


    async function checkCia(input, claimIndex) {
        var filingDate = document.getElementById('filingDate' + claimIndex).value;
        await new Promise(resolve => setTimeout(resolve, 1000)); // Simulating 1 second delay
        var reportInfo = input.value;
        var filingDateObj = new Date(filingDate);
        var reportInfoObj = new Date(reportInfo);
        var timeDiff = reportInfoObj - filingDateObj;
        var diffDays = timeDiff / (1000 * 3600 * 24);

        if (diffDays < 0) {
            // Simulating an asynchronous operation that takes some time
            swal({
                title: "Invalid Date",
                text: 'Report Info date cannot be earlier than Filing Date',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            });
            // alert('Report Info date cannot be earlier than Filing Date');
            input.value = '';
            $('#noOfDaysSubReport' + claimIndex).val('');
            $('#noOfDaysCompData' + claimIndex).val('');
        }
    }


    async function checkDdcp(input, claimIndex) {
        var reportMeitytoPMA = document.getElementById('reportMeitytoPMA' + claimIndex).value;
        await new Promise(resolve => setTimeout(resolve, 1000));
        var date_of_disbursal_claim_pma = input.value;
        var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
        var date_of_disbursal_claim_pma = new Date(date_of_disbursal_claim_pma);
        var timeDiff = date_of_disbursal_claim_pma - reportMeitytoPMAObj;
        var diffDays = timeDiff / (1000 * 3600 * 24);

        if (diffDays < 0) {
            swal({
                title: "Invalid Date",
                text: 'Date Of Disbursal Claim PMA date cannot be earlier than Report to Ministry by PMA',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            });
            // alert('Date Of Disbursal Claim PMA date cannot be earlier than Filing Date');
            input.value = '';
            $('#total_duration_disbursal' + claimIndex).val('');
        }
    }
    async function checkAppr(input, claimIndex) {
        var reportMeitytoPMA = document.getElementById('reportMeitytoPMA' + claimIndex).value;
        await new Promise(resolve => setTimeout(resolve, 1000));
        var apprdate = input.value;
        var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
        var apprdate = new Date(apprdate);
        var timeDiff = apprdate - reportMeitytoPMAObj;
        var diffDays = timeDiff / (1000 * 3600 * 24);

        if (diffDays < 0) {
            swal({
                title: "Invalid Date",
                text: 'Approval date cannot be earlier than Report to Ministry by PMA',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            });
            // alert('Date Of Disbursal Claim PMA date cannot be earlier than Filing Date');
            input.value = '';
            $('#total_duration_disbursal' + claimIndex).val('');
        }
    }

    async function checkResDate(input, claimIndex) {
        var raisedate = document.getElementById('raise' + claimIndex).value;
        await new Promise(resolve => setTimeout(resolve, 1000));
        var response_date = input.value;
        var raisedateObj = new Date(raisedate);
        var response_dateObj = new Date(response_date);
        var timeDiff = response_dateObj - raisedateObj;
        var diffDays = timeDiff / (1000 * 3600 * 24);
        // console.log(raisedate,response_date,raisedateObj,response_dateObj,timeDiff,diffDays);

        if (diffDays < 0) {
            console.log('if');
            swal({
                title: "Invalid Date",
                text: 'Response date must be greater than the raised date',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            });
            input.value = '';

        }
    }
    $(document).ready(function() {

        const btn = document.getElementById("submit_update");
        const btn_modal = document.getElementById("submit_modal");

        $('.prevent_multiple_submit').on('submit', function() {

            $(".prevent_multiple_submit").parent().append(
                '<div class="offset-md-4 msg"><span class="text-danger text-sm text-center">Please wait while your request is being processed. &nbsp&nbsp&nbsp<i class="fa fa-spinner fa-spin" style="font-size:24px;color:black"></i></span></div>'
            );

            btn.disabled = true;
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



    $(document).ready(function() {
        var i = 1;
        var j = 2;

        $('[id^="addCorres"]').on('click', function() {
            var button_id = $(this).attr("id").match(/\d+/)[0];
            var add_id = $(this).attr("id").match(/\d+/)[0];
            var ser = $(this).attr("row_serial").match(/\d+/)[0];
            i++;
            $('#morecon' + add_id).append('<div class="row" id="row' + button_id + i +
                '"><div class="col-4"><label >' + i +
                '. Date Of Raising First Query by PMA</label><input type="date" class="form-control dateCompare" id="raise' +
                i + '" name="corres[' + i +
                '][raise_date]"></div><div class="col-4"><label >Date of Reply by the Beneficiary</label><input type="date" id="respo' +
                i + '" class="form-control dateCompare" onchange="checkResDate(this,' + i +
                ')" name="corres[' + i +
                '][response_date]"></div><div class="col-4"><label >Document</label><input type="file" class="form-control" name="corres[' +
                i +
                '][image]"></div><div class="col-12"><label>Message</label><textarea id="" class="summernote form-control" placeholder="Message" name="corres[' +
                i +
                '][message]"></textarea></div><div class="offset-10 col-2"><button class="btn btn-danger btn_remove" type="button" id="' +
                button_id + i + '">Remove</button></div></div>');
            $('.summernote').summernote();
        });

        // });
        $(document).on('click', '.btn_remove', function() {
            var r_id = $(this).attr("id");
            $('#row' + r_id + '').remove();
        });

        // TwentyPer Code

        // End Twenty Per Code



        $("#filterData").click(function(event) {
            var fyId = $('#fy_name').val();
            var link = '/admin/claims/incentive/' + fyId;
            window.location.href = link;
        });

        var t = $('#apps').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [0, 'asc']
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
        });

        t.on('order.dt search.dt', function() {
            t.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    function DateDiff(e, count) {
        var ids = $(e).attr('id');
        var val = new Date($('#' + ids).val());
        var filDate = new Date($('#filingDate' + count).val());
        var reportDate = new Date($('#reportInfo' + count).val());
        var reportData = Math.round((val - filDate) / (1000 * 60 * 60 * 24));
        var reportMeitytoPMA = Math.round((val - reportDate) / (1000 * 60 * 60 * 24));
        $('#noOfDaysSubReport' + count).val(reportData);
        $('#noOfDaysCompData' + count).val(reportMeitytoPMA);

        checkDate(e, count);
    }

    function DateDiffDis(e, count) {
        var ids = $(e).attr('id');
        var val = new Date($('#' + ids).val());
        var filDate = new Date($('#filingDate' + count).val());

        var reportMeitytoPMA = Math.round((val - filDate) / (1000 * 60 * 60 * 24));
        // console.log(val,reportMeitytoPMA);
        $('#total_duration_disbursal' + count).val(reportMeitytoPMA);
        checkDdcp(e, count);
    }

    function Status(count) {
        $("#status" + count).click(function(e) {
            var val = $(this).val();
            if (val == 'A') {
                // $("#remarks"+count).prop('readonly', false);
                $("#amount" + count).prop('readonly', false);
                $("#date" + count).prop('readonly', false);
            } else if (val == 'UP' || val == 'R') {
                // $("#remarks"+count).prop('readonly', true);
                $("#amount" + count).prop('readonly', true);
                $("#date" + count).prop('readonly', true);
                // $("#remarks"+count).val('');
                $("#amount" + count).val('');
                $("#date" + count).val('');
            }
        });
    }

    function validateDates(index) {
        var filingDate = document.getElementById('filingDate' + index).value;
        var reportInfoDate = document.getElementById('reportInfo' + index).value;

        if (new Date(reportInfoDate) < new Date(filingDate)) {
            swal({
                title: "Invalid Date",
                text: 'Please Select Valid Date',
                icon: "warning",
                buttons: {
                    cancel: 'Close'
                },
            })


            $('#reportInfo' + index).css('border-color', "#ff0000");

            return false;
        }
        return true;
    }

    function resetBorders() {
        var claimCount = <?php echo count($claimData); ?>;
        for (var i = 0; i < claimCount; i++) {

            $('#reportInfo' + i).css('border-color', "#000000");
        }
    }

    function validateForm() {
        resetBorders();

        var claimCount = <?php echo count($claimData); ?>;
        for (var i = 0; i < claimCount; i++) {
            if (!validateDates(i)) {
                return false;
            }
        }
        return true;
    }


    $(function() {
        $('.summernote').summernote()


    });
</script>

{{--  --}}
<script>
    function printPage() {
        var div1 = document.getElementById('appTabContent');
        var newWin = window.open('', 'Print-Window');

        newWin.document.open();
        newWin.document.write('<html><head><title></title>');
            newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
            newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">');
            newWin.document.write(
                '<style>@media print { .pagebreak { clear: both; page-break-before: always; }}</style>');
            newWin.document.write('</head><body onload="window.print()">');
        // newWin.document.write('<h2 class="text-center">Claim Preview Generated On '+time+'</h2>');
        newWin.document.write(div1.innerHTML);
        newWin.document.close();
    };
</script>

