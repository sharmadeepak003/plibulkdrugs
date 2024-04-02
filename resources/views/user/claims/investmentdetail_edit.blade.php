@extends('layouts.user.dashboard-master')

@section('title')
    Claim Dashboard -- Investment Summary
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container  py-4 px-2 col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('claiminvestmentdetail.update', '$apps->claim_id') }}" id="application-create"
                    role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                    enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="app_id" value="{{ $apps->app_id }}">
                    <input type="hidden" name="claim_id" value="{{ $apps->claim_id }}">
                    <div class="card border-primary">

                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center">Cumulative Committed Investment up to claim Period F.Y(₹)
                                        </th>
                                        <th class="text-center">Investment as per QRR(₹ in crore)</th>
                                        <th class="text-center">Actual Investment up to Claim Period (₹ in crore)</th>
                                        <th class="text-center">Difference (₹ in crore)</th>
                                        <th class="text-center">Reason(Note:If difference is zero then fill NA.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($claim_period as $key => $period)
                                        <tr>
                                            <input type="hidden" class="text-center form-control form-control-sm"
                                                value="{{ $period['id'] }}" name="claim_period[{{ $key }}][id]">
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    value="{{ $period['claim_period'] }}"
                                                    name="claim_period[{{ $key }}][period_fy]"></td>
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    id="investment_per_qrr" value="{{ $period['inv_as_qrr'] }}"
                                                    name="claim_period[{{ $key }}][investment_per_qrr]" readonly>
                                            </td>
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    onkeyup="emp_val(this.value)" value="{{ $period['actual_inv'] }}"
                                                    name="claim_period[{{ $key }}][actual_invest]"></td>
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    value="{{ $period['diff'] }}" name="claim_period[0][diff]"
                                                    id="period_diff" readonly></td>
                                            <td><input type="text" class="text-center form-control form-control-sm"
                                                    value="{{ $period['reason_change'] }}"
                                                    name="claim_period[{{ $key }}][reason_any_change]"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card border-primary mt-4">
                        <div class="card-header bg-gradient-info">
                            <b>4.1 Minimum Annual Production Capacity </b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.N</th>
                                        <th class="text-center">Name Of Product</th>
                                        {{-- <th class="text-center" >Minimum Annual Production Capacity proposed (MT) --}}
                                        <th class="text-center">Committed Capacity (MT)</th>
                                        {{-- <th class="text-center" >Minimum Annual Production Capacity Achieved (MT) --}}
                                        <th class="text-center">Installed Capcity (MT)
                                        </th>
                                        <th class="text-center">Date of commissioning(Clause 2.8 of Scheme Guidelines)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($capacity as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}
                                                <input type="hidden" class="text-center form-control form-control-sm"
                                                    value="{{ $product->id }}"
                                                    name="capacity_data[{{ $key }}][id]">
                                            </td>
                                            <td>{{ $product->product_name }}<input type="hidden"
                                                    class="text-center form-control form-control-sm"
                                                    value="{{ $product->product_name }}"
                                                    name="capacity_data[{{ $key }}][product_name]"></td>
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    value="{{ $product->capacity_proposed }}"
                                                    name="capacity_data[{{ $key }}][capacity_proposed]" readonly>
                                            </td>
                                            <td><input type="number" class="text-center form-control form-control-sm"
                                                    value="{{ $product->capacity_achieved }}"
                                                    name="capacity_data[{{ $key }}][capacity_achieved]">
                                            </td>

                                            <td><input type="date" class="text-center form-control form-control-sm"
                                                    value="{{ $product->date_of_commission }}"
                                                    name="capacity_data[{{ $key }}][date_of_commission]">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.2 Break-up of Investment</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" style="width: 100%"
                                id="dynamic_field13">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center" rowspan="2">S.No.</th>
                                        <th class="text-center" rowspan="2">Assets Type</th>
                                        <th class="text-center" colspan="2">Imported </th>
                                        <th class="text-center" colspan="2">Indigenous</th>
                                        <th class="text-center" colspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>
                                        <th class="text-center" style="text-decoration:none"><button type="button"
                                                name="add13" id="add13" class="btn btn-success">Add
                                                More</button>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $sumexp1 = 0;
                                        $sumexp2 = 0;
                                        $sumexp3 = 0;
                                        $sumexp4 = 0;
                                        $sumexp5 = 0;
                                        $sumexp6 = 0;
                                    @endphp
                                    {{-- {{dd($claim_brkp_inv)}} --}}
                                    @foreach ($claim_brkp_inv as $key => $breakup_inv)
                                        {{-- {{dd( $breakup_inv['gt_imp_party'])}} --}}

                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <input type="hidden" class="form-control form-control-sm"
                                                id="investment_data[id]" value="{{ $breakup_inv['id'] }}"
                                                name="investment_data[{{ $key }}][id]">
                                            <th class="text-center"><input type="text"
                                                    class="form-control form-control-sm" id=""
                                                    value="{{ $breakup_inv['asset_type'] }}"
                                                    name="investment_data[{{ $key }}][asset_type]"></th>
                                            <td><input type="text" class="form-control form-control-sm imprpnew text-right"
                                                    id="imprpnew{{ $key }}" onkeyup="breakupsum()"
                                                    value="{{ $breakup_inv['imp_party'] }}"
                                                    name="investment_data[{{ $key }}][imp_party]"></td>
                                            <td><input type="text" class="form-control form-control-sm impnrpnew text-right"
                                                    id="impnrpnew{{ $key }}"
                                                    name="investment_data[{{ $key }}][imp_not_party]"
                                                    value="{{ $breakup_inv['imp_not_party'] }}"></td>
                                            <td><input type="text" class="form-control form-control-sm indrpnew text-right"
                                                    id="indrpnew{{ $key }}"
                                                    name="investment_data[{{ $key }}][ind_party]"
                                                    onkeyup="breakupsum()" value="{{ $breakup_inv['ind_party'] }}"></td>
                                            <td><input type="text" class="form-control form-control-sm indnrpnew text-right"
                                                    id="indnrpnew{{ $key }}"
                                                    name="investment_data[{{ $key }}][ind_not_party]"
                                                    onkeyup="breakupsum()" value="{{ $breakup_inv['ind_not_party'] }}">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm totalrpnew newaddclass text-right"
                                                    id="totalrpnew{{ $key }}"
                                                    name="investment_data[{{ $key }}][tot_party]"
                                                    onkeyup="breakupsum()" value="{{ $breakup_inv['tot_party'] }}"
                                                    readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalnrpnew newclass text-right"
                                                    id="totalnrpnew{{ $key }}"
                                                    name="investment_data[{{ $key }}][tot_not_party]"
                                                    onkeyup="breakupsum()" value="{{ $breakup_inv['tot_not_party'] }}"
                                                    readonly></td>
                                            <td></td>
                                        </tr>

                                        @php
                                        $sumexp1 = $sumexp1 + $breakup_inv['imp_party'];
                                        $sumexp2 = $sumexp2 + $breakup_inv['imp_not_party'];
                                        $sumexp3 = $sumexp3 + $breakup_inv['ind_party'];
                                        $sumexp4 = $sumexp4 + $breakup_inv['ind_not_party'];
                                        $sumexp5 = $sumexp5 + $breakup_inv['tot_party'];
                                        // $sumexp5 = $gt_tot_party + $breakup_inv['gt_tot_party'];
                                        $sumexp6 = $sumexp6 + $breakup_inv['tot_not_party'];

                                         @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center" style="padding-right: 105px">Grand Total
                                        </th>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right imp_party_tot "
                                                id="gt1" name="gt_imp_party"
                                                value="{{ $sumexp1 }}" readonly></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right  impnrpnew_tot"
                                                id="gt2" name="gt_imp_not_party"
                                                value="{{ $sumexp2 }}" readonly></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right indrpnew_tot"
                                                id="gt3" name="gt_ind_party"
                                                value="{{ $sumexp3}}" readonly></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right indnrpnew_tot"
                                                id="gt1" name="gt_ind_not_party"
                                                value="{{  $sumexp4}}" readonly></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right totalrpnew_tot"
                                                id="gt2" name="gt_tot_party"
                                                value="{{$sumexp5}}" readonly></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm text-right totalnrpnew_tot"
                                                id="gt3" name="gt_tot_not_party"
                                                value="{{$sumexp6 }}" readonly></td>
                                        <td style="padding-left: 82px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.3 Break up of Investment as per Balance Sheet</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Opening balance (₹ in Crore)</th>
                                        <th class="text-center">Additions (₹ in Crore)</th>
                                        <th class="text-center">Deletions (₹ in Crore)</th>
                                        <th class="text-center">Closing balance (₹ in Crore)</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp

                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $key1 => $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_balsheet as $key => $balancesheet)
                                                    @if ($inv->id == $balancesheet['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="inv[{{ $key }}][id]"
                                            value="{{ $balancesheet['id'] }}">
                                        <input type="hidden" name="inv[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="inv[{{ $key }}][other]"
                                                    value="{{ $balancesheet['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="inv[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Opening_balance"
                                                value="{{ $balancesheet['opening_bal'] }}"
                                                name="inv[{{ $key }}][open_bal]" id="opn_{{ $key }}">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Additions abc adt{{ $key }}"
                                                id="ab{{ $key }}" value="{{ $balancesheet['additions'] }}"
                                                name="inv[{{ $key }}][addition]" onkeyup="getInputValue();">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Deletions dlt{{ $key }}"
                                                id="dele{{ $key1 }}" value="{{ $balancesheet['deletions'] }}"
                                                name="inv[{{ $key }}][deletion]" onkeyup="getsameValue();">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Closing_balance"
                                                value="{{ $balancesheet['closing_bal'] }}"
                                                name="inv[{{ $key }}][close_bal]"
                                                id="close_{{ $key }}" readonly></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach

                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_balsheet as $key => $balancesheet)
                                                    @if ($inv->id == $balancesheet['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="inv[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <input type="hidden" name="inv[{{ $key }}][id]"
                                            value="{{ $balancesheet['id'] }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="inv[{{ $key }}][other]"
                                                    value="{{ $balancesheet['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="inv[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Opening_balance"
                                                value="{{ $balancesheet['opening_bal'] }}"
                                                name="inv[{{ $key }}][open_bal]" id="opn_{{ $key }}">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Additions adt{{ $key }}"
                                                id="hcb{{ $key }}" value="{{ $balancesheet['additions'] }}"
                                                name="inv[{{ $key }}][addition]" onkeyup="getInput();">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Deletions dlt{{ $key }}"
                                                id="e{{ $key }}" value="{{ $balancesheet['deletions'] }}"
                                                name="inv[{{ $key }}][deletion]" onkeyup="getsame();"></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Closing_balance"
                                                value="{{ $balancesheet['closing_bal'] }}"
                                                name="inv[{{ $key }}][close_bal]"
                                                id="close_{{ $key }}" readonly></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="text-center"><input type="number" name="tot_opn_blnc"
                                                class="text-center form-control form-control-sm Opening_balance_total"
                                                value="{{ array_sum(array_column($claim_brkp_balsheet, 'opening_bal')) }}"
                                                readonly></td>
                                        <td class="text-center"><input type="number" name="tot_add_blnc"
                                                class="text-center form-control form-control-sm Additions_total"
                                                id="aaa"
                                                value="{{ array_sum(array_column($claim_brkp_balsheet, 'additions')) }}"
                                                onkeyup="getInputTotal();" value="" readonly></td>
                                        <td class="text-center"><input type="number" name="tot_dlt_blnc"
                                                class="text-center form-control form-control-sm Deletions_total"
                                                id="zz"
                                                value="{{ array_sum(array_column($claim_brkp_balsheet, 'deletions')) }}"
                                                onkeyup="InputTotal();" readonly></td>
                                        <td class="text-center"><input type="number" name="tot_close_blnc"
                                                class="text-center form-control form-control-sm Closing_balance_total"
                                                value="{{ array_sum(array_column($claim_brkp_balsheet, 'closing_bal')) }}"
                                                readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.4 Break up of total additions into eligible and non-eleigible investment</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Total addition as per Balance Sheet (₹ in crore)</th>
                                        <th class="text-center">Considered for PLI Scheme (₹ in crore)</th>
                                        <th class="text-center">Not considered for PLI Scheme (₹ in crore)</th>
                                        <th class="text-center">Reason for not considering(Note:If difference is zero then
                                            fill NA.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_totAdd as $key => $brkptot)
                                                    @if ($inv->id == $brkptot['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="inva[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <input type="hidden" name="inva[{{ $key }}][id]"
                                            value="{{ $brkptot['id'] }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="inva[{{ $key }}][other]"
                                                    value="{{ $brkptot['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="inva[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Balance_Sheet"
                                                value="{{ $brkptot['total_add_bal'] }}"
                                                name="inva[{{ $key }}][Balance_Sheet]"
                                                id="tc{{ $key }}" readonly></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm PLI_Scheme"
                                                onkeyup="getminus()" id="tcz{{ $key }}"
                                                value="{{ $brkptot['consi_for_pli'] }}"
                                                name="inva[{{ $key }}][PLI_Scheme]">
                                        </td>

                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Not_PLI_scheme"
                                                value="{{ $brkptot['not_consi_for_pli'] }}"
                                                name="inva[{{ $key }}][Not_PLI_scheme]"
                                                id="tcza{{ $key }}" readonly></td>
                                        <td class="text-center"><input type="text"
                                                class="text-center form-control form-control-sm New"
                                                value="{{ $brkptot['reason'] }}"
                                                name="inva[{{ $key }}][reason_for_not_cons]">
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_totAdd as $key => $brkptot)
                                                    @if ($inv->id == $brkptot['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="inv[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <input type="hidden" name="inva[{{ $key }}][id]"
                                            value="{{ $brkptot['id'] }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="inva[{{ $key }}][other]"
                                                    value="{{ $brkptot['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="inva[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Balance_Sheet"
                                                value="{{ $brkptot['total_add_bal'] }}"
                                                name="inva[{{ $key }}][Balance_Sheet]"
                                                id="tcb{{ $key }}" readonly></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm PLI_Scheme"
                                                value="{{ $brkptot['consi_for_pli'] }}"
                                                name="inva[{{ $key }}][PLI_Scheme]" onkeyup="getmin()"
                                                id="tczaa{{ $key }}">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Not_PLI_scheme"
                                                value="{{ $brkptot['not_consi_for_pli'] }}"
                                                name="inva[{{ $key }}][Not_PLI_scheme]"
                                                id="tczaz{{ $key }}" readonly></td>
                                        <td class="text-center"><input type="text"
                                                class="text-center form-control form-control-sm New"
                                                value="{{ $brkptot['reason'] }}"
                                                name="inva[{{ $key }}][reason_for_not_cons]">
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="text-center"><input type="number" name="tot_blc_sheet"
                                                class="text-center form-control form-control-sm Balance_Sheet_total"
                                                id="ab"
                                                value="{{ array_sum(array_column($claim_brkp_totAdd, 'total_add_bal')) }}"
                                                readonly></td>
                                        <td class="text-center"><input type="number" name="pli_scheme_total"
                                                class="text-center form-control form-control-sm PLI_Scheme_total"
                                                id="aba"
                                                value="{{ array_sum(array_column($claim_brkp_totAdd, 'consi_for_pli')) }}"
                                                readonly></td>
                                        <td class="text-center"><input type="number" name="not_pli_scheme_total"
                                                class="text-center form-control form-control-sm Not_PLI_scheme_total"
                                                id="abab"
                                                value="{{ array_sum(array_column($claim_brkp_totAdd, 'not_consi_for_pli')) }}"
                                                readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.5 Break up of assets discarded during the year</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Total deletion/ discarded/ sold (₹ in crore) </th>
                                        <th class="text-center">Considered for PLI Scheme in current year or previous year
                                            (₹ in crore)</th>
                                        <th class="text-center">Not considered (₹ in crore)</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $key1 => $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_assest as $key => $brkpasset)
                                                    @if ($inv->id == $brkpasset['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="invaa[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <input type="hidden" name="invaa[{{ $key }}][id]"
                                            value="{{ $brkpasset['id'] }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="invaa[{{ $key }}][other]"
                                                    value="{{ $brkpasset['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="invaa[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm tot_del_dis_sold"
                                                value="{{ $brkpasset['total_del_dis_sol'] }}"
                                                name="invaa[{{ $key }}][tot_del_dis_sold]"
                                                id="del{{ $key1 }}" readonly></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm PLI_Scheme_curr"
                                                value="{{ $brkpasset['consi_for_pli'] }}"
                                                name="invaa[{{ $key }}][PLI_Scheme_curr]" onkeyup="minus()"
                                                id="ff{{ $key }}"></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Not_PLI_Scheme_curr"
                                                value="{{ $brkpasset['not_consi_for_pli'] }}"
                                                name="invaa[{{ $key }}][Not_PLI_Scheme_curr]"
                                                id="tt{{ $key }}" readonly></td>

                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_assest as $key => $brkpasset)
                                                    @if ($inv->id == $brkpasset['inv_prt_id'])
                                    <tr>
                                        <input type="hidden" name="invaa[{{ $key }}][inv_prt_id]"
                                            value="{{ $inv->id }}">
                                        <input type="hidden" name="invaa[{{ $key }}][id]"
                                            value="{{ $brkpasset['id'] }}">
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular == 'Others (Specify nature)')
                                                <input type="text" name="invaa[{{ $key }}][other]"
                                                    value="{{ $brkpasset['other_part'] }}" id=""
                                                    class="text-center form-control form-control-sm">
                                            @else
                                                <input type="hidden" name="invaa[{{ $key }}][other]"
                                                    value="Null" id=""
                                                    class="text-center form-control form-control-sm">
                                            @endif
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm tot_del_dis_sold"
                                                value="{{ $brkpasset['total_del_dis_sol'] }}"
                                                name="invaa[{{ $key }}][tot_del_dis_sold]"
                                                id="ca{{ $key }}" readonly></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm PLI_Scheme_curr"
                                                value="{{ $brkpasset['consi_for_pli'] }}"
                                                name="invaa[{{ $key }}][PLI_Scheme_curr]" onkeyup="minu()"
                                                id="gg{{ $key }}"></td>
                                        <td class="text-center"><input type="number"
                                                class="text-center form-control form-control-sm Not_PLI_Scheme_curr"
                                                value="{{ $brkpasset['not_consi_for_pli'] }}"
                                                name="invaa[{{ $key }}][Not_PLI_Scheme_curr]"
                                                id="dd{{ $key }}" readonly></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="text-center"><input type="number" name="dd_sold_total"
                                                class="text-center form-control form-control-sm tot_del_dis_sold_total"
                                                value="{{ array_sum(array_column($claim_brkp_assest, 'total_del_dis_sol')) }}"
                                                id="azz" readonly></td>
                                        <td class="text-center"><input type="number" name="pli_curr_tot"
                                                class="text-center form-control form-control-sm PLI_Scheme_curr_total"
                                                value="{{ array_sum(array_column($claim_brkp_assest, 'consi_for_pli')) }}"
                                                readonly></td>
                                        <td class="text-center"><input type="number" name="pli_not_curr_tot"
                                                class="text-center form-control form-control-sm Not_PLI_Scheme_curr_total"
                                                value="{{ array_sum(array_column($claim_brkp_assest, 'not_consi_for_pli')) }}"
                                                id="not_pli_total" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.6 Employment as on date for Greenfield Project (in absolute numbers)</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th colspan="">Heads of Investment</th>
                                        <th>Nos. as per QRR</th>
                                        <th colspan="">Actual Nos</th>
                                        <th colspan="">Difference</th>
                                        <th colspan="">Reason If any(If difference is zero then fill NA.)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <input type="hidden" value="{{ $claim_emp->id }}" name="emp_id"
                                            class="text-center form-control form-control-sm ">
                                        <td colspan="">On-roll labor</td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->QrrLabourNo }}"
                                                name="qrr_on_roll_labor" id="qrr_labor"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="number"
                                                value="{{ $claim_emp->on_roll_labor }}" onkeyup="labor_diff(this.value)"
                                                name="on_roll_labor" id="on_roll_labor"
                                                class="text-center form-control form-control-sm emp_val"></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->diff_labor }}"
                                                id="labor" name="diff_labor"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="text"
                                                value="{{ $claim_emp->difference_labor }}" name="difference_labor"
                                                class="text-center form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="">On-roll employees</td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->QrrEmpNo }}"
                                                id="qrr_emp" name="qrr_on_roll_emp"
                                                class="text-center form-control form-control-sm " readonly></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->no_of_emp }}"
                                                onkeyup="emp_diff(this.value)" name="on_roll_emp" id="on_roll_emp"
                                                class="text-center form-control form-control-sm emp_val"></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->diff_emp }}"
                                                id="employee" name="diff_emp"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="text"
                                                value="{{ $claim_emp->difference_emp }}" name="difference_emp"
                                                class="text-center form-control form-control-sm "></td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Contrctual</td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->QrrConNo }}"
                                                id="qrr_contrctual" name="qrr_on_roll_cont"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="number"
                                                value="{{ $claim_emp->on_roll_contr }}" onkeyup="cont_diff(this.value)"
                                                name="on_roll_cont" id="on_roll_cont"
                                                class="text-center form-control form-control-sm emp_val"></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->diff_cont }}"
                                                id="contractual" name="diff_con"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="text"
                                                value="{{ $claim_emp->difference_con }}" name="difference_con"
                                                class="text-center form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Apprentice</td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->QrrApprNo }}"
                                                id="qrr_apprentice" name="qrr_on_roll_app"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->apprentice }}"
                                                onkeyup="app_diff(this.value)" name="on_roll_app" id="on_roll_app"
                                                class="text-center form-control form-control-sm emp_val"></td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->diff_app }}"
                                                id="apprentice" name="diff_app"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="text"
                                                value="{{ $claim_emp->difference_app }}" name="difference_app"
                                                class="text-center form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Total</td>
                                        <td colspan=""><input type="number" value="{{ $claim_emp->QrrTot }}"
                                                id="tot_qrr_emp" name="qrr_total_emp"
                                                class="text-center form-control form-control-sm" readonly></td>
                                        <td colspan=""><input type="number" onkeyup="tot_emp(this.value)"
                                                value="{{ $claim_emp->total_emp }}" name="total_emp" id="total_emp"
                                                class="text-center form-control form-control-sm emp_val_tot" readonly></td>
                                        <td colspan=""><input type="number"
                                                value="{{ $claim_emp->diff_total_emp }}" name="diff_total_emp"
                                                id="diff_total_emp" class="text-center form-control form-control-sm"
                                                readonly></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row py-2">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{ route('claimsalesdetail.dvaedit', $apps->claim_id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                    class="fa  fa-backward"></i> DVA </a>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"
                                id="invest_det"><i class="fas fa-save"></i> Save as Draft</button>
                        </div>

                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('claimprojectdetail.create', $apps->claim_id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Project
                                Detail<i class="fa  fa-forward"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            var i = 1;
            var j = {{ sizeof($claim_brkp_inv) }} - 1;
            var sn = {{ sizeof($claim_brkp_inv) }} + 1;
            $('#add13').click(function() {
                i++;
                j++;

                $('#dynamic_field13').append('<tr id="row' + i + '"><td class="text-center" colspan="1">' +
                    sn +
                    '</td><td class="text-center"><input type="text" class="form-control form-control-sm" id="investment_data[asset_type]" value="" name="investment_data[' +
                    j +
                    '][asset_type]"></td> <td><input type="text" class="form-control form-control-sm imprpnew text-right" id="imprpnew' +
                    j + '"  onkeyup="breakupsum()" value="" name="investment_data[' + j +
                    '][imp_party]" ></td><td><input type="text" class="form-control form-control-sm impnrpnew text-right" id="impnrpnew' +
                    j + '" name="investment_data[' + j +
                    '][imp_not_party]" onkeyup="breakupsum()"  value=""></td> <td><input type="text" class="form-control form-control-sm indrpnew text-right" id="indrpnew' +
                    j + '" name="investment_data[' + j +
                    '][ind_party]"   onkeyup="breakupsum()" value=""></td> <td><input type="text" class="form-control form-control-sm indnrpnew text-right" id="indnrpnew' +
                    j + '" name="investment_data[' + j +
                    '][ind_not_party]" onkeyup="breakupsum()" value=""></td> <td><input type="text" class="form-control form-control-sm totalrpnew newaddclass text-right" id="totalrpnew' +
                    j + '" name="investment_data[' + j +
                    '][tot_party]" onkeyup="breakupsum()" value="" readonly></td> <td><input type="text" class="form-control form-control-sm totalnrpnew newclass text-right" id="totalnrpnew' +
                    j + '" name="investment_data[' + j +
                    '][tot_not_party]" onkeyup="breakupsum()" value="" readonly></td><td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove13">Remove</button></td></tr>');
                sn++
            });
            $(document).on('click', '.btn_remove13', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                var sum = 0;
                $(".imp_party").each(function() {
                    sum += +$(this).val();
                });
                $(".imp_party_tot").val(sum.toFixed(2));

                var sum1 = 0;
                $(".impnrpnew").each(function() {
                    sum1 += +$(this).val();
                });
                $(".impnrpnew_tot").val(sum1.toFixed(2));

                var sum2 = 0;
                $(".indrpnew").each(function() {
                    sum2 += +$(this).val();
                });
                $(".indrpnew_tot").val(sum2.toFixed(2));

                var sum3 = 0;
                $(".indnrpnew").each(function() {
                    sum3 += +$(this).val();
                });
                $(".indnrpnew_tot").val(sum3.toFixed(2));

                var sum4 = 0;
                $(".totalrpnew").each(function() {
                    sum4 += +$(this).val();
                });
                // alert('dd')
                $("#gt2").val(sum4.toFixed(2));

                var sum5 = 0;
                $(".totalnrpnew").each(function() {
                    sum5 += +$(this).val();
                });
                $(".totalnrpnew_tot").val(sum5.toFixed(2));
            });
        });
        // Break-up of Investment

        function breakupsum() {

            for (i = 0; i <= 50; i++) {

                var imprpnew = parseFloat(document.getElementById('imprpnew' + i).value);
                var imprpold = parseFloat(document.getElementById('indrpnew' + i).value);
                var tot1 = imprpnew + imprpold;
                document.getElementById('totalrpnew' + i).value = tot1.toFixed(2);

                var impnrpnew = parseFloat(document.getElementById('impnrpnew' + i).value);
                var impnrpold = parseFloat(document.getElementById('indnrpnew' + i).value);
                var tot2 = impnrpnew + impnrpold;
                document.getElementById('totalnrpnew' + i).value = tot2.toFixed(2);
            }
        }

        function labor_diff(val) {
            var labor_qrr = parseFloat(document.getElementById('qrr_labor').value);
            document.getElementById('labor').value = labor_qrr - val;
        }

        function emp_diff(val) {
            var emp_qrr = parseFloat(document.getElementById('qrr_emp').value);
            document.getElementById('employee').value = emp_qrr - val;
        }

        function cont_diff(val) {
            var cont_qrr = parseFloat(document.getElementById('qrr_contrctual').value);
            document.getElementById('contractual').value = cont_qrr - val;
        }

        function app_diff(val) {
            var app_qrr = parseFloat(document.getElementById('qrr_apprentice').value);
            document.getElementById('apprentice').value = app_qrr - val;
        }

        function tot_emp(val) {
            var app_qrr = parseFloat(document.getElementById('qrr_tot').value);
            document.getElementById('diff_total_emp').value = app_qrr - val;
        }

        function emp_val(val) {
            var app_qrr = parseFloat(document.getElementById('investment_per_qrr').value);
            var data = app_qrr - val;
            document.getElementById('period_diff').value = (data).toFixed(2);
        }

        $(document).on("keyup", ".imprpnew ", function() {
            var sum = 0;
            $(".imprpnew ").each(function() {
                sum += +$(this).val();
            });
            $(".imp_party_tot").val(sum.toFixed(2));

        });

        $(document).on("keyup", ".impnrpnew", function() {
            var sum = 0;
            $(".impnrpnew").each(function() {
                sum += +$(this).val();
            });
            $(".impnrpnew_tot").val(sum.toFixed(2));

        });

        $(document).on("keyup", ".totalnrpnew", function() {
            var sum = 0;
            $(".totalnrpnew").each(function() {
                sum += +$(this).val();
            });
            $(".totalnrpnew_tot").val(sum.toFixed(2));

        });

        $(document).on("change", ".totalrpnew", function() {
            var sum = 0;
            // alert('d');
            $(".totalrpnew").each(function() {
                sum += +$(this).val();
            });
            $(".totalrpnew_tot").val(sum.toFixed(2));

        });

        $(document).on("keyup", ".indrpnew", function() {
            var sum = 0;
            $(".indrpnew").each(function() {
                sum += +$(this).val();
            });
            $(".indrpnew_tot").val(sum.toFixed(2));

        });

        $(document).on("keyup", ".indnrpnew", function() {
            var sum = 0;
            $(".indnrpnew").each(function() {
                sum += +$(this).val();
            });
            $(".indnrpnew_tot").val(sum.toFixed(2));

        });

        $(document).on("keyup", ".emp_val", function() {
            var sum = 0;
            $(".emp_val").each(function() {
                sum += +$(this).val();
            });
            $(".emp_val_tot").val(sum);

            var gt_em_diff = ($('#tot_qrr_emp').val() - sum);

            $("#diff_total_emp").val(gt_em_diff.toFixed(2));
        });

        $(document).on("keyup", ".emp_val", function() {
            var sum = 0;
            $(".emp_val").each(function() {
                sum += +$(this).val();
            });
            $(".emp_val_tot").val(sum);

        });

        // Break up of Investment as per Balance Sheet
        $(document).on("keyup", ".Opening_balance", function() {
            var sum = 0;
            $(".Opening_balance").each(function() {
                sum += +$(this).val();
            });
            $(".Opening_balance_total").val(sum.toFixed(2));


        });

        $(document).on("keyup", ".Additions", function() {
            var sum = 0;
            $(".Additions").each(function() {
                sum += +$(this).val();
            });
            $(".Additions_total").val(sum.toFixed(2));


            $("#ab").val(sum.toFixed(2));
            var val = $("#ab").val() - $(".PLI_Scheme_total").val();
            $("#abab").val(val.toFixed(2));
        });


        $(document).on("keyup", ".PLI_Scheme", function() {
            var sum = 0;
            $(".PLI_Scheme").each(function() {
                sum += +$(this).val();
            });
            $(".PLI_Scheme_total").val(sum.toFixed(2));
            var val2 = $("#ab").val() - $(".PLI_Scheme_total").val();
            $("#abab").val(val2.toFixed(2));
        });



        $(document).on("keyup", ".Deletions", function() {
            var sum = 0;
            $(".Deletions").each(function() {
                sum += +$(this).val();
            });
            $(".Deletions_total").val(sum);
            $("#azz").val(sum); //Break up of assets discarded during the year TOTAL

            // $("#pli").val($("#azz").val() - $(".PLI_Scheme_curr_total").val()) ;
            $('#not_pli_total').val($("#azz").val() - $('.PLI_Scheme_curr_total').val());
        });

        $(document).on("keyup", ".Opening_balance,.Additions,.Deletions", function() {

            for (i = 0; i <= 15; i++) {

                var data = parseFloat($("#opn_" + i).val()) + parseFloat($(".adt" + i).val()) - parseFloat($(
                    ".dlt" + i).val());
                data = data.toFixed(2);
                $("#close_" + i).val(data);
            }

        });

        $(document).on("keyup", ".PLI_Scheme_curr", function() {

            var sum = 0;
            $(".PLI_Scheme_curr").each(function() {
                sum += +$(this).val();
            });
            $(".PLI_Scheme_curr_total").val(sum.toFixed(2));


            $('#not_pli_total').val($("#azz").val() - $('.PLI_Scheme_curr_total').val());
        });

        $(document).on("keyup", ".Closing_balance", function() {
            var sum = 0;
            $(".Closing_balance").each(function() {
                sum += +$(this).val();
            });
            $(".Closing_balance_total").val(sum);
        });

        function getInputValue() {
            for (i = 0; i < 11; i++) {
                document.getElementById('tc' + i).value = document.getElementById('ab' + i).value;
            }
        }

        function getInput() {
            for (i = 11; i < 15; i++) {
                document.getElementById('tcb' + i).value = document.getElementById('hcb' + i).value;
            }
        }


        function getminus() {
            for (i = 0; i < 11; i++) {
                var a = (document.getElementById('tc' + i).value - document.getElementById('tcz' + i).value);
                document.getElementById('tcza' + i).value = a.toFixed(2);
            }
        }

        function getmin() {
            for (i = 11; i < 15; i++) {
                document.getElementById('tczaz' + i).value = (document.getElementById('tcb' + i).value - document
                    .getElementById('tczaa' + i).value);
            }
        }

        function getsameValue() {
            for (i = 0; i < 11; i++) {
                document.getElementById('del' + i).value = document.getElementById('dele' + i).value;


            }
        }

        function getsame() {
            for (i = 11; i < 15; i++) {
                document.getElementById('ca' + i).value = document.getElementById('e' + i).value;
            }
        }

        function minus() {
            for (i = 0; i < 11; i++) {
                var c = (document.getElementById('del' + i).value - document.getElementById('ff' + i).value);
                document.getElementById('tt' + i).value = c.toFixed(2);
            }
        }

        function minu() {
            for (i = 11; i < 15; i++) {
                document.getElementById('dd' + i).value = (document.getElementById('ca' + i).value - document
                    .getElementById('gg' + i).value);
            }
        }

        //  $(document).on("change", ".newaddclass", function() {
        //     var sum = 0;
        //     $(".newaddclass").each(function() {
        //         sum += +$(this).val();
        //     });
        //     //console.log(sum);
        //     $("#gt2").val(sum);
        // });


        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("invest_det");
                btn.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 20));
            });
        });
    </script>
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimInvestmentRequest', '#application-create') !!}
    @endpush
@endpush
