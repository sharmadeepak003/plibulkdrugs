<script>
    $(document).ready(function () {
        var ma_21_proCnt = $('input[name^="madd"]').length/2 ;
        console.log(ma_21_proCnt,"*****");
        $('#addmanuaddr_21_pro').click(function () {
            $("#manuaddr_21_pro_table").append(
                '<tr>' +
                '<td><input type="text" placeholder="Product Name" name="madd['+ma_21_proCnt+'][product]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" placeholder="Capacity" name="madd['+ma_21_proCnt+'][capacity]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-21_pro">Remove</button></td>'
            );
            ma_21_proCnt++;

            $(document).on('click', '.remove-21_pro', function () {
                $(this).parents('tr').remove();
            });
        });
    });
    </script>