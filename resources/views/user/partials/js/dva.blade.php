<script>
    $(document).ready(function () {

        var krmCnt = $('input[name^="krm"]').length / 4;
        $('#addKRA').click(function () {
            $("#kraTable").append(
                '<tr>' +
                    '<td><input type="text" name="krm[' + krmCnt + '][name]" class="form-control form-control-sm"></td>' +
                    '<td><select class="form-control form-control-sm" name="krm[' + krmCnt + '][coo]"><option value="" selected="selected">Please choose..</option><option value="India">India</option><option value="Outside India">Outside India</option></select></td>' +
                    '<td><input type="text" name="krm[' + krmCnt + '][man]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="krm[' + krmCnt + '][amt]" class="form-control form-control-sm"></td>' +
                    '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-krm">Remove</button></td>'
            );
            krmCnt++;

            $(document).on('click', '.remove-krm', function () {
                $(this).parents('tr').remove();
            });
        });


    });

    $(document).on("change", function() {
    var b = parseFloat(jQuery('#total_b').val());
    var a = parseFloat(jQuery('#total_a').val());
	
	var pro_dva = $('#prop_dva').val();
	//console.log(b,a,pro_dva);
	//alert(pro_dva); return false;
    

    if(b >= a)
    {
    var total = (b-a)/b*100;
	//alert(total.toFixed(2));
	if(total.toFixed(2) != pro_dva)
	{
		swal('Section 2.2 Proposed Domestic Value Addition % and Section 8.1 Domestic Value Addition % should be same');
		jQuery('#total_a').val('');
		jQuery('#total_b').val('');
		return false;
	}
    jQuery('#dvatotal').val(total.toFixed(2));}
    else if(a>b)
    {swal('Please insert correct inputs');
    jQuery('#dvatotal').val('');}
    else
    {jQuery('#dvatotal').val('');}
});

</script>
