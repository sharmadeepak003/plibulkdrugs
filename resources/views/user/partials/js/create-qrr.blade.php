<script>
     $(document).ready(function () {
         
         $('#proCap').on('change', function () {
            if (this.value == 'yes') {
                
                $("#dateCO").prop("disabled", false);
                $("#expected_dt").prop("disabled", true);
            } else {
                $("#expected_dt").prop("disabled", false);
                $("#dateCO").prop("disabled", true);
            }

        });

        

        $(document).on("keyup", ".amount", function() {
            var sum = 0;
            $(".amount").each(function(){
                sum += +$(this).val();
            });
            console.log(sum);
            $(".tamount").val(sum.toFixed(2));
        });
    });
    </script>