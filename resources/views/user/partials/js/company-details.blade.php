<script>
    $(document).ready(function () {

        $('#corp_state').on('change', function () {
            var state = $(this).val();
            if (state) {
                $.ajax({
                    url: '/cities/' + state,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#corp_city').empty();
                        $('#corp_city').append(
                            '<option value="">Please Choose..</option>');
                        $.each(data, function (key, value) {
                            $('#corp_city').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            } else {
                $('#corp_city').empty();
            }
        });

        $('#corp_pin').keyup(function (e) {
            var pincode = $(this).val();
            if (pincode.length == 6 && $.isNumeric(pincode)) {
                var city = $('#corp_city').val();
                var req = '/pincodes/' + city;
                $.getJSON(req, null, function (data) {
                    if ($.inArray(pincode, data) != -1) {
                        console.log(pincode);
                    } else {
                        alert('Pincode Incorrect!');
                        $('#corp_pin').val('');
                    }
                });
            };
        });

        $('#listed').on('change', function () {
            if (this.value == 'Y') {
                $('#stock_exchange').prop("disabled", false);
            } else {
                $('#stock_exchange').prop("disabled", true);
            }
        });

        $('#doi').on("keyup change", function (e) {
            var dateString = $(this).val();
            var myDate = new Date(dateString);
            var today = new Date();
            if (myDate > today) {
                alert("Date can't be later than date of application");
                $('#doi').val('');
                return false;
            }
            return true;

        });


        var promCnt = $('input[name^="prom"]').length / 5;
        $('#addProm').click(function () {
            $("#promTable").append(
                '<tr>' +
                '<td><input type="text" name="prom[' + promCnt +
                '][name]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="prom[' + promCnt +
                '][shares]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="prom[' + promCnt +
                '][per]" class="form-control form-control-sm totalshares"></td>' +
                '<td><input type="text" name="prom[' + promCnt +
                '][capital]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-prom">Remove</button></td>'
            );
            promCnt++;

            $(document).on('click', '.remove-prom', function () {
                $(this).parents('tr').remove();
            });
        });

        var otherCnt = $('input[name^="other"]').length / 5;
        $('#addOther').click(function () {
            $("#otherTable").append(
                '<tr>' +
                '<td><input type="text" name="other[' + otherCnt +
                '][name]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="other[' + otherCnt +
                '][shares]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="other[' + otherCnt +
                '][per]" class="form-control form-control-sm othershareper"></td>' +
                '<td><input type="text" name="other[' + otherCnt +
                '][capital]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-other">Remove</button></td>'
            );
            otherCnt++;

            $(document).on('click', '.remove-other', function () {
                $(this).parents('tr').remove();
            });
        });

        var gstinCnt = $('input[name^="gstin"]').length / 3;
        $('#addGSTIN').click(function () {
            $("#gstinTable").append(
                '<tr>' +
                '<td><input type="text" name="gstin[' + gstinCnt +
                '][gstin]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="gstin[' + gstinCnt +
                '][add]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-gstin">Remove</button></td>'
            );
            gstinCnt++;

            $(document).on('click', '.remove-gstin', function () {
                $(this).parents('tr').remove();
            });
        });

        var auditorCnt = $('input[name^="aud"]').length / 4;
        $('#addAuditor').click(function () {
            $("#auditorTable").append(
                '<tr>' +
                '<td><input type="text" name="aud[' + auditorCnt +
                '][name]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="aud[' + auditorCnt +
                '][frn]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="aud[' + auditorCnt +
                '][fy]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-auditor">Remove</button></td>'
            );
            auditorCnt++;

            $(document).on('click', '.remove-auditor', function () {
                $(this).parents('tr').remove();
            });
        });

        var ratingCnt = $('input[name^="rat"]').length / 4;
        $('#addRating').click(function () {
            $("#ratingTable").append(
                '<tr>' +
                '<td><input type="text" name="rat[' + ratingCnt +
                '][rating]" class="form-control form-control-sm rating"></td>' +
                '<td><input type="text" name="rat[' + ratingCnt +
                '][name]" class="form-control form-control-sm ratingname"></td>' +
                '<td><input type="date" name="rat[' + ratingCnt +
                '][date]" class="form-control form-control-sm ratingdate"></td>' +
                '<td><input type="date" name="rat[' + ratingCnt +
                '][validity]" class="form-control form-control-sm ratingvalidity"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-rating">Remove</button></td>'
            );
            ratingCnt++;

            $(document).on('click', '.remove-rating', function () {
                $(this).parents('tr').remove();
            });
        });

        var topManCnt = $('input[name^="topMan"]').length / 6;
        $('#addManagement').click(function () {
            $("#topManTable").append(
                '<tr>' +
                '<td><input type="text" name="topMan[' + topManCnt +
                '][name]" class="form-control form-control-sm"></td>' +
                '<td><input type="email" name="topMan[' + topManCnt +
                '][email]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="topMan[' + topManCnt +
                '][phone]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="topMan[' + topManCnt +
                '][din]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="topMan[' + topManCnt +
                '][add]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-topman">Remove</button></td>'
            );
            topManCnt++;

            $(document).on('click', '.remove-topman', function () {
                $(this).parents('tr').remove();
            });
        });

        var kmpCnt = $('input[name^="kmp"]').length / 5;
        $('#addKMP').click(function () {
            $("#kmpTable").append(
                '<tr>' +
                '<td><input type="text" name="kmp[' + kmpCnt +
                '][name]" class="form-control form-control-sm"></td>' +
                '<td><input type="email" name="kmp[' + kmpCnt +
                '][email]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="kmp[' + kmpCnt +
                '][phone]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="kmp[' + kmpCnt +
                '][pan_din]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-kmp">Remove</button></td>'
            );
            kmpCnt++;

            $(document).on('click', '.remove-kmp', function () {
                $(this).parents('tr').remove();
            });
        });


    });


    if ($("#externalcreditrating").val() == "N") {
            $('#addRating').prop("disabled", true);
        }

    $('#externalcreditrating').on('change', function () {
        if (this.value == 'Y') {
            $('.rating').prop("disabled", false);
            $('.ratingname').prop("disabled", false);
            $('.ratingdate').prop("disabled", false);
            $('.ratingvalidity').prop("disabled", false);
            $('#addRating').prop("disabled", false);
        } else {
            $('.rating').prop("disabled", true);
            $('.ratingname').prop("disabled", true);
            $('.ratingdate').prop("disabled", true);
            $('.ratingvalidity').prop("disabled", true);
            $('#addRating').prop("disabled", true);

        }
    });

    // $("#submitshareper").click(function (event) {
        // var sum = 0;
        // var sumother = 0;
        // $('.totalshares').each(function () {
            // sum += parseFloat(this.value);
        // });
        // $('.othershareper').each(function () {
            // sumother += parseFloat(this.value);
        // });
        // console.log(sumother);
        // if (sum != '100') {
            // swal({
                // title: "Attention",
                // text: "Total of shareholding % should be 100%",
                // icon: "warning",
            // });
            // event.preventDefault();
        // } else if ((!isNaN(sumother)) && (sumother != '100')) {
            // swal({
                // title: "Attention",
                // text: "Total of Other than Promoter & Promoter Group shareholding % should be 100%",
                // icon: "warning",
            // });
            // event.preventDefault();
        // } else {
            // $("#comp-create").submit();
        // }

    // });

</script>
