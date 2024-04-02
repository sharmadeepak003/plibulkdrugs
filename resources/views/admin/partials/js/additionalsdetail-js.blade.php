<script>
      $(document).on("change", ".exp", function() {
        var sum = 0;
        $(".exp").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy20").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp1", function() {
        var sum = 0;
        $(".exp1").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy21").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp2", function() {
        var sum = 0;
        $(".exp2").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy22").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp3", function() {
        var sum = 0;
        $(".exp3").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy23").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp4", function() {
        var sum = 0;
        $(".exp4").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy24").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp5", function() {
        var sum = 0;
        $(".exp5").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy25").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp6", function() {
        var sum = 0;
        $(".exp6").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy26").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp7", function() {
        var sum = 0;
        $(".exp7").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy27").val(sum.toFixed(2));
    });

    $(document).on("change", ".exp8", function() {
        var sum = 0;
        $(".exp8").each(function() {
            sum += +$(this).val();
        });
        $("#totalfy28").val(sum.toFixed(2));
    });

    $(document).on("change", ".domestic", function() {
        var sum = 0;
        $(".domestic").each(function() {
            sum += +$(this).val();
        });
        $("#totaldom").val(sum.toFixed(2));
    });

    $(document).on("change", ".export", function() {
        var sum = 0;
        $(".export").each(function() {
            sum += +$(this).val();
        });
        $("#totalexp").val(sum.toFixed(2));
    });


    $(document).on("change", ".investparticular", function() {
        var sum = 0;
        $(".investparticular").each(function() {
            sum += +$(this).val();
        });
        $("#total").val(sum.toFixed(2));
    });

</script>
