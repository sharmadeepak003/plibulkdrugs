<script>
    // $(document).ready(function () {

    //     $('#company_id').on('change', function () {
    //         var company_id = $(this).val();
    //         if (company_id) {
    //             $.ajax({
    //                 url: '/brochure_product/' + company_id,
    //                 type: "GET",
    //                 dataType: "json",
    //                 success: function (data) {
    //                     $('#product_id').empty();
    //                     $('#product_id').append(
    //                         '<option value="" selected disabled>Select</option><option value="0">All</option>');
    //                     $.each(data, function (key) {
    //                         $('#product_id').append(
    //                             '<option value="' + data[key].p_id + '">' + data[key].product_name +
    //                             '</option>');
    //                     });
    //                 }
    //             });
    //         } 
    //         else {
    //             $('#product_id').empty();
    //         }
    //     });
    // });

    $(document).ready(function () {
        $('#product_id').on('change', function () {
            var product_id = $(this).val();
            if (product_id) {
                $.ajax({
                    url: '/brochure_company/' + product_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#company_id').empty();
                        $('#company_id').append(
                            '<option value=""selected disabled>Select</option>');
                        $.each(data, function (key) {
                            $('#company_id').append(
                                '<option value="' + data[key].id + '">' + data[key].name +
                                '</option>');
                        });
                    }
                });
            } 
            else {
                $('#company_id').empty();
            }
        });
    });
</script>
