<script>
    $(document).ready(function () {

        $('#name').blur(function (e) {
            var name = $(this).val();
            $("#cName").text(name);
        });

        $('#pan').blur(function (e) {
            var pan = $(this).val();
            if (pan.length == 10) {
                var cType = $("#type option:selected").val();
                if (cType === '') {
                    alert('Please select Business Constitution first');
                    $(this).val('');
                    $("#type").focus();
                } else {
                    var checkChar = pan.charAt(3);
                    if ((cType == "Partnership Firm" || cType ==
                            "Limited Liability Partnership") && checkChar != 'F') {
                        alert('Invalid PAN');
                        $(this).val('');
                    } else if (cType == "Company" && checkChar != 'C') {
                        alert('Invalid PAN');
                        $(this).val('');
                    }
                    else if (cType == "Proprietary Firm" && checkChar != 'P') {
                        alert('Invalid PAN');
                        $(this).val('');
                    }
                }
            }
        });

        $('#existing_manufacturer').on('change', function () {
            if (this.value == 'Y') {
                //$("#setup_project").prop("disabled", true);
                //$("#submit").prop("disabled", false);
                $("#business_desc").prop("disabled", false);
            } else {
                //$("#setup_project").prop("disabled", false);
                $("#business_desc").prop("disabled", true);
            }
        });

        $('#setup_project').on('change', function () {
            if (this.value == 'Y') {
                $("#submit").prop("disabled", false);
                $("#applicant_desc").prop("disabled", false);
            } else {
                $("#submit").prop("disabled", true);
                $("#applicant_desc").prop("disabled", true);
                swal({
                    title: "Attention!",
                    text: "Registration formality cannot be allowed as Scheme is open for applicants interested in setting up a Greenfield Project for eligible product, covered under the Scheme",
                    icon: "warning",
                });
            }
        });

        $("#eligible_product").multiselect({
            columns: 2,
            onControlClose: function () {
                var val = $('select[multiple]').val();
                if (val) {
                    $.ajax({
                        url: '/segments/' + val,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#tSeg').empty();
                            $('#tSeg').text(data);
                        }
                    });
                } else {
                    $('#tSeg').empty();
                }
            },
        });






    });

</script>
