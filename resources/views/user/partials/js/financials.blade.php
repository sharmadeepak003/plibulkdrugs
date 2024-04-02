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


        $('#rnd_unit').on('change', function () {
            if (this.value == 'Y') {
                $("#rnd_rcnz").prop("disabled", false);
            } else {
                $("#rnd_rcnz").prop("disabled", true);
            }
        });


    });



    $(document).on("change", function() {
        var eq_prom_17 = jQuery('#eq_prom_17').val();  
        var eq_frn_17 = jQuery('#eq_frn_17').val();
        var eq_ind_17 = jQuery('#eq_ind_17').val(); 
        var eq_mult_17 = jQuery('#eq_mult_17').val(); 
        var eq_bank_17 = jQuery('#eq_bank_17').val(); 
        var sum = parseFloat(eq_prom_17)+parseFloat(eq_ind_17)+parseFloat(eq_mult_17)+parseFloat(eq_bank_17)+parseFloat(eq_frn_17);
        jQuery('#sh_cap_17').val(sum.toFixed(2));
        var int_acc_17 = jQuery('#int_acc_17').val();
        var ln_prom_17 = jQuery('#ln_prom_17').val();
        var ln_ind_17 = jQuery('#ln_ind_17').val();   
        var ln_frn_17 = jQuery('#ln_frn_17').val(); 
        var ln_bank_17 = jQuery('#ln_bank_17').val();
        var ln_mult_17 = jQuery('#ln_mult_17').val();
        var gr_ind_17 = jQuery('#gr_ind_17').val();
        var gr_frn_17 = jQuery('#gr_frn_17').val(); 
        var sumsof = parseFloat(sum.toFixed(2))+parseFloat(int_acc_17)+parseFloat(ln_prom_17)+parseFloat(ln_bank_17)+parseFloat(ln_mult_17)+parseFloat(ln_ind_17)+parseFloat(gr_ind_17)+parseFloat(gr_frn_17)+parseFloat(ln_frn_17);
        jQuery('#sof_17').val(sumsof.toFixed(2));
    });

    $(document).on("change", function() {
        var eq_prom_18 = jQuery('#eq_prom_18').val();  
        var eq_frn_18 = jQuery('#eq_frn_18').val();
        var eq_ind_18 = jQuery('#eq_ind_18').val(); 
        var eq_mult_18 = jQuery('#eq_mult_18').val(); 
        var eq_bank_18 = jQuery('#eq_bank_18').val(); 
        var sum = parseFloat(eq_prom_18)+parseFloat(eq_ind_18)+parseFloat(eq_mult_18)+parseFloat(eq_bank_18)+parseFloat(eq_frn_18);
        jQuery('#sh_cap_18').val(sum.toFixed(2));
        var int_acc_18 = jQuery('#int_acc_18').val();
        var ln_prom_18 = jQuery('#ln_prom_18').val();
        var ln_ind_18 = jQuery('#ln_ind_18').val();   
        var ln_frn_18 = jQuery('#ln_frn_18').val(); 
        var ln_bank_18 = jQuery('#ln_bank_18').val();
        var ln_mult_18 = jQuery('#ln_mult_18').val();
        var gr_ind_18 = jQuery('#gr_ind_18').val();
        var gr_frn_18 = jQuery('#gr_frn_18').val(); 
        var sumsof = parseFloat(sum.toFixed(2))+parseFloat(int_acc_18)+parseFloat(ln_prom_18)+parseFloat(ln_bank_18)+parseFloat(ln_mult_18)+parseFloat(ln_ind_18)+parseFloat(gr_ind_18)+parseFloat(gr_frn_18)+parseFloat(ln_frn_18);
        jQuery('#sof_18').val(sumsof.toFixed(2));
    });

    $(document).on("change", function() {
        var eq_prom_19 = jQuery('#eq_prom_19').val();  
        var eq_frn_19 = jQuery('#eq_frn_19').val();
        var eq_ind_19 = jQuery('#eq_ind_19').val(); 
        var eq_mult_19 = jQuery('#eq_mult_19').val(); 
        var eq_bank_19 = jQuery('#eq_bank_19').val(); 
        var sum = parseFloat(eq_prom_19)+parseFloat(eq_ind_19)+parseFloat(eq_mult_19)+parseFloat(eq_bank_19)+parseFloat(eq_frn_19);
        jQuery('#sh_cap_19').val(sum.toFixed(2));
        var int_acc_19 = jQuery('#int_acc_19').val();
        var ln_prom_19 = jQuery('#ln_prom_19').val();
        var ln_ind_19 = jQuery('#ln_ind_19').val();   
        var ln_frn_19 = jQuery('#ln_frn_19').val(); 
        var ln_bank_19 = jQuery('#ln_bank_19').val();
        var ln_mult_19 = jQuery('#ln_mult_19').val();
        var gr_ind_19 = jQuery('#gr_ind_19').val();
        var gr_frn_19 = jQuery('#gr_frn_19').val(); 
        var sumsof = parseFloat(sum.toFixed(2))+parseFloat(int_acc_19)+parseFloat(ln_prom_19)+parseFloat(ln_bank_19)+parseFloat(ln_mult_19)+parseFloat(ln_ind_19)+parseFloat(gr_ind_19)+parseFloat(gr_frn_19)+parseFloat(ln_frn_19);
        jQuery('#sof_19').val(sumsof.toFixed(2));
    });


</script>
