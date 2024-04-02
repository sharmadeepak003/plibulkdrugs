<script>
$(document).ready(function () {


    const btn = document.getElementById("submitshareper");
        $('.prevent_multiple_submit').on('submit', function() {
            $( ".prevent_multiple_submit" ).parent().append('<div class="offset-md-4 msg"><span class="text-danger text-sm text-center">Please wait while your request is being processed. &nbsp&nbsp&nbsp<i class="fa fa-spinner fa-spin" style="font-size:24px;color:black"></i></span></div>');
          
            btn.disabled = true;
            setTimeout(function(){btn.disabled = false;}, (1000*50));
            setTimeout(function(){$( ".msg" ).hide()}, (1000*50));
            });

           
            $(document).on("change", "form :input,Select" , function() {
      
                btn.disabled = false;
                $( ".msg" ).hide()

            });

     });

</script>