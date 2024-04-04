@extends('layouts.user.dashboard-master')

@section('title')
    Claim : Sales Details of Eligible product
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        input[type="file"] {
            padding: 1px;
        }
    </style>
@endpush

@section('content')
    <div class="row py-4">
        <div class="col-md-12">
            <form action="{{ route('claimsalesdetail.update', $claimMaster->id) }}" id="sales_form" role="form"
                method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                @method('PUT')
                <div class="card border-info">
                    <div class="card-header bg-gradient-info">
                        <div class="row">
                            <div class="col-md-12 text-bold">
                                2.1 Sales of eligible products as per approval letter on which incentive is being claimed
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
                    <input type="hidden" id="claim_id" name="claim_id" value="{{ $claimMaster->id }}">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="exmple" class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Name of Eligible Product</th>
                                                <td class="text-center">{{$product->product}}
                                                    <input type="hidden" name="ep_approval_data[1][name_of_product]" value="{{ $product->product}}"  class="form-control form-control-sm"></td>
                                                <th rowspan="3" class="text-center">Quantity(in MT)</th>
                                                <th  rowspan="3" class="text-center">Actual Sales Amount(₹)</th>
                                                <th  rowspan="3" class="text-center">Sales considered for Incentive (Lower of Actual selling price and Quoted Sales Price) (₹) 	
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Quoted Sales Price(₹)</th>
                                                <td><input type="text" name="ep_approval_data[1][quoted_sales_price]" id="quoted_sales_price" value="{{$claimApproval->quoted_sales_price}}" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                                <th>HSN Code</th>
                                                <td><input type="text" name="ep_approval_data[1][hsn]" id="hsn" value="{{$hsn}}"
                                                    class="form-control form-control-sm" readonly></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">Domestic Sales</td>
                                                <td><input type="number" name="ep_approval_data[1][dom_qnty]" id="dom_qnty"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->dom_qty}}"
                                                    class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][dom_sales]" id="dom_sales"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->dom_sales}}"
                                                    class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][dom_incentive]" id="dom_incentive"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->dom_incentive}}"
                                                    class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Export Sales</td>
                                                <td><input type="number" name="ep_approval_data[1][exp_qnty]" id="exp_qnty"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->exp_qty}}"
                                                    class="form-control form-control-sm"></td>
                                                <td> <input type="number" name="ep_approval_data[1][exp_sales]" id="exp_sales"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->exp_sales}}"
                                                    class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][exp_incentive]" id="exp_incentive"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->exp_incentive}}"
                                                    class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">In-House Consumption</td>
                                                <td> <input type="number" name="ep_approval_data[1][cons_qnty]" id="cons_qnty"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->cons_qnty}}"
                                                    class="form-control form-control-sm"></td>
                                                <td> <input type="number" name="ep_approval_data[1][cons_sales]" id="cons_sales"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->cons_sales}}"
                                                    class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][cons_incentive]" id="cons_incentive"
                                                    onkeyup="breakupsum()" value="{{$claimApproval->cons_incentive}}"
                                                    class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Total(A)</th>
                                                <td><input type="number" name="ep_approval_data[1][ts_total_qnty]" id="ts_total_qnty"
                                                    value="{{$claimApproval->ts_total_qnty}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_approval_data[1][ts_total_sales]" id="ts_total_sales"
                                                    value="{{$claimApproval->ts_total_sales}}" class="form-control form-control-sm" readonly></td>
                                                <td> <input type="number" name="ep_approval_data[1][ts_total_considerd]"
                                                    id="ts_total_considerd" value="{{$claimApproval->ts_total_incentv}}"
                                                    class="form-control form-control-sm tot_add_incentive" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-info">
                    <div class="card-header bg-gradient-info">
                        <div class="row">
                            <div class="col-md-12 text-bold">
                                2.2 Sales of Eligible products as per QRR and as per incentive claim.
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="dynamic_field12" class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr  class="table-primary">
                                                
                                                <th rowspan="2" class="text-center">Name of ELigible Product</th>
                                                <th rowspan="1" colspan="2">Sales as per QRR </th>
                                                <th rowspan="1" colspan="2">Sales for Incentive Claim  	
                                                </th>
                                                <th rowspan="1" colspan="2">Difference  	
                                                </th>
                                                <th rowspan="2">Reasons for difference(Note: If difference is zero then fill NA.) </th>
                                            </tr>		
                                            <tr>
                                                <th >Quantity(MT)</th>
                                                <th >Amount(₹)</th>
                                                <th >Quantity(MT)</th>
                                                <th >Amount(₹)</th>
                                                <th >Difference Quantity(MT)</th>
                                                <th >Difference Amount(₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Domestic Sales</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_dom_qnty]" id="old_qrr_dom_qnty"
                                                    @if($qrr_data) value="{{ round($qrr_data->dom_qnty,2) }}" @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_dom_sales]" id="old_qrr_dom_sales"
                                                    @if($qrr_data) value="{{ $qrr_data->dom_sales }}"  @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_dom_qnty]" id="new_qrr_dom_qnty"
                                                    value="{{$claimAsQrr->new_qrr_dom_qnty}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_dom_sales]" id="new_qrr_dom_sales"
                                                    value="{{$claimAsQrr->new_qrr_dom_sales}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_dom_qnty]" onkeyup="breakupsum()" id="diff_dom_qnty" value="{{$claimAsQrr->diff_dom_qnty}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_dom_amount]" onkeyup="breakupsum()" id="diff_dom_sales" value="{{$claimAsQrr->diff_dom_sales}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][dom_reason_diff]" id="dom_reason_diff"
                                                    value="{{$claimAsQrr->dom_reason_diff}}" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                                
                                                <td>Export Sales</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_exp_qnty]" id="old_qrr_exp_qnty"
                                                    @if($qrr_data) value="{{ round($qrr_data->exp_qnty,2) }}"  @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_exp_sales]" id="old_qrr_exp_sales"
                                                    @if($qrr_data) value="{{ $qrr_data->exp_sales }}"  @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_exp_qnty]" id="new_qrr_exp_qnty"
                                                    value="{{$claimAsQrr->new_qrr_exp_qnty}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_exp_sales]" id="new_qrr_exp_sales"
                                                    value="{{$claimAsQrr->new_qrr_exp_sales}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_exp_qnty]" id="diff_exp_qnty" value="{{$claimAsQrr->diff_exp_qnty}}"
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_exp_sales]"  id="diff_exp_sales" value="{{$claimAsQrr->diff_exp_sales}}"
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][exp_reason_diff]" id="exp_reason_diff"
                                                    value="{{$claimAsQrr->exp_reason_diff}}" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                                
                                                <td>In-house Consumption</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_cons_qnty]" id="old_qrr_cons_qnty"
                                                    @if($qrr_data) value="{{ round($qrr_data->cons_qnty,2) }}"  @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_cons_sales]" id="old_qrr_cons_sales"
                                                    @if($qrr_data) value="{{ $qrr_data->cons_sales }}"  @else value="0.0" @endif class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_cons_qnty]" id="new_qrr_cons_qnty"
                                                    value="{{$claimAsQrr->new_qrr_cons_qnty}}" class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_cons_sales]" id="new_qrr_cons_sales"
                                                    value="{{$claimAsQrr->new_qrr_cons_sales}}" class="form-control form-control-sm" readonly></td>
                                                    <td><input type="number" name="ep_qrr_data[1][diff_cons_qnty]"
                                                        id="diff_cons_qnty" value="{{$claimAsQrr->diff_cons_qnty}}"
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_cons_sales]"
                                                        id="diff_cons_sales" value="{{$claimAsQrr->diff_cons_sales}}"
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][cons_reason_diff]" id="cons_reason_diff"
                                                    value="{{$claimAsQrr->cons_reason_diff}}" class="form-control form-control-sm"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-primary">
                    @foreach ($claimUserResponse as $q)
                  
                    @if ($q->ques_id == 3)
                        <div class="card-body">
                            <div class="card-body mt-4">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                        <tr style="background:white;">
                                            <th col="9" class="text-left">2.3 Whetherthere is any sales of
                                                manufactured aligible product to related party as defined under clause 2.29 of scheme guidelines</th>
                                            <input type="hidden" name="ques[3]" value="3">
                                            <td col="3" class="text-center">
                                                <select id="problem" name="value[3]"
                                                    class="form-control form-control-sm text-center">
                                                    <option value="Y" @if ($q->response == 'Y') selected @else @endif>Yes</option>
                                                    <option value="N" @if ($q->response == 'N') selected @else @endif>No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        
                            <div class="card border-primary display m-2 py-10"
                                style=" @if ($q->response == 'Y') display  @else display:none; @endif">
                                    <div class="card-body">
                                        <table class="table table-sm table-bordered table-hover">
                                            <thead class="">
                                                <tr>
                                                    <th>
                                                        @if(count($claimSalesManufTsGoods)>0)
                                                            {{$claimSalesManufTsGoods[0]->product_name}}
                                                        @endif
                                                    </th>      
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-sm table-bordered table-hover" id="dynamic_field">
                                            <thead class="bg-gradient-info">
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Name of Related Party</th>
                                                    <th class="text-center">Relationship</th>
                                                    <th class="text-center">Quantity(in MT)</th>
                                                    <th class="text-center">Sales of EP(₹)</th>
                                                    <th class="text-center" style="text-decoration:none"><button
                                                            type="button" name="add" id="add"
                                                            class="btn btn-success">Add
                                                            More</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach ($claimSalesManufTsGoods as $key => $manufact_data)
                                                <tr><input type="hidden"
                                                    name="ts_goods[{{$key}}][name_of_product]"
                                                    value="{{$manufact_data->product_name}}"
                                                    class="form-control form-control-sm name_list1">
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <input type="hidden" name="ts_goods[{{ $key }}][id]"
                                                        value="@if (isset($manufact_data->id)) {{ $manufact_data->id }} @endif">
                                                    <td class="text-center">
                                                        <input type="text"
                                                            name="ts_goods[{{ $key }}][name_of_related_party]"
                                                            value="{{ $manufact_data->related_party_name }}"
                                                            class="form-control form-control-sm name_list1">
                                                    </td>
                                                    <td class="text-center"><input type="text"
                                                            name="ts_goods[{{ $key }}][relationship]"
                                                            value="{{ $manufact_data->relationship }}"
                                                            class="form-control form-control-sm name_list1"></td>
                                                    <td class="text-center"><input type="number"
                                                            name="ts_goods[{{ $key }}][ts_sales]"
                                                            value="{{ $manufact_data->quantity }}"
                                                            class="form-control form-control-sm name_list1 add_ts_sales">
                                                    </td>
                                                    
                                                </td>
                                                    <td class="text-center"><input type="number"
                                                            name="ts_goods[{{ $key }}][ep_sales]" onkeyup="breakupsum()" id="ts_goods_tot_amt"
                                                            value="{{ $manufact_data->sales_ep }}"
                                                            class="form-control form-control-sm name_list1 ts_goods_sum">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- {{dd($claimSalesManufTsGoods)}} --}}
                                            <tfoot>
                                                <td class="text-center" colspan="3">
                                                    Total
                                                </td>
                                                
                                                <td class="text-center"><input type="text" name="total_goods_qnty" id="total_goods_qnty" value="{{$claimSalesManufTsGoods->sum('quantity')}}" class="form-control form-control-sm name_list1 tot_add_ts_sales" readonly>
                                                </td>
                                                <td class="text-center"><input type="text" name="total_goods_amt"   id="total_goods_amt" value="{{$claimSalesManufTsGoods->sum('sales_ep')}}" class="form-control form-control-sm name_list1 ts_goods_sum_total" readonly>
                                                </td>
                                                <td style=""></td>
                                            </tfoot>
                                        </table>
                                        
                                    </div>
                            
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>
                <div class="card border-info">
                    <div class="card-header bg-gradient-info">
                        <div class="row">
                            <div class="col-md-12 text-bold">
                                2.4 Reconciliation of Total Sales from Greenfield Project of Eligible Product
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Particulars</th>
                                                <th colspan="2">Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($claimRecSales as $recSales)
                                            
                                                <tr>
                                                    @if ($recSales->part_id == 1)
                                                        <td>Total Income as per Financial Statements (A)</td>
                                                        <input type="hidden" name="part_0[14]" value="1">
                                                        <td colspan="2">
                                                            <input type="number" name="amount_0[14]" id="total_income"
                                                                value="{{ $recSales->amount }}" onkeyup="breakupsum()"
                                                                class="form-control form-control-sm ">
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if ($recSales->part_id == 2)
                                                        <td>Sales of Eligible Product on which incentive has been claimed
                                                            (B)
                                                        </td>
                                                        <input type="hidden" name="part_0[15]" value="2">
                                                        <td colspan="2">
                                                            <input type="number" name="amount_0[15]" id="ts_sales_less"
                                                                onkeyup="breakupsum()" value="{{ $recSales->amount }}"
                                                                class="form-control form-control-sm ">
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if ($recSales->part_id == 3)
                                                        <td>Income not pertaining to Greenfield Project(A-B)</td>
                                                        <input type="hidden" name="part_0[16]" value="3">
                                                        <td colspan="2">
                                                            <input type="text" name="amount_0[16]"
                                                                id="ts_pertaining_income" value="{{ $recSales->amount }}"
                                                                class="form-control form-control-sm " readonly>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table id="dynamic_field2"
                                        class="table table-sm table-striped table-bordered table-hover">
                                        <div class="font-weight-bold">Please provide break-up of income not pertaining
                                            Greenfield Project</div>
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Particulars</th>
                                                <th colspan="2">Amount</th>
                                                <th class="text-center" style="text-decoration:none"><button
                                                        type="button" name="add2" id="add2"
                                                        class="btn btn-success">Add
                                                        More</button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            @foreach ($claimRecSales as $key => $recSales)
                                                @if ($recSales->part_id != 1 && $recSales->part_id != 2 && $recSales->part_id != 3)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden"
                                                                name="breakup[{{ $key }}][id]"
                                                                id="breakup[{{ $key }}][id]"
                                                                value="{{ $recSales->id }}"
                                                                class="form-control form-control-sm">
                                                            <input type="hidden"
                                                                name="breakup[{{ $key }}][particular]"
                                                                id="breakup[{{ $key }}][particular]"
                                                                value="{{ $recSales->part_id }}"
                                                                class="form-control form-control-sm">
                                                            @if($recSales->part_id == 9)
                                                            Miscellaneous other income (please specify nature)
                                                            <input type="text"
                                                            name="breakup[{{ $key }}][particular_name]"
                                                            id="breakup[{{ $key }}][particular_name]" value="{{$recSales->particular_name}}"
                                                            class="form-control form-control-sm ">
                                                            
                                                            @elseif($recSales->part_id == 4 || $recSales->part_id == 5 || $recSales->part_id == 6 || $recSales->part_id == 7|| $recSales->part_id == 8)
                                                                {{ $recSales->particular_name }}
                                                                <input type="hidden"
                                                                name="breakup[{{ $key }}][particular_name]"
                                                                id="breakup[{{ $key }}][particular_name]" value="{{$recSales->particular_name}}"
                                                                class="form-control form-control-sm ">
                                                            @else
                                                            <input type="text"
                                                            name="breakup[{{ $key }}][particular_name]"
                                                            id="breakup[{{ $key }}][particular_name]" value="{{$recSales->particular_name}}"
                                                            class="form-control form-control-sm ">
                                                            @endif
                                                        </td>
                                                        <input type="hidden"
                                                            name="breakup[{{ $key }}][particular]"
                                                            id="breakup[{{ $key }}][particular]"
                                                            value="{{ $recSales->part_id }}"
                                                            class="form-control form-control-sm">
                                                        <td colspan="2">
                                                            <input type="text"
                                                                name="breakup[{{ $key }}][amount]"
                                                                id="breakup[{{ $key }}][amount]"
                                                                value="{{ $recSales->amount }}"
                                                                class="form-control form-control-sm rec_tot">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="1" class="text-center">Grand
                                                    Total</th>
                                                <td><input type="text"  name="grand_total"  id="grand_total" class="form-control form-control-sm text-center rec_tot_total" id="gt3" value="{{$claimRecSales[1]->ts_goods_total}}" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card border-info">
                    <div class="card-header bg-gradient-info">
                        <div class="row">
                            <div class="col-md-12 text-bold">
                                2.5 Baseline Sales Declaration
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <table>
                                        <tbody>
                                            <tr><input type="hidden" id="baseline_id" name="baseline_id" value="{{$claimBaselineSales->id}}" >
                                                <td><input type="checkbox" id="baseline_tick" name="baseline_tick" value="Y" @if($claimBaselineSales->response == 'Y') checked @else @endif></td>
                                                <td>We hereby confirm that the approved project is Greenfiled  project as per clause 2.18 of the Scheme Guidelines, Accordingly Baseline Sales for FY 2019-20 is Nil.									
                                                </td>
                                                <td>(₹)<input type="number" id='baseline_zero' name="baseline_amount" value="{{$claimBaselineSales->amount}}" class="form-control form-control-sm add_zero" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-primary">
                    @foreach ($claimUserResponse as $q)
                    @if ($q->ques_id == 4)
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.6 Please confirm whether there is any in house consumption, claimed for incentive as per clause 14.4 (d) of the Scheme Guidelines.
                                        </th>
                                        <input type="hidden" name="ques[4]" value="4">
                                        <td colspan="2" class="text-center">
                                            <select id="problem17" name="value[4]" class="form-control form-control-sm text-center">
                                                <option value="Y"
                                                    @if ($q->response == 'Y') selected  @else @endif>Yes
                                                </option>
                                                <option value="N"
                                                    @if ($q->response == 'N') selected  @else @endif>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                        <div class="card border-primary display17 m-2 py-10" style="@if ($q->response == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field17">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">Details of the product in which same were utilised</th>
                                            <th class="text-center">Quantity of Eligible Product Utilised (kg) </th>
                                            <th class="text-center">Cost of Production(Rs.)</th>
                                            <th class="text-center">Upload</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <input type="hidden" value="@if($claimSalesConsumption){{$claimSalesConsumption->id}} @endif" class="form-control form-control-sm" name="quamtity_ep_id">
                                        <td><input type="text" @if($claimSalesConsumption) value="{{$claimSalesConsumption->product_name_utilised}}" @endif class="form-control form-control-sm" name="product_utilised_name">
                                        <td><input type="number" @if($claimSalesConsumption) value="{{$claimSalesConsumption->quantity_of_ep}}" @endif class="form-control form-control-sm" name="quantity_of_ep"></td>
                                        <td><input type="number" @if($claimSalesConsumption) value="{{$claimSalesConsumption->cost_production}}" @endif class="form-control form-control-sm" name="cost_production"></td>
                                        <td class="text-center"><input type="file" name="SalesConsumption[0][doc]"  id="SalesConsumption[0][doc]" class="form-control form-control-sm name_list1">
                                        </td>
                                       
                                        @foreach ($claimSalesDoc as $saleDoc)
                                        @if ($saleDoc->doc_id == 1032)
                                            <td class="text-center p-2 ">
                                            <input type="hidden" @if($claimSalesConsumption) value="{{$saleDoc->id}}"@endif class="form-control form-control-sm" name="consumption_doc_id">
                                            <a class="mt-2 btn-sm btn-primary" href="{{ route('doc.down', $saleDoc->upload_id) }}">View</a> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                   
                    @if ($q->ques_id == 5)
                   
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.7 Please confirm whether there is  any
                                            unsettled claim, discount, rebate, etc. which has not been adjusted from
                                            sales.</th>
                                        <input type="hidden" name="ques[5]" value="5">
                                        <td colspan="2" class="text-center">
                                            <select id="problem3" name="value[5]"
                                                class="form-control form-control-sm text-center">
                                                <option value="Y"
                                                    @if ($q->response == 'Y') selected  @else @endif>Yes
                                                </option>
                                                <option value="N"
                                                    @if ($q->response == 'N') selected  @else @endif>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display3 m-2 py-10"
                            style="@if ($q->response == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field3">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file" name="unsettled[0][doc]"
                                                id="unsettled[0][doc]"
                                                class="form-control form-control-sm name_list1">
                                        </td>
                                        @foreach ($claimSalesDoc as $saleDoc)
                                        @if ($saleDoc->doc_id == 201)  
                                            <input type="hidden" name="unsettled[0][upload_id]" value="{{$saleDoc->upload_id}}">      
                                            <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href="{{ route('doc.down', $saleDoc->upload_id) }}">View</a> 
                                            </td>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                   
                    @endif
                    @if ($q->ques_id == 6)
                   
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                            <th colspan="3" class="text-left">2.8 Please confirm whether sales is net of credit notes (raised for any purpose), discounts (including but not limited to cash, volume, turnover,<br>target or any other purpose) and taxes applicable(Refer clause 2.24 of the scheme Guidelines).</th>
                                            <input type="hidden" name="ques[6]" value="6">
                                            <td colspan="2" class="text-center">
                                                <select id="problem4" name="value[6]"
                                                    class="form-control form-control-sm text-center">
                                                    <option value="Y"
                                                        @if ($q->response == 'Y') selected  @else @endif>Yes
                                                    </option>
                                                    <option value="N"
                                                        @if ($q->response == 'N') selected  @else @endif>No
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                        
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display4 m-2 py-10"
                            style="@if ($q->response == 'N') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field4">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <td class="text-center">1</td>
                                            <td class="text-center"><input type="file"
                                                    name="creditnotes[0][doc]" id="creditnotes[0][doc]"
                                                    class="form-control form-control-sm name_list1">
                                            </td>
                                            @foreach ($claimSalesDoc as $saleDoc)
                                            @if ($saleDoc->doc_id == 202)   
                                            <input type="hidden" name="creditnotes[0][upload_id]" value="{{$saleDoc->upload_id}}"> 
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href="{{ route('doc.down', $saleDoc->upload_id) }}">View</a> 
                                                </td>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    @endif
                    @if ($q->ques_id == 7)
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.9 All adjustments related to sales
                                            consideration have been adjusted from the sales and no such item has
                                            been
                                            accounted
                                            for as expense.</th>
                                        <input type="hidden" name="ques[7]" value="7">
                                        <td colspan="2" class="text-center">
                                            <select id="problem5" name="value[7]"
                                                class="form-control form-control-sm text-center">
                                                <option value="Y"
                                                    @if ($q->response == 'Y') selected  @else @endif>Yes
                                                </option>
                                                <option value="N"
                                                    @if ($q->response == 'N') selected  @else @endif>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>  
                                </thead>
                            </table>
                        </div>
                    
                        <div class="card border-primary display5 m-2 py-10"
                            style="@if ($q->response == 'N') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field5">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file"
                                            name="salesconsideration[0][doc]"
                                            id="salesconsideration[0][doc]"
                                            class="form-control form-control-sm name_list1"></td>
                                        @foreach ($claimSalesDoc as $key=>$saleDoc)
                                            @if ($saleDoc->doc_id == 203)
                                            
                                            <input type="hidden" name="salesconsideration[0][upload_id]" value="{{$saleDoc->upload_id}}">
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href="{{ route('doc.down', $saleDoc->upload_id) }}">View</a>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                        
                    @if ($q->ques_id == 8)
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.10 Please confirm if the company has entered into any contract agreement for manufacturing Eligible Products.If yes provide copy of agreement</th>
                                        <input type="hidden" name="ques[8]" value="8">
                                        <td colspan="2" class="text-center">
                                            <select id="problem6" name="value[8]"
                                                class="form-control form-control-sm text-center">
                                                <option value="Y"
                                                    @if ($q->response == 'Y') selected  @else @endif>Yes
                                                </option>
                                                <option value="N"
                                                    @if ($q->response == 'N') selected  @else @endif>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                </thead>
                            </table>
                        </div>
                        
                        <div class="card border-primary display6 m-2 py-10"
                            style="@if ($q->response == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field6">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                            <th class="text-center" style="text-decoration:none"><button type="button"
                                                    name="add6" id="add6" class="btn btn-success">Add
                                                    More</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        @if ($q->response == 'Y')
                                        @foreach ($claimSalesContractAgreement as $key=> $contractAgreement)
                                        <tr>
                                            <td class="text-center">{{$key+1}}</td>
                                            <td class="text-center"><input type="file"
                                                name="contractagreement[0][doc_upload]"
                                                id="contractagreement[0][doc_upload]"
                                                class="form-control form-control-sm name_list1"></td>
                                            <input type="hidden" name="contractagreement[0][upload_id]" value="{{$contractAgreement->upload_id}}">
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href="{{ route('doc.down', $contractAgreement->upload_id ) }}">View</a></td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center"><input type="file"
                                                name="contractagreement[0][doc_upload]"
                                                id="contractagreement[0][doc_upload]"
                                                class="form-control form-control-sm name_list1"></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @endforeach
                    </div>
                </div>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-2 offset-md-0">
            <a href="{{ route('claimsapplicantdetail.edit', $claimMaster->id) }}"
                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                    class="fa  fa-backward"></i> Applicant Detail</a>
        </div>
        <div class="col-md-2 offset-md-3">
            <button type="submit" id="sales_data" class="btn btn-primary btn-sm form-control form-control-sm" onclick="return myfunction()"><i
                    class="fas fa-save" ></i> Save as Draft</button>
        </div>
        <div class="col-md-2 offset-md-3">
            <a href="{{ route('claimsalesdetail.claimsalesdva',$claimMaster->id) }}"
                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"> DVA<i
                    class="fa  fa-forward"></i></a>
        </div>
    </div>
    </form>
@endsection

@push('scripts')
    @push('scripts')
        <script>
            
            $(document).ready(function() {
                var i = 1;
                var j = 0;
                var sn = 2;
                $('#add12').click(function() {
                    i++;
                    j++;
                    console.log(j);
                    $('#dynamic_field12').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td><td class="text-center">Eligible Product 1</td><td><input type="number" name="ts_dom_qnty" id="ts_dom_qnty"  onkeyup="breakupsum()" value="" class="form-control form-control-sm"></td>  <td class="text-center"><input type="number " name="ts_dom_qnty" id="ts_dom_qnty" onkeyup="breakupsum()" value="" class="form-control form-control-sm"></td><td class="text-center"><input type="text" name="ts_dom_sales" id="ts_dom_sales"onkeyup="breakupsum()" value=""class="form-control form-control-sm"></td> <td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove12">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove12', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });

            $(document).ready(function() {
                var i = 1;
                var j = {{sizeOf($claimSalesManufTsGoods)}};
                var sn = j+1;
                $('#add').click(function() {
                    i++;
                    j++;
                    $('#dynamic_field').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td> <input type="hidden" name="ts_goods['+ j +'][name_of_product]"  value="@if(count($claimSalesManufTsGoods)>0){{$claimSalesManufTsGoods[0]->product_name}} @endif" class="form-control form-control-sm name_list1"><td><input type="text" name="ts_goods[' + j +
                        '][name_of_related_party]" value=""  class="form-control form-control-sm name_list1"></td><td><input type="text" name="ts_goods[' +
                        j +
                        '][relationship]"  class="form-control name_list" /></td><td><input type="number" name="ts_goods[' + j +'][ts_sales]"  class="form-control name_list add_ts_sales" /></td><td><input type="number" name="ts_goods[' + j +'][ep_sales]"  class="form-control name_list ts_goods_sum" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });


            $(document).ready(function() {
                var i = 1;
                var j = {{sizeOf($claimRecSales)}};
                var sn = 2;
                $('#add2').click(function() {
                    i++;
                    j++;
                    $('#dynamic_field2').append('<tr id="row' + i + '"><input type="hidden" name="breakup[' + j +'][particular]" value='+ j +' class="form-control name_list" /><td><input type="text" name="breakup[' +j +'][particular_name]"  class="form-control name_list" /></td><td colspan="2"><input type="text" name="breakup['+ j +'][amount]" id="brkp_amnt'+ i +'" class="form-control name_list rec_tot" /></td><td class="text-center"><button type="button" name="remove" id="'+ i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');  
                });
                
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    var sum = 0;
                    $(".rec_tot").each(function() {
                        sum += +$(this).val();
                    });
                    $(".rec_tot_total").val(sum);

                    $('#row' + button_id + '').remove();
                });
            });


            $(document).ready(function() {
                var i = 1;
                var j = 0;
                var sn = 2;
                $('#add3').click(function() {
                    i++;
                    j++;
                    console.log(j);
                    $('#dynamic_field3').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td><td><input type="file" name="unsettled[' +
                        j +
                        '][upload]"  class="form-control name_list" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });


            $(document).ready(function() {
                var i = 1;
                var j = 0;
                var sn = 2;
                $('#add4').click(function() {
                    i++;
                    j++;
                    console.log(j);
                    $('#dynamic_field4').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td><td><input type="text" name="creditnotes[' + j +
                        '][remark]"  class="form-control name_list" /></td><td><input type="text" name="creditnotes[' +
                        j +
                        '][amount]"  class="form-control name_list" /></td><td><input type="file" name="creditnotes[' +
                        j +
                        '][upload]"  class="form-control name_list" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });


            $(document).ready(function() {
                $('#problem17').on('change', function() {
                    $('.display17').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display17').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                var i = 1;
                var j = 0;
                var sn = 2;
                $('#add5').click(function() {
                    i++;
                    j++;
                    console.log(j);
                    $('#dynamic_field5').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td><td><input type="text" name="salesconsideration[' + j +
                        '][remark]"  class="form-control name_list" /></td><td><input type="text" name="salesconsideration[' +
                        j +
                        '][amount]"  class="form-control name_list" /></td><td><input type="file" name="salesconsideration[' +
                        j +
                        '][upload]"  class="form-control name_list" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });


            $(document).ready(function() {
                var i = 1;
                var j = {{sizeOf($claimSalesContractAgreement)}};
                var sn = j+1;
                $('#add6').click(function() {
                    i++;
                    j++;
                   
                    $('#dynamic_field6').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                        '</td><td><input type="file" name="contractagreement[' +
                        j +
                        '][doc_upload]"  class="form-control name_list" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });
            
            $(document).on("keyup", ".add_incentive", function() {
                var sum = 0;
                $(".add_incentive").each(function() {
                    sum += +$(this).val();
                });
                $(".tot_add_incentive").val(sum);
          
            });

            $(document).on("keyup", ".ts_goods_sum", function() {
                var sum = 0;
                $(".ts_goods_sum").each(function() {
                    sum += +$(this).val();
                });
                $(".ts_goods_sum_total").val(sum);
          
            });

            $(document).on("keyup", ".rec_tot", function() {
                var sum = 0;
                $(".rec_tot").each(function() {
                    sum += +$(this).val();
                });
                $(".rec_tot_total").val(sum);
          
            });
       

            $(document).ready(function() {
                $('#ts_goods[0][rp_name]').on('change', function() {
                    $('.display').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });
            $(document).ready(function() {
                $('#problem').on('change', function() {
                    $('.display').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('#problem1').on('change', function() {
                    $('.display1').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display1').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('#problem2').on('change', function() {
                    $('.display2').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display2').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('#problem3').on('change', function() {
                    $('.display3').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display3').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });


            $(document).ready(function() {
                $('#problem4').on('change', function() {

                    $('.display4').show();
                    if (this.value.trim()) {
                        if (this.value !== 'N') {
                            $('.display4').hide();
                        } else if (this.value !== 'Y') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('#problem5').on('change', function() {
                    $('.display5').show();
                    if (this.value.trim()) {
                        if (this.value !== 'N') {
                            $('.display5').hide();
                        } else if (this.value !== 'Y') {
                            $('.display_1').hide();
                        }
                    }
                });
            });


            $(document).ready(function() {
                $('#problem6').on('change', function() {
                    $('.display6').show();
                    if (this.value.trim()) {
                        if (this.value !== 'Y') {
                            $('.display6').hide();
                        } else if (this.value !== 'N') {
                            $('.display_1').hide();
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('.breakup_select').on('change', function() {
                    console.log(this.value);
                    console.log(this.nextElementSibling);

                    if (this.value == 13) {
                        this.nextElementSibling.style.display = "block";
                    } else {
                        this.nextElementSibling.style.display = "none";
                    }
                });
            });


            $(document).ready(function() {
                $('.tsGoods_select').on('change', function() {
                    console.log(this.value);
                    console.log(this.nextElementSibling);

                    if (this.value == 7) {
                        this.nextElementSibling.style.display = "block";
                    } else {
                        this.nextElementSibling.style.display = "none";
                    }
                });
            });
            
            $(document).on("keyup", ".add_ts_sales", function() {
                var sum = 0;
                $(".add_ts_sales").each(function() {
                    sum += +$(this).val();
                });
                $(".tot_add_ts_sales").val(sum);

            });
            $(document).ready(function() {
               
               $('#baseline_tick').on('click', function() {
                   check = $("#baseline_tick").is(":checked");
                  
                   if(check){
                       $('.add_zero').val(0);
                   }
                   else{
                       $('.add_zero').val('');
                   }
                  
               });
           });

            function breakupsum() {
                var dom_qnty = parseFloat(document.getElementById('dom_qnty').value);
                var exp_qnty = parseFloat(document.getElementById('exp_qnty').value);
                var cons_qnty = parseFloat(document.getElementById('cons_qnty').value);
                document.getElementById('ts_total_qnty').value = dom_qnty + exp_qnty + cons_qnty;
                document.getElementById('new_qrr_dom_qnty').value = dom_qnty;
                document.getElementById('new_qrr_exp_qnty').value = exp_qnty;
                document.getElementById('new_qrr_cons_qnty').value = cons_qnty;
               

                var dom_sales = parseFloat(document.getElementById('dom_sales').value);
                var exp_sales = parseFloat(document.getElementById('exp_sales').value);
                var cons_sales = parseFloat(document.getElementById('cons_sales').value);
                document.getElementById('ts_total_sales').value = dom_sales + exp_sales + cons_sales;
                document.getElementById('new_qrr_dom_sales').value = dom_sales ;
                document.getElementById('new_qrr_exp_sales').value =  exp_sales ;
                document.getElementById('new_qrr_cons_sales').value =  cons_sales;

                var old_qnty = parseFloat(document.getElementById('old_qrr_dom_qnty').value);
                document.getElementById('diff_dom_qnty').value = old_qnty - dom_qnty;

                var old_amt = parseFloat(document.getElementById('old_qrr_dom_sales').value);
                document.getElementById('diff_dom_sales').value = old_amt - dom_sales;

                var old_exp_qnty = parseFloat(document.getElementById('old_qrr_exp_qnty').value);
                document.getElementById('diff_exp_qnty').value = old_exp_qnty - exp_qnty;

                var old_exp_amt = parseFloat(document.getElementById('old_qrr_exp_sales').value);
                document.getElementById('diff_exp_sales').value = old_exp_amt - exp_sales;

                var old_cons_qnty = parseFloat(document.getElementById('old_qrr_cons_qnty').value);
                document.getElementById('diff_cons_qnty').value = old_cons_qnty - cons_qnty;

                var old_cons_amt = parseFloat(document.getElementById('old_qrr_cons_sales').value);
                document.getElementById('diff_cons_sales').value = old_cons_amt - cons_sales;

                var t_total_income = parseFloat(document.getElementById('total_income').value);
                var t_sales_less = parseFloat(document.getElementById('ts_sales_less').value);
                document.getElementById('ts_pertaining_income').value = t_total_income - t_sales_less;

            }

            function myfunction()
            {
               
                var ts_pertaining_income=parseFloat(document.getElementById('ts_pertaining_income').value);
                var grand_total=parseFloat(document.getElementById('grand_total').value);
                if(ts_pertaining_income!=grand_total)
                {
                    alert('Please match the data 2.4 Question');
                    document.getElementById("ts_pertaining_income").focus();
                    return false;
                }
                return true;
            }
            $(document).ready(function () {
                $('.prevent-multiple-submit').on('submit', function() {
                    const btn = document.getElementById("sales_data");
                    btn.disabled = true;
                    setTimeout(function(){btn.disabled = false;}, (1000*20));
                });
            });
        </script>
        @push('scripts')
            {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimSalesRequestEdit', '#sales_form') !!}
        @endpush
    @endpush
