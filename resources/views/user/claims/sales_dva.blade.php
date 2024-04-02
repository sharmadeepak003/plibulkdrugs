@extends('layouts.user.dashboard-master')

@section('title')
    DVA
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimsalesdetail.dva_store') }}" id="form-Dvasales" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <input type="hidden" name="claim_id" value="{{$claim_id}}">
                <div class="card border-primary">
                    <div class="card-header bg-gradient-info">
                        <strong>Domestic Value Addition(DVA)</strong>
                    </div>
                    <div class="card-body py-1 px-1">
                        <div class="row">
                            <div class="table-responsive rounded col-md-12">
                                <table class="table table-bordered table-hover table-sm" id="dynamic_field">
                                    <thead>
                                        <th>Key Raw Material & Services </th>
                                        <th>Country of Origin </th>
                                        <th>Name of the Suppliers </th>
                                        <th>Quantity (MT)
                                        </th>
                                        <th>Amount (₹)
                                        </th>
                                        <th>Amount against per kg of finished goods produced / goods sold</th>
                                        <th class="text-center" style="text-decoration:none"><button
                                            type="button" name="add" id="add"
                                            class="btn btn-success btn-sm">Add
                                            More</button>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <input type="hidden" name="count_row_raw_raterial" id="count_row_raw_raterial" value="0">
                                            <td><input type="text" name="dva_data[0][raw_material]" placeholder="Key Raw Material..1" class="form-control form-control-sm name_list1"></td>
                                            <td><select id="country_origin_0" name="dva_data[0][country_origin]"
                                                class="form-control form-control-sm text-center ind_otind" onchange="fun_country_origin(this.value,0)">
                                                <option disabled selected>Select</option>
                                                <option value="India">India</option>
                                                <option value="Outside India">Outside India</option>
                                            </select></td>
                                            <td><input type="text" name="dva_data[0][supplier_name]"
                                                    placeholder="Name and Address of Supplier"
                                                    class="form-control form-control-sm name_list1"></td>
                                            <td><input type="number" value="" name="dva_data[0][quantity]"  class="form-control form-control-sm name_list1 add_qnty"></td>
                                            <td><input type="number" name="dva_data[0][amount]" value=""
                                             id="amount_0" class="form-control form-control-sm name_list1 add_amount tot_amt " onkeyup="breakupsumadd(0,this.value)"></td>
                                            <td><input type="number" name="dva_data[0][goods_amt]" value="" id="tot_goods_amt_0" class="form-control form-control-sm name_list1 ot_tot_goods_amt add_raw_material_0" readonly></td>
                                        </tr>
                                    </tbody>
                                   
                                    {{-- <table class="table table-bordered table-hover table-sm"> --}}

                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Other Consumables
                                            <input type="hidden" name="other_dva_data[1][prt_id]" value="1" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[1][quantity]" class="form-control form-control-sm name_list1" value="">
                                            <td><input type="number" name="other_dva_data[1][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt" value="" id="consumables" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[1][goods_amt]" value="" id="add_consumables" class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Salary Expenses
                                            <input type="hidden" name="other_dva_data[2][prt_id]" value="2" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[2][quantity]" class="form-control form-control-sm name_list1" value="">
                                            <td><input type="number" name="other_dva_data[2][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt" value="" id="expenses" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[2][goods_amt]" value="" id="add_expenses" class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Other Expenses
                                            <input type="hidden" name="other_dva_data[3][prt_id]" value="3" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[3][quantity]" class="form-control form-control-sm name_list1" value="">
                                            <td><input type="number" name="other_dva_data[3][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt" value="" id="oth_expense" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[3][goods_amt]" value="" id="add_oth_expense" class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Services Obtained
                                            <input type="hidden" name="service_obtained" value="Service Obtained" class="form-control form-control-sm name_list1">
                                            </td>
                                            <td><select id="problem" name="country_origin"
                                                class="form-control form-control-sm text-center" onchange="fun_services_obtained(this.value)">
                                                <option disabled selected>Select</option>
                                                <option value="India">India</option>
                                                <option value="Outside India">Outside India</option>
                                            </select></td>
                                            <td colspan="2"><input type="text" name="supplier_name"  class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="quantity" class="form-control form-control-sm name_list1" value="">
                                            <td><input type="number" name="ser_amount" class="form-control form-control-sm name_list1 add_amount" value="" id="ser_amount" onkeyup="fn_service_obtained(this.value)"></td>
                                            <td><input type="number" name="ser_goods_amt" value=""
                                                class="form-control form-control-sm name_list1" id="add_ser_amount" readonly></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Total Quantity of Finished Goods Produced (kg) and Cost of Production
                                                <input type="hidden" name="other_dva_data[4][prt_id]" value="4" class="form-control form-control-sm name_list1">
                                            </th>
                                            <td><input type="number" value="" name="other_dva_data[4][quantity]" id="tot_add_qnty" class="form-control form-control-sm name_list1 tot_add_qnty" onkeyup="fin_goods_prod(this.value)"></td>
                                                <td><input type="number" value="" name="other_dva_data[4][amount]" id="tot_amt" class="form-control form-control-sm name_list1 tot_add_amount tot_amt" readonly></td>
                                            <td><input type="number" name="other_dva_data[4][goods_amt]" value="" id="" class="form-control form-control-sm name_list1 tot_cost_production" readonly></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Out of Total Cost above</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">(i) Non-Originating Raw Material per kg of unit produced(As per clause 2.6 of the Scheme Guidelines) - B
                                            <input type="hidden" name="other_dva_data[5][prt_id]" value="5" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[5][quantity]"  class="form-control form-control-sm name_list1" value="">
                                            <input type="hidden" name="other_dva_data[5][amount]"  class="form-control form-control-sm name_list1" value="" onkeyup="breakupsum()">
                                            <td><input type="number" name="other_dva_data[5][goods_amt]" value="" id="raw_material"
                                                class="form-control form-control-sm name_list1 a_aad_amt" readonly></td>
                                           
                                        </tr>
                                        <tr>
                                            <th colspan="5">(ii) Non-Originating Services and Other Expenses per kg of unit produced (As per clause 2.6 of the Scheme Guidelines) - B
                                            <input type="hidden" name="other_dva_data[6][prt_id]" value="6" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[6][quantity]"  class="form-control form-control-sm name_list1" value="">
                                          <input type="hidden" name="other_dva_data[6][amount]"  class="form-control form-control-sm name_list1" value="" onkeyup="breakupsum()"> 
                                            <td><input type="number" name="other_dva_data[6][goods_amt]" value="" id="other_material" class="form-control form-control-sm name_list1 a_aad_amt" readonly></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">(A) Cost of non-originating RM, Services and other expenses per kg of unit produced
                                            <input type="hidden" name="other_dva_data[7][prt_id]" value="7" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[7][quantity]"  class="form-control form-control-sm name_list1" value="">
                                            <input type="hidden" name="other_dva_data[7][amount]" class="form-control form-control-sm name_list1 total_amt" id="total_amount" onkeyup="breakupsum()" value="" readonly>
                                            <td><input type="number" name="other_dva_data[7][goods_amt]" value="" id="ab_tot" class="form-control form-control-sm name_list1 tot_aad_amt" readonly></td>
                                            </tr>
                                            
                                            <tr>
                                            <td colspan="3">(B) Net Sales of Eligbile Product (per kg) (Actual Selling Price) 
                                            <input type="hidden" name="other_dva_data[8][prt_id]" value="8" class="form-control form-control-sm name_list1 ">
                                            </td>
                                            <td><input type="number" name="other_dva_data[8][quantity]"  class="form-control form-control-sm name_list1" @if(isset($net_sales['ts_total_qnty'])) value="{{($net_sales['ts_total_qnty'])*1000}}" @endif readonly></td>
                                            <td><input type="number" onkeyup="breakupsum()" id="total_net_sales" name="other_dva_data[8][amount]"  class="form-control form-control-sm name_list1" @if(isset($net_sales['ts_total_sales'])) value="{{$net_sales['ts_total_sales']}}" @endif readonly></td>
                                            <td><input type="number" name="other_dva_data[8][goods_amt]" @if(isset($net_sales['ts_total_qnty'])) value="{{round($net_sales['ts_total_sales']/(($net_sales['ts_total_qnty'])*1000),2)}}" @endif id="tot_b"
                                                class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Domestic Value Addition (%) (B-A)/(B)
                                            <input type="hidden" name="other_dva_data[9][prt_id]" value="9" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[9][quantity]"  class="form-control form-control-sm name_list1" value="">
                                            <input type="hidden" name="other_dva_data[9][amount]" id="dva" class="form-control form-control-sm name_list1" value="" readonly>
                                            <td><input type="number" name="other_dva_data[9][goods_amt]" value="" id="tot_dva"
                                                class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 5px">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{ route('claimsalesdetail.create', $claim_id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i class="fa  fa-backward"></i> Sales</a>
                        </div>
                        {{-- <div class="col-md-2 ">
                            
                         </div> --}}
                        <div class="col-md-2 offset-md-3">
                            
                            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" id="sales_dva"><i class="fas fa-save"></i> Save as Draft</button>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('claiminvestmentdetail.create', $claim_id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"> Investment Summary <i class="fa  fa-forward"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
@push('scripts')
<script>

$(document).ready(function() {
                var i = 1;
                var j = 0;
                var sn = 2;
                $('#add').click(function() {
                    i++;
                    j++;
                    // alert(j);
                    // var c =parseInt($('#count_row_raw_raterial').val())+1;
                    // alert(c)
                    $("#count_row_raw_raterial").val(j.toFixed(0));
                    $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="dva_data['+ j +'][raw_material]" placeholder="" class="form-control form-control-sm name_list1"></td>'+
                        '<td><select id="country_origin_'+j+'" name="dva_data['+ j +'][country_origin]" class="form-control form-control-sm ind_otind text-center" onchange="fun_country_origin(this.value,'+j+')">'+
                            '<option disabled selected>Select</option>'+
                            '<option value="India">India</option>'+
                            '<option value="Outside India">Outside India</option>'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="text" name="dva_data['+ j +'][supplier_name]" placeholder="Name and Address of Supplier" class="form-control form-control-sm name_list1"></td><td><input type="number" name="dva_data['+ j +'][quantity]"  class="form-control form-control-sm name_list1 add_qnty"></td>'+
                        '<td><input type="number" name="dva_data['+ j +'][amount]" onkeyup="breakupsumadd('+j+',this.value)" class="form-control form-control-sm name_list1 add_amount tot_amt" id="amount_'+ j +'"></td>'+
                        '<td><input type="number" name="dva_data['+ j +'][goods_amt]" value="" class="form-control form-control-sm name_list1 ot_tot_goods_amt add_raw_material_'+ j +'" id="tot_goods_amt_'+ j +'" readonly></td>'+
                        '<td class="text-center"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove">Remove</button></td></tr>');
                });


                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    var data=$('#row' + button_id).find('#country_origin_'+ j).val();
                    if(data == 'Outside India'){
                        var raw_data = document.getElementById('raw_material').value - document.getElementById('tot_goods_amt_'+j).value;
                        document.getElementById('raw_material').value = raw_data.toFixed(2)
                    }
                    document.getElementById('tot_amt').value = document.getElementById('tot_amt').value -  document.getElementById('amount_'+j).value;

                    document.getElementById('ab_tot').value = document.getElementById('ab_tot').value - document.getElementById('tot_goods_amt_'+j).value;

                    $('#row' + button_id + '').remove();
                    j--;
                    $("#count_row_raw_raterial").val(j.toFixed(0));
                });
            });
        
        // $(document).on("keyup", ".add_qnty", function() {
        //     var sum = 0;
        //     $(".add_qnty").each(function() {
        //         sum += +$(this).val();
        //     });
        //     $(".tot_add_qnty").val(sum);
          
        // });

        $(document).on("keyup", ".add_amount", function() {
            var sum = 0;
            $(".add_amount").each(function() {
                sum += +$(this).val();
            });

            $(".tot_add_amount").val(sum);
          
        });

        
        $(document).on("keyup", ".tot_amt", function() {
            
            var sum = $('.tot_add_amount').val();
            var tot_qnty = $('.tot_add_qnty').val();

            var data = (sum/tot_qnty).toFixed(2);
           
            $(".tot_cost_production").val(data);
          
        });

        function breakupsum(){
            var consumables=0; 

            var total_amount1 = parseInt(document.getElementById('total_amount').value);
            var total_net_sales1 = parseInt(document.getElementById('total_net_sales').value);
           
            document.getElementById('dva').value = ((total_net_sales1 - total_amount1)/total_net_sales1).toFixed(2);
            
            var tot_qnty = $('#tot_add_qnty').val();
            var consumables = parseFloat(document.getElementById('consumables').value);
            
            if(consumables){
                document.getElementById('add_consumables').value = (consumables/tot_qnty).toFixed(2); 
            }
            var expense = 0;
            var expense = parseFloat(document.getElementById('expenses').value);
            if(expense)
                document.getElementById('add_expenses').value = (expense/tot_qnty).toFixed(2);

            var oth_expense=0;
            var oth_expense = parseFloat(document.getElementById('oth_expense').value);
            
            if(oth_expense)
                document.getElementById('add_oth_expense').value = (oth_expense/tot_qnty).toFixed(2);

            var ser_amount =0;
            var ser_amount = parseFloat(document.getElementById('ser_amount').value);
            if(ser_amount)
            document.getElementById('add_ser_amount').value = (ser_amount/tot_qnty).toFixed(2);

        }

        function breakupsumadd(index,amt_val) {
            var consumables=0;
            
            var tot_qnty = $('#tot_add_qnty').val();
           
            if(amt_val)
                document.getElementById('tot_goods_amt_'+index).value = (amt_val/tot_qnty).toFixed(2);

            
            var sumdata=0;
            var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
            for(q=0; q<=count_rr_raterial; q++)
            {
                if(document.getElementById('country_origin_'+q).value == 'Outside India')
                {  
                    sumdata = sumdata+parseFloat(document.getElementById('tot_goods_amt_'+q).value);
                }
            }    
            document.getElementById('raw_material').value= sumdata.toFixed(2);
           
            if(document.getElementById('problem').value == 'Outside India'){

                var oth_mat = parseFloat(document.getElementById('add_ser_amount').value);
                document.getElementById('other_material').value = oth_mat.toFixed(2);
            } 
        }
       
        function fun_country_origin(val,index)
        {
            var sumdata=0;
            if(val== 'Outside India')
            {
                var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
                for(q=0; q<=count_rr_raterial; q++)
                {
                    if(document.getElementById('country_origin_'+q).value == 'Outside India')
                    {  
                        sumdata = sumdata+parseFloat(document.getElementById('tot_goods_amt_'+q).value);
                    }
                }  
                document.getElementById('raw_material').value= sumdata.toFixed(2); 
            }
            
            if(val=='India')
            {
                var raw_mat = parseFloat(document.getElementById('raw_material').value)-parseFloat(document.getElementById('tot_goods_amt_'+index).value); 
                document.getElementById('raw_material').value = raw_mat.toFixed(2); 
            }
       }

       function fin_goods_prod(val)
       {
            var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
            for(q=0; q<=count_rr_raterial; q++)
            {
                // alert(count_rr_raterial);
                // alert(val);
                var data12 =parseFloat(document.getElementById('amount_'+q).value)/val; 
                document.getElementById('tot_goods_amt_'+q).value= data12.toFixed(2); 
                
                var sumdata=0;
                if(document.getElementById('country_origin_'+q).value== 'Outside India')
                {
                    var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
                    for(q=0; q<=count_rr_raterial; q++)
                    {
                        if(document.getElementById('country_origin_'+q).value == 'Outside India')
                        {  
                            sumdata = sumdata + parseFloat(document.getElementById('tot_goods_amt_'+q).value);
                        }
                    }  
                    document.getElementById('raw_material').value= sumdata.toFixed(2); 
                }
                
            }  

            if(document.getElementById('problem').value == 'Outside India'){
               
                var sr_amt =$('#ser_amount').val()/val;
                document.getElementById('other_material').value= sr_amt.toFixed(2); 
            }
            var tot_qnty = val;
            var consumables = parseFloat(document.getElementById('consumables').value);
            
            if(consumables){
                document.getElementById('add_consumables').value = (consumables/tot_qnty).toFixed(2); 
            }
            var expense = 0;
            var expense = parseFloat(document.getElementById('expenses').value);
            if(expense)
                document.getElementById('add_expenses').value = (expense/tot_qnty).toFixed(2);

            var oth_expense=0;
            var oth_expense = parseFloat(document.getElementById('oth_expense').value);
            
            if(oth_expense)
                document.getElementById('add_oth_expense').value = (oth_expense/tot_qnty).toFixed(2);

            var ser_amount =0;
            var ser_amount = parseFloat(document.getElementById('ser_amount').value);
            if(ser_amount)
                document.getElementById('add_ser_amount').value = (ser_amount/tot_qnty).toFixed(2);

            var raw_amount =0;
            var raw_amount = parseFloat(document.getElementById('raw_material').value);
            var oth_amount =0;
            var oth_amount = parseFloat(document.getElementById('other_material').value);
            var ab_tot = (raw_amount + oth_amount).toFixed(2);
            document.getElementById('ab_tot').value = ab_tot;
            var tot_b = parseFloat(document.getElementById('tot_b').value);

            var total = (tot_b - ab_tot)/tot_b ;

            document.getElementById('tot_dva').value = (total*100).toFixed(2);
       }

        function fn_service_obtained(val) {
            if(document.getElementById('problem').value == 'Outside India'){
                var add_sr_amount = parseFloat(document.getElementById('add_ser_amount').value);
                
                document.getElementById('other_material').value= add_sr_amount.toFixed(2); 
            }else{
                document.getElementById('other_material').value='0.0'; 
            }
            
        }

        function fun_services_obtained(val){ 
            if(val== 'Outside India')
            {
                var oth_data =parseFloat(document.getElementById('add_ser_amount').value);
                document.getElementById('other_material').value= oth_data.toFixed(2); 
            }
            
            if(val=='India')
            {
                var tot =parseFloat(document.getElementById('other_material').value)-parseFloat(document.getElementById('add_ser_amount').value); 

                document.getElementById('other_material').value = tot.toFixed(2); 
            }
       }
        $(document).ready(function () {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("sales_dva");
                btn.disabled = true;
                setTimeout(function(){btn.disabled = false;}, (1000*20));
            });
        });
</script>

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\User\Claims\SalesDvaRequest', '#form-Dvasales') !!}
@endpush
@endpush