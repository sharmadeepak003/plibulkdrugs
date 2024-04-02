@extends('layouts.user.dashboard-master')

@section('title')
    DVA
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimsalesdetail.dva_update',$id)}}" id="form-Dvasales" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                @method('PATCH')
                <input type="hidden" name="claim_id" value="{{$id}}">
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
                                        <th>Amount against per kg of finished<br> goods produced / goods sold</th>
                                        <th class="text-center" style="text-decoration:none"><button
                                            type="button" name="add" id="add"
                                            class="btn btn-success btn-sm">Add
                                            More</button>
                                        </th>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($raw_material)}} --}}
                                        @php $index_raw_material=0 @endphp
                                        @foreach ($raw_material as $Key => $material)
                                       
                                            @if($material->raw_material != 'Service Obtained')
                                            
                                            {{-- <tr> 
                                            <td><input type="text" name="dva_data[0][raw_material]" value="{{$material->raw_material}}" class="form-control form-control-sm name_list1"></td>
                                            <td><select id="problem4" name="dva_data[0][country_origin]"
                                                class="form-control form-control-sm text-center">
                                                <option value="India" @if($material->country_origin == 'India')selected @endif>India</option>
                                                <option value="Outside India"  @if($material->country_origin == 'Outside India')selected @endif>Outside India</option>
                                            </select></td>
                                            <td><input type="text" name="dva_data[0][supplier_name]" value="{{$material->supplier_name}}" class="form-control form-control-sm name_list1"></td>
                                            <td><input type="number" value="{{$material->quantity}}" name="dva_data[0][quantity]"  class="form-control form-control-sm name_list1 add_qnty"></td>
                                            <td><input type="number" name="dva_data[0][amount]" value="{{$material->amount}}"
                                                   class="form-control form-control-sm name_list1 add_amount tot_amt"></td>
                                            <td><input type="number" name="dva_data[0][goods_amt]" value="{{$material->goods_amt}}"
                                                    class="form-control form-control-sm name_list1 "></td>
                                            </tr> --}}
                                            {{-- {{dd(count($raw_material))}} --}}
                                            <tr>
                                                <input type="hidden" name="dva_data[{{$index_raw_material}}][id]" id="id" value="{{$material->id}}">
                                                <input type="hidden" name="count_row_raw_raterial" id="count_row_raw_raterial" value="{{count($raw_material) - 1}}">
                                                <td><input type="text" name="dva_data[{{$index_raw_material}}][raw_material]" placeholder="" value="{{$material->raw_material}}" class="form-control form-control-sm name_list1"></td>
                                                <td><select id="country_origin_{{$index_raw_material}}" name="dva_data[{{$index_raw_material}}][country_origin]"
                                                    class="form-control form-control-sm text-center ind_otind" onchange="fun_country_origin(this.value,{{$index_raw_material}})">
                                                    <option value="India" @if($material->country_origin == 'India')selected @endif>India</option>
                                                <option value="Outside India"  @if($material->country_origin == 'Outside India')selected @endif>Outside India</option>
                                                </select></td>
                                                <td><input type="text" name="dva_data[{{$index_raw_material}}][supplier_name]"
                                                       value="{{$material->supplier_name}}"
                                                        class="form-control form-control-sm name_list1"></td>
                                                <td><input type="number" value="{{$material->quantity}}" name="dva_data[{{$index_raw_material}}][quantity]"  class="form-control form-control-sm name_list1 add_qnty"></td>
                                                <td><input type="number" name="dva_data[{{$index_raw_material}}][amount]" value="{{$material->amount}}"
                                                 id="amount_{{$index_raw_material}}" class="form-control form-control-sm name_list1 add_amount tot_amt " onkeyup="breakupsumadd({{$index_raw_material}},this.value)"></td>
                                                <td><input type="number" name="dva_data[{{$index_raw_material}}][goods_amt]" value="{{$material->goods_amt}}" id="tot_goods_amt_{{$index_raw_material}}" class="form-control form-control-sm name_list1 ot_tot_goods_amt add_raw_material_{{$index_raw_material}} remove_data" readonly></td>
                                            </tr>
                                            @php $index_raw_material++; @endphp
                                            @endif
                                        @endforeach

                                    </tbody>
                                   
                                    {{-- <table class="table table-bordered table-hover table-sm"> --}}

                                    <tfoot>
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 1)
                                        <tr>
                                            <td colspan="4">Other Consumables
                                            <input type="hidden" name="other_dva_data[1][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[1][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[1][quantity]" class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <td><input type="number" name="other_dva_data[1][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt " value="{{$data->amount}}" id="consumables" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[1][goods_amt]" value="{{$data->goods_amt}}" id="add_consumables" class="form-control form-control-sm name_list1 remove_data" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 2)
                                        <tr>
                                            <td colspan="4">Salary Expenses
                                            <input type="hidden" name="other_dva_data[2][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[2][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            <input type="hidden" name="other_dva_data[2][quantity]" class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <td><input type="number" name="other_dva_data[2][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt" value="{{$data->amount}}" id="expenses" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[2][goods_amt]" value="{{$data->goods_amt}}" id="add_expenses" class="form-control form-control-sm name_list1 remove_data" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 3)
                                        <tr>
                                            <td colspan="4">Other Expenses
                                            <input type="hidden" name="other_dva_data[3][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[3][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[3][quantity]" class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <td><input type="number" name="other_dva_data[3][amount]" class="form-control form-control-sm name_list1 add_amount tot_amt" value="{{$data->amount}}" id="oth_expense" onkeyup="breakupsum()"></td>
                                            <td><input type="number" name="other_dva_data[3][goods_amt]" value="{{$data->goods_amt}}" id="add_oth_expense" class="form-control form-control-sm name_list1 remove_data" readonly></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @foreach ($raw_material as $Key => $material)
                                            @if($material->raw_material == 'Service Obtained')
                                            <tr>
                                                <td>Services Obtained
                                                   
                                                    <input type="hidden" name="service_id" value="{{$material->id}}" class="form-control form-control-sm name_list1">
                                                </td>
                                                <input type="hidden" name="service_obtained" value="{{$material->raw_material}}" class="form-control form-control-sm name_list1">
                                                
                                                <td><select id="problem" name="country_origin"
                                                    class="form-control form-control-sm text-center" onchange="fun_services_obtained(this.value)">
                                                    <option value="India" @if($material->country_origin == 'India')selected @endif>India</option>
                                                    <option value="Outside India"  @if($material->country_origin == 'Outside India')selected @endif>Outside India</option>
                                                </select></td>
                                                <td colspan="2"><input type="text" name="supplier_name"  class="form-control form-control-sm name_list1" value="{{$material->supplier_name}}"></td>
                                                <input type="hidden" name="quantity" class="form-control form-control-sm name_list1" value="{{$material->quantity}}">
                                                <td><input type="number" name="ser_amount" class="form-control form-control-sm name_list1 add_amount" value="{{$material->amount}}" id="ser_amount" onkeyup="fn_service_obtained(this.value)"></td>
                                                <td><input type="number" name="ser_goods_amt" value="{{$material->goods_amt}}"
                                                    class="form-control form-control-sm name_list1 remove_data" id="add_ser_amount" readonly></td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 4)
                                        <tr>
                                            <th colspan="3">Total Quantity of Finished Goods Produced (kg) and Cost of Production
                                            
                                            <input type="hidden" name="other_dva_data[4][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1">
                                            <input type="hidden" name="other_dva_data[4][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            </th>
                                            <td><input type="number" value="{{$data->quantity}}" name="other_dva_data[4][quantity]" id="tot_add_qnty" class="form-control form-control-sm name_list1 tot_add_qnty" onkeyup="fin_goods_prod(this.value)"></td>
                                                <td><input type="number" value="{{$data->amount}}" name="other_dva_data[4][amount]" id="tot_amt" class="form-control form-control-sm name_list1 tot_add_amount tot_amt" readonly></td>
                                            <td><input type="number" name="other_dva_data[4][goods_amt]" value="{{$data->goods_amt}}" id="" class="form-control form-control-sm name_list1 tot_cost_production" readonly></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="6">Out of Total Cost above</th>
                                        </tr>
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 5)
                                        <tr>
                                            <th colspan="5">(i) Non-Originating Raw Material per kg of unit produced(As per clause 2.6 of the Scheme Guidelines) - B
                                            
                                            <input type="hidden" name="other_dva_data[5][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            <input type="hidden" name="other_dva_data[5][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[5][quantity]"  class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <input type="hidden" name="other_dva_data[5][amount]"  class="form-control form-control-sm name_list1" value="{{$data->amount}}" onkeyup="breakupsum()">
                                            <td><input type="number" name="other_dva_data[5][goods_amt]" value="{{$data->goods_amt}}" id="raw_material"
                                                class="form-control form-control-sm name_list1 a_aad_amt" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 6)
                                        <tr>
                                            <th colspan="5">(ii) Non-Originating Services and Other Expenses per kg of unit produced (As per clause 2.6 of the Scheme Guidelines) - B
                                               
                                            <input type="hidden" name="other_dva_data[6][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[6][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[6][quantity]"  class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                          <input type="hidden" name="other_dva_data[6][amount]"  class="form-control form-control-sm name_list1" value="{{$data->amount}}" onkeyup="breakupsum()"> 
                                            <td><input type="number" name="other_dva_data[6][goods_amt]" value="{{$data->goods_amt}}" id="other_material" class="form-control form-control-sm name_list1 a_aad_amt" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 7)
                                        <tr>
                                            <th colspan="5">(A) Cost of non-originating RM, Services and other expenses per kg of unit produced
                                            
                                            <input type="hidden" name="other_dva_data[7][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1">
                                            <input type="hidden" name="other_dva_data[7][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            </th>
                                            <input type="hidden" name="other_dva_data[7][quantity]"  class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <input type="hidden" name="other_dva_data[7][amount]" class="form-control form-control-sm name_list1 total_amt" id="total_amount" onkeyup="breakupsum()" value="{{$data->amount}}" readonly>
                                            <td><input type="number" name="other_dva_data[7][goods_amt]" value="{{$data->goods_amt}}" id="ab_tot" class="form-control form-control-sm name_list1 tot_aad_amt" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 8)
                                        <tr>
                                            <td colspan="3">(B) Net Sales of Eligbile Product (per kg) (Actual Selling Price) 
                                            
                                            <input type="hidden" name="other_dva_data[8][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="other_dva_data[8][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1 ">
                                            </td>
                                            <td><input type="number" name="other_dva_data[8][quantity]"  class="form-control form-control-sm name_list1" value="{{$data->prev_qnty}}" readonly></td>
                                            <td><input type="number" onkeyup="breakupsum()" id="total_net_sales" name="other_dva_data[8][amount]"  class="form-control form-control-sm name_list1" value="{{$data->amount}}" readonly></td>
                                            <td><input type="number" name="other_dva_data[8][goods_amt]" value="{{$data->goods_amt}}" id="tot_b"
                                                class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 9)
                                        <tr>
                                            <td colspan="5">Domestic Value Addition (%) (B-A)/(B)
                                            
                                            <input type="hidden" name="other_dva_data[9][id]" value="{{$data->id}}" class="form-control form-control-sm name_list1">
                                            <input type="hidden" name="other_dva_data[9][prt_id]" value="{{$data->prt_id}}" class="form-control form-control-sm name_list1">
                                            </td>
                                            <input type="hidden" name="other_dva_data[9][quantity]"  class="form-control form-control-sm name_list1" value="{{$data->quantity}}">
                                            <input type="hidden" name="other_dva_data[9][amount]" id="dva" class="form-control form-control-sm name_list1" value="{{$data->amount}}" readonly>
                                            <td><input type="number" name="other_dva_data[9][goods_amt]" value="{{$data->goods_amt}}" id="tot_dva"
                                                class="form-control form-control-sm name_list1" readonly></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 5px">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{ route('claimsalesdetail.create', $id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i class="fa  fa-backward"></i> Sales</a>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm " id="sales_dva"><i
                                    class="fas fa-save"></i> Save as Draft</button>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('claiminvestmentdetail.create', $id) }}"
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
                var j = {{sizeOf($raw_material)-2}};
                var sn = j+1;
                $('#add').click(function() {
                  
                    i++;
                    j++;
                   
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
                    // var sum = 0;
                    // $('.remove_data').each(function() {
                    //     sum += +$(this).val();
                    // });
                    // $('.tot_cost_production').val(sum.toFixed(2));

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
                var data1 = parseFloat(document.getElementById('add_ser_amount').value);
                document.getElementById('other_material').value = data1.toFixed(2);
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
			document.getElementById('raw_material').value= sumdata.toFixed(2);
                }  
                 
               
            }

            
            if(val=='India')
            {
                var data2 =parseFloat(document.getElementById('raw_material').value)-parseFloat(document.getElementById('tot_goods_amt_'+index).value);
                document.getElementById('raw_material').value = data2.toFixed(2);

            }

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

       function fin_goods_prod(val)
       {
            var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
            for(q=0; q<count_rr_raterial; q++)
            {
                
                var sumdata=0;
                var count_rr_raterial=document.getElementById('count_row_raw_raterial').value;
              
                for(q=0; q<count_rr_raterial; q++)
                {
                    document.getElementById('tot_goods_amt_'+q).value= parseFloat(document.getElementById('amount_'+q).value)/val.toFixed(2); 

                    if(document.getElementById('country_origin_'+q).value == 'Outside India')
                    {  
                        sumdata = sumdata+parseFloat(document.getElementById('tot_goods_amt_'+q).value);
                    }
                }  
                document.getElementById('raw_material').value= sumdata.toFixed(2); 
                
                
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
                document.getElementById('other_material').value= parseFloat(document.getElementById('add_ser_amount').value); 
            }

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