<script>
    $(document).on("keyup", ".proposedInvest", function() {
        var psum = 0;
        $(".proposedInvest").each(function(){
            psum += +$(this).val();
        });
        console.log(psum);
        $(".tproposedInvest").val(psum.toFixed(2));
    });
    $(document).on("keyup", ".previousExp", function() {
        var pesum = 0;
        $(".previousExp").each(function(){
            pesum += +$(this).val();
        });
        console.log(pesum);
        $(".tpreviousExp").val(pesum.toFixed(2));
    });
    $(document).on("keyup", ".currentExp", function() {
        var sum = 0;
        $(".currentExp").each(function(){
            sum += +$(this).val();
        });
        console.log(sum);
        $(".tcurrentExp").val(sum.toFixed(2));
    });
    </script>