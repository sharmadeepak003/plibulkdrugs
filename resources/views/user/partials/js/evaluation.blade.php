<script>
    $('#investment').change(function (e) {
        var inv = parseFloat($(this).val());
        var worth = parseFloat({!! json_encode($appMast->eligibility->networth, JSON_HEX_TAG) !!});
        var per = 0;
       // var  per = parseFloat((worth/inv) * 100);
        //var cutoff = parseFloat(30);
	
       var calcu = (30*inv)/100;
	   //alert(calcu);
	   if(calcu<worth)
	   {
		   swal('Net Worth mentioned at 2.1 should have at least 30% of the investment');
	   }

    });

    $('#capacity').change(function (e) {
        var cap = parseFloat($(this).val());
        var minCap = parseFloat({!! json_encode($min_cap, JSON_HEX_TAG) !!});
        var rem = 0;
        rem = parseFloat(cap % minCap);
        console.log(minCap);
        console.log(rem);
        if(rem != 0)
        {
            swal({
                    title: "Error!",
                    text: "Capacity should be in multiples of Minimum Capacity as per Annexure B",
                    icon: "error",
                });
                $('#capacity').val('');
        }
    });



	$(document).ready(function () {
        $("#finalSubmit").click(function (event) {
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                    title: "No Change is allowed in Committed Capacity, Quoted Price and Committed Investment. Are you sure to submit the form?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                })
                .then((value) => {
                    if (value) {
                        window.location.href = link;
                    }
                });
        });
    });

    $(document).on("change", ".majorheads", function() {
    var sum = 0;
	
	//alert(inv); return false;
	
    $(".majorheads").each(function(){
        sum += +$(this).val();
    });
	
    $("#totalmajorheads").val(sum.toFixed(2));


});

$(".btn-primary").click(function(){
    var inv = $("#investment").val();
    var pro_total =  $("#totalmajorheads").val();
    //alert(inv.toFixed(2));
    if(inv!=pro_total)
    {
        swal('6.2 Proposed Investment and total of 6.3 Major heads of Proposed Investment should be same');
    }
});


</script>
