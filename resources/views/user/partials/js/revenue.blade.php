<script>
    $(document).ready(function() {
        var matprev = $('input[name^="mattprev"]').length / 4;
        $('#addPrevMat').click(function() {
            $("#tablePrevMat").append(
                '<tr>' +
                '<td><input type="text"  name="mattprev[' + matprev +
                '][particulars]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="mattprev[' + matprev +
                '][country]" class="form-control form-control-sm"></td>' +
                '<td><input type="text"  name="mattprev[' + matprev +
                '][quantity]" class="form-control form-control-sm mattprevQnty" ></td>' +
                '<td><input type="text" name="mattprev[' + matprev +
                '][amount]" class="form-control form-control-sm mattprevAmount"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-mat_prev">Remove</button></td></tr>'
            );
            matprev++;

            $(document).on('click', '.remove-mat_prev', function() {

                $(this).closest('tr').remove();

                var sum = 0;
                $('.mattprevAmount').each(function() {
                    sum += +$(this).val();
                });

                $(".mattprevtot").val(sum.toFixed(2));
            });


        });
        // });
        // $(document).ready(function () {
        var serprev = $('input[name^="serrprev"]').length / 4;
        $('#addPrevSer').click(function() {
            $("#tablePrevSer").append(
                '<tr>' +
                '<td><input type="text"  name="serrprev[' + serprev +
                '][particulars]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="serrprev[' + serprev +
                '][country]" class="form-control form-control-sm"></td>' +
                '<td><input type="text"  name="serrprev[' + serprev +
                '][quantity]" class="form-control form-control-sm serprevQnty"></td>' +
                '<td><input type="text" name="serrprev[' + serprev +
                '][amount]" class="form-control form-control-sm serrprevAmount"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-ser_prev">Remove</button></td>'
            );
            serprev++;

            $(document).on('click', '.remove-ser_prev', function() {
                $(this).closest('tr').remove();
                var sum = 0;
                $('.serrprevAmount').each(function() {
                    sum += +$(this).val();
                });

                $(".serrprevtot").val(sum.toFixed(2));

            });
        });

        var matcurr = $('input[name^="mattcurr"]').length / 4;
        $('#addcurrMat').click(function() {
            $("#tableCurrMat").append(
                '<tr>' +
                '<td><input type="text"  name="mattcurr[' + matcurr +
                '][particulars]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="mattcurr[' + matcurr +
                '][country]" class="form-control form-control-sm"></td>' +
                '<td><input type="text"  name="mattcurr[' + matcurr +
                '][quantity]" class="form-control form-control-sm mattrcurrQnty"></td>' +
                '<td><input type="text" name="mattcurr[' + matcurr +
                '][amount]" class="form-control form-control-sm mattcurrAmount"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-mat_curr">Remove</button></td>'
            );
            matcurr++;

            $(document).on('click', '.remove-mat_curr', function() {
                $(this).closest('tr').remove();
                var sum = 0;
                $('.mattcurrAmount').each(function() {
                    sum += +$(this).val();
                });

                $(".mattcurrtot").val(sum.toFixed(2));


            });
        });

        var sercurr = $('input[name^="serrcurr"]').length / 4;
        $('#addcurrSer').click(function() {
            $("#tableCurrSer").append(
                '<tr>' +
                '<td><input type="text"  name="serrcurr[' + sercurr +
                '][particulars]" class="form-control form-control-sm"></td>' +
                '<td><input type="text" name="serrcurr[' + sercurr +
                '][country]" class="form-control form-control-sm"></td>' +
                '<td><input type="text"  name="serrcurr[' + sercurr +
                '][quantity]" class="form-control form-control-sm sercurrQnty"></td>' +
                '<td><input type="text" name="serrcurr[' + sercurr +
                '][amount]" class="form-control form-control-sm serrcurrAmount"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-ser_curr">Remove</button></td>'
            );
            sercurr++;

            $(document).on('click', '.remove-ser_curr', function() {
                $(this).closest('tr').remove();
                var sum = 0;
                $('.serrcurrAmount').each(function() {
                    sum += +$(this).val();
                });

                $(".serrcurrtot").val(sum.toFixed(2));

            });
        });

        // dva breakdown
        $(document).on("keyup", ".mattprevAmount", function() {
            var sum = 0;
            $(".mattprevAmount").each(function() {
                sum += +$(this).val();
            });
            sum = sum.toFixed(2);
            var match = document.getElementById('matprevamount').value;
            match = parseFloat(match);
            console.log(match, sum, match == sum);
            $("#matprevamount").val(sum);
            $(".mattprevtot").val(sum);
            var data = 0;
            $(".materialprevamount").each(function() {
                data += +$(this).val();
            });
            $("#totConprevamount").val(data.toFixed(2));

            var EPprevamount = document.getElementById("EPprevamount").value;
            var val1 = document.getElementById("matprevamount").value;
            var val2 = document.getElementById("serprevamount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            var dva;
            if (sum) {
                dva = ((EPprevamount - sum) / EPprevamount) * 100;
            } else {
                dva = 0;
            }

            $("#prevDVATotal").val(dva.toFixed(2));
            
        });
        $(document).on("keyup", ".serrprevAmount", function() {
            var sum = 0;
            $(".serrprevAmount").each(function() {
                sum += +$(this).val();
            });
            sum = sum.toFixed(2);
            var match = document.getElementById('serprevamount').value;
            match = parseFloat(match);
            console.log(match, sum, match == sum);
            $("#serprevamount").val(sum);
            $(".serrprevtot").val(sum);
            var data = 0;
            $(".materialprevamount").each(function() {
                data += +$(this).val();
            });
            $("#totConprevamount").val(data.toFixed(2));
            var greenTotal = document.getElementById("gcTotPrevSales").value;
            
            if (greenTotal != 0) {
                var dva = ((greenTotal - sum) / greenTotal) * 100;
                dva = dva.toFixed(2);
                document.getElementById("prevDVATotal").value = dva;
            } else {
                document.getElementById("prevDVATotal").value = 0;
            }
            if (dva < 0) {
                document.getElementById("prevDVATotal").value = 0;
            }

            var EPprevamount = document.getElementById("EPprevamount").value;
            var val1 = document.getElementById("matprevamount").value;
            var val2 = document.getElementById("serprevamount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            var dva;
            if (sum) {
                dva = ((EPprevamount - sum) / EPprevamount) * 100;
            } else {
                dva = 0;
            }

            $("#prevDVATotal").val(dva.toFixed(2));
           
        });
        $(document).on("keyup", ".mattcurrAmount", function() {
            var sum = 0;
            $(".mattcurrAmount").each(function() {
                sum += +$(this).val();
            });
            sum = sum.toFixed(2);
            var match = document.getElementById('matcurramount').value;
            match = parseFloat(match);
            console.log(match, sum, match == sum);
            $("#matcurramount").val(sum);
            $(".mattcurrtot").val(sum);
            var data = 0;
            $(".materialcurramount").each(function() {
                data += +$(this).val();
            });
            $("#totConcurramount").val(data.toFixed(2));

            var EPcurramount = document.getElementById("EPcurramount").value;
            var val1 = document.getElementById("matcurramount").value;
            var val2 = document.getElementById("sercurramount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            var dva;
            if (sum) {
                dva = ((EPcurramount - sum) / EPcurramount) * 100;
            } else {
                dva = 0;
            }

            $("#currDVATotal").val(dva.toFixed(2));

            // if(match==sum){
            // $(".mattcurrtot").val(sum);
            // }else{
            // swal('Breakup of non-originating RM amount must match non-originating RM.');
            // $(".mattcurrtot").val('');}
        });
        $(document).on("keyup", ".serrcurrAmount", function() {
            var sum = 0;
            $(".serrcurrAmount").each(function() {
                sum += +$(this).val();
            });
            sum = sum.toFixed(2);
            var match = document.getElementById('sercurramount').value;
            match = parseFloat(match);
            console.log(match, sum, match == sum);
            $("#sercurramount").val(sum);
            $(".serrcurrtot").val(sum);
            var data = 0;
            $(".materialcurramount").each(function() {
                data += +$(this).val();
            });
            $("#totConcurramount").val(data.toFixed(2));
            var greenTotal = document.getElementById("gcTotCurrSales").value;
            // if(greenTotal=="" || greenTotal==0){
            //     window.alert("GreenField Sales Must not be 0 or empty.");
            // }else if(greenTotal<sum){
            //     window.alert("GreenField Sales Must be greater than Material sales.");
            // }
            if (greenTotal != 0) {
                var dva = ((greenTotal - sum) / greenTotal) * 100;
                dva = dva.toFixed(2);
                document.getElementById("currDVATotal").value = dva;

            } else {
                document.getElementById("currDVATotal").value = 0;
            }
            if (dva < 0) {
                document.getElementById("currDVATotal").value = 0;
            }

            var EPcurramount = document.getElementById("EPcurramount").value;
            var val1 = document.getElementById("matcurramount").value;
            var val2 = document.getElementById("sercurramount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            var dva;
            if (sum) {
                dva = ((EPcurramount - sum) / EPcurramount) * 100;
            } else {
                dva = 0;
            }

            $("#currDVATotal").val(dva.toFixed(2));
            // if(match==sum){
            // $(".serrcurrtot").val(sum);
            // }else{
            // swal('Breakup of non-originating RM amount must match non-originating RM.');
            // $(".serrcurrtot").val('');}

        });
        //by shakiv Ali

        //     $(document).on("keyup", ".greencurrquant", function() {

        //         alert($('#gcTotCurrQuantity').val());
        //         var totQnty = $('#gcTotCurrQuantity').val();

        //         $("#EPcurrquant").val(totQnty);
        //     });

        //     $(document).on("keyup", ".greencurrsales", function() {

        //        var totAmt = $('#gcTotCurrSales').val();

        //        $("#EPcurramount").val(totAmt);
        //    });


        $(document).on("keyup", ".mattprevQnty", function() {
            var sum = 0;
            $(".mattprevQnty").each(function() {
                sum += +$(this).val();
            });

            $("#matprevquant").val(sum.toFixed(2));
            var data = 0;
            $(".materialprevquant").each(function() {
                data += +$(this).val();
            });

            $(".totalConprevquant").val(data.toFixed(2));
        });

        $(document).on("keyup", ".mattrcurrQnty", function() {
            var sum = 0;
            $(".mattrcurrQnty").each(function() {
                sum += +$(this).val();
            });

            $("#matcurrquant").val(sum.toFixed(2));
            var data = 0;
            $(".materialcurrquant").each(function() {
                data += +$(this).val();
            });

            $(".totalConcurrquant").val(data.toFixed(2));
        });

        $(document).on("keyup", ".serprevQnty", function() {
            var sum = 0;
            $(".serprevQnty").each(function() {
                sum += +$(this).val();
            });

            $("#serprevquant").val(sum.toFixed(2));

            var data = 0;
            $(".materialprevquant").each(function() {
                data += +$(this).val();
            });

            $(".totalConprevquant").val(data.toFixed(2));
        });

        $(document).on("keyup", ".sercurrQnty", function() {
            var sum = 0;
            $(".sercurrQnty").each(function() {
                sum += +$(this).val();
            });

            $("#sercurrquant").val(sum.toFixed(2));

            var data = 0;
            $(".materialcurrquant").each(function() {
                data += +$(this).val();
            });

            $(".totalConcurrquant").val(data.toFixed(2));
        });


        //green field sum
        $(document).on("keyup", ".greenprevquant", function() {
            var sum = 0;
            $(".greenprevquant").each(function() {
                sum += +$(this).val();
            });

            $(".greenprevtotquant").val(sum.toFixed(2));
            // $('#EPprevquant').val(sum.toFixed(2));
        });

        $(document).on("keyup", ".greenprevsales", function() {
            var sum = 0;
            $(".greenprevsales").each(function() {
                sum += +$(this).val();
            });
            $(".greenprevtotsales").val(sum.toFixed(2));
            // $('#EPprevamount').val(sum.toFixed(2));
        });
        $(document).on("keyup", ".greencurrquant", function() {
            var sum = 0;
            $(".greencurrquant").each(function() {
                sum += +$(this).val();
            });

            $(".greencurrtotquant").val(sum.toFixed(2));
            $("#EPcurrquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".greencurrsales", function() {
            var sum = 0;
            $(".greencurrsales").each(function() {
                sum += +$(this).val();
            });

            $(".greencurrtotsales").val(sum.toFixed(2));
            $("#EPcurramount").val(sum.toFixed(2));
        });


        //Existing Capacity sum
        $(document).on("keyup", ".existprevquant", function() {
            var sum = 0;
            $(".existprevquant").each(function() {
                sum += +$(this).val();
            });

            $(".existprevtotquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".existprevsales", function() {
            var sum = 0;
            $(".existprevsales").each(function() {
                sum += +$(this).val();
            });

            $(".existprevtotsales").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".existcurrquant", function() {
            var sum = 0;
            $(".existcurrquant").each(function() {
                sum += +$(this).val();
            });

            $(".existcurrtotquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".existcurrsales", function() {
            var sum = 0;
            $(".existcurrsales").each(function() {
                sum += +$(this).val();
            });

            $(".existcurrtotsales").val(sum.toFixed(2));
        });

        //other Capacity sum
        $(document).on("keyup", ".otherprevquant", function() {
            var sum = 0;
            $(".otherprevquant").each(function() {
                sum += +$(this).val();
            });

            $(".otherprevtotquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".otherprevsales", function() {
            var sum = 0;
            $(".otherprevsales").each(function() {
                sum += +$(this).val();
            });

            $(".otherprevtotsales").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".othercurrquant", function() {
            var sum = 0;
            $(".othercurrquant").each(function() {
                sum += +$(this).val();
            });

            $(".othercurrtotquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".othercurrsales", function() {
            var sum = 0;
            $(".othercurrsales").each(function() {
                sum += +$(this).val();
            });

            $(".othercurrtotsales").val(sum.toFixed(2));
        });

        //Grand Total sum
        $(document).on("keyup", ".grandPrevTotalQuant", function() {
            var sum = 0;
            $(".grandPrevTotalQuant").each(function() {
                sum += +$(this).val();
            });

            $(".totalprevquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".grandPrevTotalSales", function() {
            var sum = 0;
            $(".grandPrevTotalSales").each(function() {
                sum += +$(this).val();
            });

            $(".totalprevsales").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".grandCurrTotalQuant", function() {
            var sum = 0;
            $(".grandCurrTotalQuant").each(function() {
                sum += +$(this).val();
            });

            $(".totalcurrquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".grandCurrTotalSales", function() {
            var sum = 0;
            $(".grandCurrTotalSales").each(function() {
                sum += +$(this).val();
            });

            $(".totalcurrsales").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".prevNo", function() {
            var sum = 0;
            $(".prevNo").each(function() {
                sum += +$(this).val();
            });

            $(".totalprevNo").val(sum);
        });

        $(document).on("keyup", ".currNo", function() {
            var sum = 0;
            $(".currNo").each(function() {
                sum += +$(this).val();
            });

            $(".totalcurrNo").val(sum);
        });

        $(document).on("keyup", ".prevNo", function() {
            var sum = 0;
            $(".prevNo").each(function() {
                sum += +$(this).val();
            });

            $(".totalprevNo").val(sum);
        });

        $(document).on("keyup", ".currNo", function() {
            var sum = 0;
            $(".currNo").each(function() {
                sum += +$(this).val();
            });

            $(".totalcurrNo").val(sum);
        });



        //DVA

        $(document).on("keyup", ".materialprevquant", function() {
            var sum = 0;
            $(".materialprevquant").each(function() {
                sum += +$(this).val();
            });

            $(".totalConprevquant").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".materialprevsales", function() {
            var sum = 0;
            $(".materialprevsales").each(function() {
                sum += +$(this).val();
            });

            // var greenTotal=document.getElementById("gcTotPrevSales").value;
            // if(greenTotal=="" || greenTotal==0){
            //     window.alert("GreenField Sales Must not be 0 or empty.");
            // }else if(greenTotal<sum){
            //     window.alert("GreenField Sales Must be greater than Material sales.");
            // }
            // var dva=(greenTotal-sum)/greenTotal;
            // dva=dva.toFixed(2);
            // document.getElementById("prevDVATotal").value=dva;
            console.log(sum, '***', greenTotal, dva);
            $(".totalConprevsales").val(sum.toFixed(2));
        });

        $(document).on("keyup", ".materialprevamount", function() {
            var sum = 0;
            $(".materialprevamount").each(function() {
                sum += +$(this).val();
            });
            var greenTotal = document.getElementById("gcTotPrevSales").value;
            // if(greenTotal=="" || greenTotal==0){
            //     window.alert("GreenField Sales Must not be 0 or empty.");
            // }else if(greenTotal<sum){
            //     window.alert("GreenField Sales Must be greater than Material sales.");
            // }
            if (greenTotal != 0) {
                var dva = ((greenTotal - sum) / greenTotal) * 100;
                dva = dva.toFixed(2);
                document.getElementById("prevDVATotal").value = dva;
            } else {
                document.getElementById("prevDVATotal").value = 0;
            }
            if (dva < 0) {
                document.getElementById("prevDVATotal").value = 0;
            }
            $(".totalConprevamount").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".materialcurrquant", function() {
            var sum = 0;
            $(".materialcurrquant").each(function() {
                sum += +$(this).val();
            });

            $(".totalConcurrquant").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".materialcurrsales", function() {
            var sum = 0;
            $(".materialcurrsales").each(function() {
                sum += +$(this).val();
            });
            // var greenTotal=document.getElementById("gcTotCurrSales").value;
            // if(greenTotal=="" || greenTotal==0){
            //     window.alert("GreenField Sales Must not be 0 or empty.");
            // }else if(greenTotal<sum){
            //     window.alert("GreenField Sales Must be greater than Material sales.");
            // }
            // var dva=(greenTotal-sum)/greenTotal;
            // dva=dva.toFixed(2);
            // document.getElementById("currDVATotal").value=dva;
            // console.log(sum,'***',greenTotal,dva);

            $(".totalConcurrsales").val(sum.toFixed(2));
        });
        $(document).on("keyup", ".materialcurramount", function() {
            var sum = 0;
            $(".materialcurramount").each(function() {
                sum += +$(this).val();
            });

            var greenTotal = document.getElementById("gcTotCurrSales").value;
            // if(greenTotal=="" || greenTotal==0){
            //     window.alert("GreenField Sales Must not be 0 or empty.");
            // }else if(greenTotal<sum){
            //     window.alert("GreenField Sales Must be greater than Material sales.");
            // }
            if (greenTotal != 0) {
                var dva = ((greenTotal - sum) / greenTotal) * 100;
                dva = dva.toFixed(2);
                document.getElementById("currDVATotal").value = dva;
                console.log(sum, '***', greenTotal, dva);
            } else {
                document.getElementById("currDVATotal").value = 0;
            }
            if (dva < 0) {
                document.getElementById("currDVATotal").value = 0;
            }
            $(".totalConcurramount").val(sum.toFixed(2));
        });

        //add by Ajaharuddin Ansari
        $(document).on("keyup", "#EPprevamount,#matprevamount,#serprevamount", function() {
            var EPcurramount = document.getElementById("EPprevamount").value;
            var val1 = document.getElementById("matprevamount").value;
            var val2 = document.getElementById("serprevamount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            var dva;
            if (sum) {
                dva = ((EPcurramount - sum) / EPcurramount) * 100;
            } else {
                dva = 0;
            }
            // console.log(val1 , val2, sum, dva);
            $("#prevDVATotal").val(dva.toFixed(2));
        });


        $(document).on("keyup", ".grandCurrTotalSales", function() {
            var sum = 0;
            $(".grandCurrTotalSales").each(function() {
                sum += +$(this).val();
            });

            $(".totalcurrsales").val(sum.toFixed(2));
        });

        $(document).on("keyup", "#EPcurramount,#matcurramount,#sercurramount", function() {
            var EPcurramount = document.getElementById("EPcurramount").value;
            var val1 = document.getElementById("matcurramount").value;
            var val2 = document.getElementById("sercurramount").value;
            var sum = parseFloat(val1) + parseFloat(val2);
            // console.log(val1,val2,sum)
            var dva;
            if (sum) {
                dva = ((EPcurramount - sum) / EPcurramount) * 100;
            } else {
                dva = 0;
            }

            $("#currDVATotal").val(dva.toFixed(2));
        });
    });

    function myfunction(form) {

        var EPprevamount = document.getElementById("EPprevamount").value;
        var gcTotPrevSales = document.getElementById("gcTotPrevSales").value;
        var EPcurramount = document.getElementById("EPcurramount").value;
        var gcTotCurrSales = document.getElementById("gcTotCurrSales").value;
        var data = " {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} ";
//         if (EPprevamount != gcTotPrevSales) {

// swal('Net Sales Turnover from Eligile Product Amount');
// document.getElementById("gcTotPrevSales").focus();
// return false;
// }else 
        if (EPcurramount != gcTotCurrSales) {
            swal('Net Sales Turnover from Eligile Product Amount');
            document.getElementById("gcTotCurrSales").focus();
            return false;
        }else
        {
            swal({
                title: "Are you sure?",
                text: "Sales revenue entered in the form is for the this quarter" +data+" ! Please Confrim.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(isOkay) {
                if (isOkay) {
                  form.submit();
                }
            });
            return false;
        }

    }
</script>
