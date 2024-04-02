<script>
    $(document).ready(function () {

        var groupCnt = $('input[name^="group"]').length / 5;
        $('#addGroup').click(function () {
            $("#groupTable").append(
                '<tr>' +
                    '<td><input type="text" name="group[' + groupCnt + '][name]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="group[' + groupCnt + '][location]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="group[' + groupCnt + '][regno]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="group[' + groupCnt + '][relation]" class="form-control form-control-sm"></td>' +
                    '<td><input type="number" name="group[' + groupCnt + '][networth]" class="form-control form-control-sm"></td>' +
                    '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-group">Remove</button></td>'
            );
            groupCnt++;

            $(document).on('click', '.remove-group', function () {
                $(this).parents('tr').remove();
            });
        });

        $('#greenfield').on('change', function () {
            if (this.value == 'Y') {
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").prop("disabled", true);
                swal({
                    title: "Attention",
                    text: "Not Eligible",
                    icon: "warning",
                });
            }
        });

        $('#bankrupt').on('change', function () {
            if (this.value == 'N') {
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").prop("disabled", true);
                swal({
                    title: "Attention",
                    text: "Not Eligible",
                    icon: "warning",
                });
            }
        });

        $('#payment').on('change', function () {
            if (this.value == 'Y') {
                $("#submit").prop("disabled", false);
            } else {
                $("#submit").prop("disabled", false);
                swal({
                    title: "Attention",
                    text: "Please make Fee payment and furnish details",
                    icon: "warning",
                });
            }
        });


    });

</script>
