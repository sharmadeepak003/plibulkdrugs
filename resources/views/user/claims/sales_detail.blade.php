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
            <form action="{{ route('claimsalesdetail.store') }}" id="application-create" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <div class="card border-info">
                    <div class="card-header bg-gradient-info">
                        <div class="row">
                            <div class="col-md-12 text-bold">
                                2.1 Sales of eligible products as per approval letter on which incentive is being claimed
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="exmple" class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Name of Eligible Product</th>
                                                <td class="text-center">{{ $product->product }}
                                                    <input type="hidden" name="ep_approval_data[1][name_of_product]"
                                                        value="{{ $product->product }}"
                                                        class="form-control form-control-sm">
                                                </td>
                                                <th rowspan="3" class="text-center">Quantity(in MT)</th>
                                                <th rowspan="3" class="text-center">Actual Sales Amount(₹)</th>
                                                <th rowspan="3" class="text-center">Sales considered for Incentive (Lower of Actual selling price and Quoted Sales Price) (₹)
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Quoted Sales Price(₹)</th>
                                                <td><input type="number" name="ep_approval_data[1][quoted_sales_price]" id="quoted_sales_price" value="" class="form-control form-control-sm"></td>
                                            </tr>
                                            
                                            <tr>
                                                <th>HSN Code</th>
                                                <td><input type="text" name="ep_approval_data[1][hsn]" id="hsn" value="{{$hsn->hsn}}" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">Domestic Sales</td>
                                                <td><input type="number" name="ep_approval_data[1][dom_qnty]"
                                                        id="dom_qnty" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][dom_sales]"
                                                        id="dom_sales" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][dom_incentive]" id="dom_incentive" onkeyup="breakupsum()" value="" class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Export Sales</td>
                                                <td><input type="number" name="ep_approval_data[1][exp_qnty]"
                                                        id="exp_qnty" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td> <input type="number" name="ep_approval_data[1][exp_sales]"
                                                        id="exp_sales" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][exp_incentive]"
                                                        id="exp_incentive" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">In-House Consumption</td>
                                                <td> <input type="number" name="ep_approval_data[1][cons_qnty]"
                                                        id="cons_qnty" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td> <input type="number" name="ep_approval_data[1][cons_sales]"
                                                        id="cons_sales" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm"></td>
                                                <td><input type="number" name="ep_approval_data[1][cons_incentive]"
                                                        id="cons_incentive" onkeyup="breakupsum()" value=""
                                                        class="form-control form-control-sm add_incentive"></td>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <td><input type="number" name="ep_approval_data[1][ts_total_qnty]"
                                                        id="ts_total_qnty" value=""
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_approval_data[1][ts_total_sales]"
                                                        id="ts_total_sales" value=""
                                                        class="form-control form-control-sm" readonly></td>
                                                <td><input type="number" name="ep_approval_data[1][ts_total_considerd]"
                                                    id="ts_total_considerd" value=""
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

                                    <table id="dynamic_field12"
                                        class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="table-primary">
                                              
                                                <th rowspan="2" class="text-center">Name Of Eligible Product</th>
                                                <th rowspan="1" colspan="2" class="text-center">Sales as per QRR</th>
                                                <th rowspan="1" colspan="2" class="text-center">Sales for Incentive Claim</th>
                                                <th rowspan="1" colspan="2" class="text-center">Difference</th>
                                                <th rowspan="2">Reasons for difference(Note:If Difference is zero then fill NA)</th>
                                            </tr>
                                            <tr>
                                                <th>Quantity(MT)</th>
                                                <th>Amount(₹)</th>
                                                <th>Quantity(MT)</th>
                                                <th>Amount(₹)</th>
                                                <th>Differnce Quantity(MT)</th>
                                                <th>Differnce Amount(₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                               
                                                <td>Domestic Sales</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_dom_qnty]" onkeyup="breakupsum()"
                                                        id="old_dom_qnty" @if($qrr_data) value="{{ round($qrr_data->dom_qnty,2) }}" @else value="0.0" @endif
                                                        class="form-control form-control-sm qrr_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_dom_sales]" onkeyup="breakupsum()"
                                                        id="old_dom_sales" @if($qrr_data) value="{{ $qrr_data->dom_sales }}"  @else value="0.0" @endif onkeyup="breakupsum()"
                                                        class="form-control form-control-sm qrr_amt" readonly></td>
                                                       </td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_dom_qnty]" onkeyup="breakupsum()"
                                                        id="new_dom_qnty" value="" class="form-control form-control-sm new_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_dom_sales]" onkeyup="breakupsum()"
                                                        id="new_dom_sales" value="" class="form-control form-control-sm new_sales" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_dom_qnty]" onkeyup="breakupsum()"
                                                        id="diff_dom_qnty" value="" class="form-control form-control-sm diff_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_dom_amount]" onkeyup="breakupsum()"
                                                        id="diff_dom_sales" value="" class="form-control form-control-sm diff_sales" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][dom_reason_diff]"   id="dom_reason_diff" value="" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                               
                                                <td>Export Sales</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_exp_qnty]"
                                                        id="old_qrr_exp_qnty" @if($qrr_data) value="{{ round($qrr_data->exp_qnty,2) }}"  @else value="0.0" @endif
                                                        class="form-control form-control-sm qrr_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_exp_sales]"
                                                        id="old_qrr_exp_sales" @if($qrr_data) value="{{ $qrr_data->exp_sales }}"  @else value="0.0" @endif
                                                        class="form-control form-control-sm old_qrr_exp_sales " readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_exp_qnty]"
                                                        id="new_exp_qnty" value=""
                                                        class="form-control form-control-sm new_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_exp_sales]"
                                                        id="new_exp_sales" value=""
                                                        class="form-control form-control-sm new_sales" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_exp_qnty]" id="diff_exp_qnty" value=""
                                                            class="form-control form-control-sm diff_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_exp_sales]"  id="diff_exp_sales" value=""
                                                            class="form-control form-control-sm diff_sales" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][exp_reason_diff]"
                                                        id="exp_reason_diff" value=""
                                                        class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                               
                                                <td>In-house Consumption</td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_cons_qnty]"
                                                        id="old_qrr_cons_qnty" @if($qrr_data) value="{{ round($qrr_data->cons_qnty,2) }}"  @else value="0.0" @endif
                                                        class="form-control form-control-sm qrr_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][old_qrr_cons_sales]"
                                                        id="old_qrr_cons_sales" @if($qrr_data) value="{{ $qrr_data->cons_sales }}"  @else value="0.0" @endif
                                                        class="form-control form-control-sm qrr_amt" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_cons_qnty]"
                                                        id="new_cons_qnty" value=""
                                                        class="form-control form-control-sm new_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][new_qrr_cons_sales]"
                                                        id="new_cons_sales" value=""
                                                        class="form-control form-control-sm new_sales" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_cons_qnty]"
                                                            id="diff_cons_qnty" value=""
                                                            class="form-control form-control-sm diff_qnty" readonly></td>
                                                <td><input type="number" name="ep_qrr_data[1][diff_cons_sales]"
                                                            id="diff_cons_sales" value=""
                                                            class="form-control form-control-sm diff_sales" readonly></td>
                                                <td><input type="text" name="ep_qrr_data[1][cons_reason_diff]"
                                                        id="cons_reason_diff" value=""
                                                        class="form-control form-control-sm"></td>
                                            </tr>
                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th class="text-center">Total</th>
                                                <th><input type="number" name="" 
                                                    id="qrr_tot_qnty" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th><input type="number" name="" 
                                                    id="qrr_tot_amt" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th><input type="number" name="" 
                                                    id="incentive_tot_qnty" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th><input type="number" name="" 
                                                    id="incentive_tot_amt" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th><input type="number" name="" 
                                                    id="diff_tot_qnty" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th><input type="number" name="" 
                                                    id="diff_tot_sales" value=""
                                                    class="form-control form-control-sm" readonly></th>
                                                <th></th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr style="background:white;">
                                        <th col="9" class="text-left">2.3 Whether there is any sales of
                                            manufactured eligible product to related party as defined under clause 2.29 of scheme guidelines</th>
                                        <input type="hidden" name="ques[3]" value="3">
                                        <td col="3" class="text-center">
                                            <select id="problem" name="value[3]"
                                                class="form-control form-control-sm text-center">
                                                <option disabled selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display m-2 py-10" style="display:none;">
                            @foreach ($eligible_product as $key => $product)
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead class="">
                                            <tr>
                                                <th>{{ $product->product }}</th>
                                                <input type="hidden"
                                                    name="ts_goods[{{ $key }}][name_of_product]"
                                                    value="{{ $product->product }}"
                                                    class="form-control form-control-sm name_list1">
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
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <input type="text"
                                                        name="ts_goods[{{ $key }}][name_of_related_party]"
                                                        value="" class="form-control form-control-sm name_list1 ">
                                                </td>
                                                <td class="text-center"><input type="text" name="ts_goods[{{ $key }}][relationship]" value=""
                                                        class="form-control form-control-sm name_list1 "></td>
                                                <td class="text-center"><input type="number" name="ts_goods[{{ $key }}][ts_sales]" value=""
                                                        class="form-control form-control-sm name_list1 add_ts_sales">
                                                </td>
                                                <td class="text-center"><input type="number" name="ts_goods[{{ $key }}][ep_sales]"
                                                        onkeyup="breakupsum()" value="" id="ts_goods_tot_amt"
                                                        class="form-control form-control-sm name_list1 ts_goods_sum">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-center" colspan="2">
                                                    Total
                                                </td>
                                                <td class="text-center"><input type="text" name="total_goods_qnty"
                                                    id="total_goods_qnty"
                                                    class="form-control form-control-sm name_list1 tot_add_ts_sales"
                                                    readonly>
                                                </td>
                                                <td class="text-center"><input type="text" name="total_goods_amt"
                                                        id="ts_goods_tot"
                                                        class="form-control form-control-sm name_list1 ts_goods_sum_total"
                                                        readonly>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    {{-- <table class="table table-sm table-bordered table-hover">
                                        <tbody>
                                           
                                        </tbody>
                                    </table> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
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
                                            <tr>
                                                <td>Total Income as per Financial Statements (A)</td>
                                                <input type="hidden" name="part_name_0[0]" value="Total Income as per Financial Statements (A)">
                                                <input type="hidden" name="part_0[0]" value="1">
                                                <td colspan="2">
                                                    <input type="text" name="amount_0[0]" id="total_income"
                                                        value="" class="form-control form-control-sm "
                                                        onkeyup="breakupsum()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sales of Eligible Product on which incentive has been claimed (B)
                                                </td>
                                                <input type="hidden" name="part_name_0[1]" value="Sales of Eligible Product on which incentive has been claimed (B)">
                                                <input type="hidden" name="part_0[1]" value="2">
                                                <td colspan="2">
                                                    <input type="number" name="amount_0[1]" id="ts_sales_less"
                                                        value="" class="form-control form-control-sm"
                                                        onkeyup="breakupsum()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Income not pertaining to Greenfield Project(A-B)</td>
                                                <input type="hidden" name="part_name_0[2]" value="Income not pertaining to Greenfield Project(A-B)">
                                                <input type="hidden" name="part_0[2]" value="3">
                                                <td colspan="2">
                                                    <input type="number" name="amount_0[2]" id="ts_pertaining_income"
                                                        value="" class="form-control form-control-sm "
                                                        readonly>
                                                </td>
                                            </tr>
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
                                            @foreach ($claimSalesParticular as $key => $particular)
                                                @if ($claimSalesParticular[$key]->section == 2)
                                                    <tr>
                                                        <td>
                                                            {{ $particular->particular }}
                                                            @if($particular->id != 9) 
                                                                <input type="hidden"
                                                                name="breakup[{{ $key }}][particular_name]"
                                                                id="breakup[{{ $key }}][particular]"
                                                                value="{{ $particular->particular }}"
                                                                class="form-control form-control-sm">
                                                            @endif
                                                                <input type="hidden"
                                                                name="breakup[{{ $key }}][particular]"
                                                                id="breakup[{{ $key }}][particular]"
                                                                value="{{ $particular->id }}"
                                                                class="form-control form-control-sm">
                                                            @if($particular->id == 9) 
                                                                <input type="text"
                                                                name="breakup[{{ $key }}][particular_name]"
                                                                id="breakup[{{ $key }}][particular]" value=""
                                                                class="form-control form-control-sm ">
                                                            @endif
                                                        </td>
                                                        
                                                        <td colspan="2">
                                                            <input type="number"
                                                                name="breakup[{{ $key }}][amount]"
                                                                id="breakup[{{ $key }}][amount]" value=""
                                                                class="form-control form-control-sm rec_tot">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-center" style="padding-right: 250px">Grand
                                                    Total</th>
                                                <td><input type="text" name="grand_total" id="grand_total"
                                                        class="form-control form-control-sm name_list1 rec_tot_total"
                                                        readonly></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    {{-- <table class="table table-sm table-bordered table-hover">
                                        <tbody>
                                            
                                        </tbody>
                                    </table> --}}
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
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" id="baseline_tick" name="baseline_tick"
                                                    value="Y"></td>
                                            <td>We hereby confirm that the approved project is Greenfiled project as per
                                                clause 2.18 of the Scheme Guidelines, Accordingly Baseline Sales for FY
                                                2019-20 is Nil.
                                            </td>
                                            <td>(₹)<input type="number" id='baseline_zero' value="" name="baseline_amount" class="form-control form-control-sm add_zero" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-primary">
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover ">
                            <thead>
                                <tr style="background:white;">
                                    <th colspan="3" class="text-left">2.6 Please confirm whether there is any in house consumption, claimed for incentive as per clause 14.4 (d) of the Scheme Guidelines.
                                    </th>
                                    <input type="hidden" name="ques[4]" value="4">
                                    <td colspan="2" class="text-center">
                                        <select id="problem17" name="value[4]"
                                            class="form-control form-control-sm text-center">
                                            <option disabled selected>Select</option>
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="card border-primary display17 m-2 py-10" style="display:none;">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" id="dynamic_field17">
                                <thead class="bg-gradient-info">
                                    <tr>
                                        <th class="text-center">Details of the product in which same were utilised</th>
                                        <th class="text-center">Quantity of Eligible Product Utilised (kg) </th>
                                        <th class="text-center">Cost of Production(Rs.)</th>
                                        <th class="text-center">Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <th class="text-center"><input type="text" value="" class="form-control form-control-sm" name="product_utilised_name"></th>
                                    <td><input type="number" value="" class="form-control form-control-sm" name="quantity_of_ep"></td>
                                    <td><input type="number" value="" class="form-control form-control-sm" name="cost_production"></td>
                                    <td class="text-center"><input type="file" name="SalesConsumption[0][upload]"  id="[0][upload]" class="form-control form-control-sm name_list1">
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.7 Please confirm whether there is any
                                            unsettled
                                            claim, discount, rebate, etc. which has not been adjusted from sales.</th>
                                        <input type="hidden" name="ques[5]" value="5">
                                        <td colspan="2" class="text-center">
                                            <select id="problem3" name="value[5]"
                                                class="form-control form-control-sm text-center">
                                                <option disabled selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display3 m-2 py-10" style="display:none;">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field3">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file" name="unsettled[0][upload]"
                                                id="unsettled[0][upload]" class="form-control form-control-sm name_list1">
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.8 Please confirm whether sales is net of credit notes (raised for any purpose), discounts (including but not limited to cash, volume, turnover,<br> target or any other purpose) and taxes applicable.(Refer clause 2.24 of the scheme Guidelines)
                                        </th>
                                        <input type="hidden" name="ques[6]" value="6">
                                        <td colspan="2" class="text-center">
                                            <select id="problem4" name="value[6]"
                                                class="form-control form-control-sm text-center">
                                                <option disabled selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display4 m-2 py-10" style="display:none;">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field4">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file" name="creditnotes[0][upload]"
                                                id="creditnotes[0][upload]"
                                                class="form-control form-control-sm name_list1">
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.9 All adjustments related to sales consideration have been adjusted from the sales and no such item has been accounted for as expense.</th>
                                        <input type="hidden" name="ques[7]" value="7">
                                        <td colspan="2" class="text-center">
                                            <select id="problem5" name="value[7]"
                                                class="form-control form-control-sm text-center">
                                                <option disabled selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display5 m-2 py-10" style="display:none;">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="dynamic_field5">
                                    <thead class="bg-gradient-info">
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file"
                                                name="salesconsideration[0][upload]" id="salesconsideration[0][upload]"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr style="background:white;">
                                        <th colspan="3" class="text-left">2.10 Please confirm if the company has entered into any contract agreement for manufacturing Eligible Products.If yes, provide copy of agreement.</th>
                                        <input type="hidden" name="ques[8]" value="8">
                                        <td colspan="2" class="text-center">
                                            <select id="problem6" name="value[8]"
                                                class="form-control form-control-sm text-center">
                                                <option disabled selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display6 m-2 py-10" style="display:none;">
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
                                        <td class="text-center">1</td>
                                        <td class="text-center"><input type="file"
                                                name="contractagreement[0][doc_upload]"
                                                id="contractagreement[0][doc_upload]"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
 
    <div class="row py-2">
        <div class="col-md-2 offset-md-0">
            <a href="{{ route('claims.claimsapplicantdetail',$claimMaster->id) }}"
                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                    class="fa  fa-backward"></i> Applicant Detail</a>
        </div>
        <div class="col-md-2 offset-md-3">
            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" onclick="return myfunction()"><i
                    class="fas fa-save" id="sales_data"></i> Save as Draft</button>
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
                    '</td><td class="text-center">Eligible Product 1</td><td><input type="text" name="ts_dom_qnty" id="ts_dom_qnty"  onkeyup="breakupsum()" value="" class="form-control form-control-sm"></td>  <td class="text-center"><input type="text" name="ts_dom_qnty" id="ts_dom_qnty" onkeyup="breakupsum()" value="" class="form-control form-control-sm"></td><td class="text-center"><input type="text" name="ts_dom_sales" id="ts_dom_sales"onkeyup="breakupsum()" value=""class="form-control form-control-sm"></td> <td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove12">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove12', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            var i = 1;
            var j = 0;
            var sn = 2;
            $('#add').click(function() {
                i++;
                j++;
                $('#dynamic_field').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                    '</td><input type="hidden" name="ts_goods[' + j +
                    '][name_of_product]" value="{{ $product->product }}"  class="form-control form-control-sm name_list1"><td><input type="text" name="ts_goods[' +
                    j +
                    '][name_of_related_party]" value=""  class="form-control form-control-sm name_list1"></td><td><input type="text" name="ts_goods[' +
                    j +
                    '][relationship]"  class="form-control name_list" /></td><td><input type="number" name="ts_goods[' +
                    j +
                    '][ts_sales]"  class="form-control name_list add_ts_sales" /></td><td><input type="number" name="ts_goods[' +
                    j +
                    '][ep_sales]"  class="form-control name_list ts_goods_sum" /></td><td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });


        $(document).ready(function() {
            var i = 1;
            var j = 9;
            var sn = 2;
            $('#add2').click(function() {
                i++;
                j++;
                
                $('#dynamic_field2').append('<tr id="row' + i + '"><input type="hidden" name="breakup[' + j +'][particular]" value='+ j +' class="form-control name_list" /><td ><input type="text" name="breakup[' + j + '][particular_name]"  class="form-control name_list" /></td><td colspan="2"><input type="text" name="breakup[' +
                    j +
                    '][amount]"  class="form-control name_list rec_tot" /></td><td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
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
                // console.log(j);
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

       
       

        $(document).on("keyup", ".ts_goods_sum", function() {
            var sum = 0;
            $(".ts_goods_sum").each(function() {
                sum += +$(this).val();
            });
            $(".ts_goods_sum_total").val(sum);

        });

        $(document).on("keyup", ".add_ts_sales", function() {
            var sum = 0;
            $(".add_ts_sales").each(function() {
                sum += +$(this).val();
            });
            $(".tot_add_ts_sales").val(sum);

        });

        $(document).on("keyup", ".rec_tot", function() {
            var sum = 0;
            $(".rec_tot").each(function() {
                sum += +$(this).val();
            });
            $(".rec_tot_total").val(sum);

        });

        $(document).ready(function() {
            var i = 1;
            var j = 0;
            var sn = 2;
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
            $('.breakup_select').on('change', function() {

                if (this.value == 13) {
                    this.nextElementSibling.style.display = "block";
                } else {
                    this.nextElementSibling.style.display = "none";
                }
            });
        });


        $(document).ready(function() {
            $('.tsGoods_select').on('change', function() {

                if (this.value == 7) {
                    this.nextElementSibling.style.display = "block";
                } else {
                    this.nextElementSibling.style.display = "none";
                }
            });
        });

        $(document).ready(function() {

            $('#baseline_tick').on('click', function() {
                check = $("#baseline_tick").is(":checked");
                if (check) {
                    $('.add_zero').val(0);
                } else {
                    $('.add_zero').val('');
                }

            });
        });

        $(document).on("keyup", ".add_incentive", function() {
            var sum = 0;
            $(".add_incentive").each(function() {
                sum += +$(this).val();
            });
            $(".tot_add_incentive").val(sum);
          
        });

        function breakupsum() {
        
            var dom_qnty = parseFloat(document.getElementById('dom_qnty').value);
            var exp_qnty = parseFloat(document.getElementById('exp_qnty').value);
            var cons_qnty = parseFloat(document.getElementById('cons_qnty').value);
            document.getElementById('ts_total_qnty').value = dom_qnty + exp_qnty + cons_qnty;
            document.getElementById('new_dom_qnty').value = dom_qnty;
            document.getElementById('new_exp_qnty').value = exp_qnty;
            document.getElementById('new_cons_qnty').value = cons_qnty;

            var dom_sales = parseFloat(document.getElementById('dom_sales').value);
            var exp_sales = parseFloat(document.getElementById('exp_sales').value);
            var cons_sales = parseFloat(document.getElementById('cons_sales').value);
            document.getElementById('ts_total_sales').value = dom_sales + exp_sales + cons_sales;
            document.getElementById('new_dom_sales').value = dom_sales ;
            document.getElementById('new_exp_sales').value =  exp_sales ;
            document.getElementById('new_cons_sales').value =  cons_sales;

            var old_qnty = parseFloat(document.getElementById('old_dom_qnty').value);
            document.getElementById('diff_dom_qnty').value = old_qnty - dom_qnty;

            var old_amt = parseFloat(document.getElementById('old_dom_sales').value);
            document.getElementById('diff_dom_sales').value = old_amt - dom_sales;

            var old_exp_qnty = parseFloat(document.getElementById('old_qrr_exp_qnty').value);
            document.getElementById('diff_exp_qnty').value = old_exp_qnty - exp_qnty;

            var old_exp_amt = parseFloat(document.getElementById('old_qrr_exp_sales').value);
            document.getElementById('diff_exp_sales').value = old_exp_amt - exp_sales;

            var old_cons_qnty = parseFloat(document.getElementById('old_qrr_cons_qnty').value);
            document.getElementById('diff_cons_qnty').value = old_cons_qnty - cons_qnty;

            var old_cons_amt = parseFloat(document.getElementById('old_qrr_cons_sales').value);
            document.getElementById('diff_cons_sales').value = old_cons_amt - cons_sales;


            var total_income = parseInt(document.getElementById('total_income').value);
            var ts_sales_less = parseInt(document.getElementById('ts_sales_less').value);
            document.getElementById('ts_pertaining_income').value = total_income - ts_sales_less;

        }

        function func_submt()
        {
           var ts_pertaining_income = parseFloat(document.getElementById('ts_pertaining_income').value);
           var grand_total = parseFloat(document.getElementById('grand_total').value);

            if(ts_pertaining_income==grand_total)
            {
                return true;
            }else{
                return false;
            } 
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
        {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimSalesRequest', '#application-create') !!}
    @endpush
@endpush
