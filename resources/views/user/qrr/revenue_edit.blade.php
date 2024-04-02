@extends('layouts.user.dashboard-master')

@section('title')
    QRR Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action='{{ route('revenue.update', $id) }}' id="revenue-create" role="form" method="post"
                class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8" onsubmit="return myfunction(this)">
                {!! method_field('patch') !!}
                @csrf
                <input type="hidden" id="app_id" name="app_id" value="{{ $app_id }}">
                <input type="hidden" id="qrr" name="qrr" value="{{ $id }}">
                <input type="hidden" id="qrrName" name="qrrName" value="{{ $qrrName }}">


                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Revenue from Operations – [net of credit notes, discounts, and taxes applicable]</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    @if ($qrrName == $year.'01')
                                        <tr>
                                            <th></th>

                                            <th class="text-center" colspan="2">FY{{$year}}-{{substr($year, -2)+1}}</th>
                                            <th class="text-center" colspan="2">Quarter ended  June-{{substr($year, -2)}}</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center" colspan="2">Quarter ended {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}}</th>
                                            <th class="text-center" colspan="2">
                                                Quarter ended {{$currcolumnName->month}}-{{$currcolumnName->yr_short}}<br>(Revenue for quarter {{$currcolumnName->month}}-{{$currcolumnName->yr_short}})</th>
                                        </tr>
                                    @endif
                                    @if ($qrrName == $year.'01')
                                        <tr>
                                            <th></th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Sales for FY2021-22 (₹)</th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Sales in quarter ended  June-{{substr($year, -2)}} (₹)</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Sales for {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}} (₹)</th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Sales in quarter {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} (₹)</th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>A) Manufacturing Activity</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>  i.   Revenue from Eligible Product (Greenfield Capacity)</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>(a) Domestic Sales</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcDomPrevQuantity }}"
                                                id="gcDomPrevQuantity" name="gcDomPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcDomPrevSales }}"
                                                id="gcDomPrevSales" name="gcDomPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                value="{{ $rev->gcDomCurrQuantity }}" id="gcDomCurrQuantity"
                                                name="gcDomCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                value="{{ $rev->gcDomCurrSales }}" id="gcDomCurrSales"
                                                name="gcDomCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(b) Export</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcExpPrevQuantity }}"
                                                id="gcExpPrevQuantity" name="gcExpPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcExpPrevSales }}"
                                                id="gcExpPrevSales" name="gcExpPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                value="{{ $rev->gcExpCurrQuantity }}" id="gcExpCurrQuantity"
                                                name="gcExpCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                value="{{ $rev->gcExpCurrSales }}" id="gcExpCurrSales"
                                                name="gcExpCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(c) Captive Consumption</td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcCapPrevQuantity }}"
                                                id="gcCapPrevQuantity" name="gcCapPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcCapPrevSales }}"
                                                id="gcCapPrevSales" name="gcCapPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                value="{{ $rev->gcCapCurrQuantity }}" id="gcCapCurrQuantity"
                                                name="gcCapCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                value="{{ $rev->gcCapCurrSales }}" id="gcCapCurrSales"
                                                name="gcCapCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <th>Total (i)</th>
                                        <td><input type="text" class="form-control form-control-sm greenprevtotquant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcTotPrevQuantity }}"
                                                id="gcTotPrevQuantity" name="gcTotPrevQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm greenprevtotsales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->gcTotPrevSales }}"
                                                id="gcTotPrevSales" name="gcTotPrevSales" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm greencurrtotquant"
                                                value="{{ $rev->gcTotCurrQuantity }}" id="gcTotCurrQuantity"
                                                name="gcTotCurrQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm greencurrtotsales"
                                                value="{{ $rev->gcTotCurrSales }}" id="gcTotCurrSales"
                                                name="gcTotCurrSales" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>  ii.   Revenue from Existing Capacity of Eligible Product </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>(a) Domestic Sales</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecDomPrevQuantity }}"
                                                id="ecDomPrevQuantity" name="ecDomPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecDomPrevSales }}"
                                                id="ecDomPrevSales" name="ecDomPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                value="{{ $rev->ecDomCurrQuantity }}" id="ecDomCurrQuantity"
                                                name="ecDomCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                value="{{ $rev->ecDomCurrSales }}" id="ecDomCurrSales"
                                                name="ecDomCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(b) Export</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecExpPrevQuantity }}"
                                                id="ecExpPrevQuantity" name="ecExpPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecExpPrevSales }}"
                                                id="ecExpPrevSales" name="ecExpPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                value="{{ $rev->ecExpCurrQuantity }}" id="ecExpCurrQuantity"
                                                name="ecExpCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                value="{{ $rev->ecExpCurrSales }}" id="ecExpCurrSales"
                                                name="ecExpCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(c) Captive Consumption</td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecCapPrevQuantity }}"
                                                id="ecCapPrevQuantity" name="ecCapPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecCapPrevSales }}"
                                                id="ecCapPrevSales" name="ecCapPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                value="{{ $rev->ecCapCurrQuantity }}" id="ecCapCurrQuantity"
                                                name="ecCapCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                value="{{ $rev->ecCapCurrSales }}" id="ecCapCurrSales"
                                                name="ecCapCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <th>Total (ii)</th>
                                        <td><input type="text" class="form-control form-control-sm existprevtotquant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecTotPrevQuantity }}"
                                                id="ecTotPrevQuantity" name="ecTotPrevQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm existprevtotsales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->ecTotPrevSales }}"
                                                id="ecTotPrevSales" name="ecTotPrevSales" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm existcurrtotquant"
                                                value="{{ $rev->ecTotCurrQuantity }}" id="ecTotCurrQuantity"
                                                name="ecTotCurrQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm existcurrtotsales"
                                                value="{{ $rev->ecTotCurrSales }}" id="ecTotCurrSales"
                                                name="ecTotCurrSales" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>iii. Other than Eligible Product</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>(a) Domestic Sales</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otDomPrevQuantity }}"
                                                id="otDomPrevQuantity" name="otDomPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otDomPrevSales }}"
                                                id="otDomPrevSales" name="otDomPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                value="{{ $rev->otDomCurrQuantity }}" id="otDomCurrQuantity"
                                                name="otDomCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                value="{{ $rev->otDomCurrSales }}" id="otDomCurrSales"
                                                name="otDomCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(b) Export</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otExpPrevQuantity }}"
                                                id="otExpPrevQuantity" name="otExpPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otExpPrevSales }}"
                                                id="otExpPrevSales" name="otExpPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                value="{{ $rev->otExpCurrQuantity }}" id="otExpCurrQuantity"
                                                name="otExpCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                value="{{ $rev->otExpCurrSales }}" id="otExpCurrSales"
                                                name="otExpCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <td>(c) Captive Consumption</td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otCapPrevQuantity }}"
                                                id="otCapPrevQuantity" name="otCapPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otCapPrevSales }}"
                                                id="otCapPrevSales" name="otCapPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                value="{{ $rev->otCapCurrQuantity }}" id="otCapCurrQuantity"
                                                name="otCapCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                value="{{ $rev->otCapCurrSales }}" id="otCapCurrSales"
                                                name="otCapCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <th>Total (iii)</th>
                                        <td><input type="text" class="form-control form-control-sm otherprevtotquant "
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otTotPrevQuantity }}"
                                                id="otTotPrevQuantity" name="otTotPrevQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm otherprevtotsales "
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otTotPrevSales }}"
                                                id="otTotPrevSales" name="otTotPrevSales" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm othercurrtotquant "
                                                value="{{ $rev->otTotCurrQuantity }}" id="otTotCurrQuantity"
                                                name="otTotCurrQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm othercurrtotsales "
                                                value="{{ $rev->otTotCurrSales }}" id="otTotCurrSales"
                                                name="otTotCurrSales" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Other Activities</th>
                                        <td><input type="text"
                                                class="form-control form-control-sm otheractprevquant grandPrevTotalQuant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otherPrevQuantity }}"
                                                id="otherPrevQuantity" name="otherPrevQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otheractprevsales grandPrevTotalSales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->otherPrevSales }}"
                                                id="otherPrevSales" name="otherPrevSales"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otheractcurrquant grandCurrTotalQuant"
                                                value="{{ $rev->otherCurrQuantity }}" id="otherCurrQuantity"
                                                name="otherCurrQuantity"></td>
                                        <td><input type="text"
                                                class="form-control form-control-sm otheractcurrsales grandCurrTotalSales"
                                                value="{{ $rev->otherCurrSales }}" id="otherCurrSales"
                                                name="otherCurrSales"></td>
                                    </tr>
                                    <tr>
                                        <th>Total Revenue</th>
                                        <td><input type="text" class="form-control form-control-sm totalprevquant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->totPrevQuantity }}"
                                                id="totPrevQuantity" name="totPrevQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm totalprevsales"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $rev->totPrevSales }}"
                                                id="totPrevSales" name="totPrevSales" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm totalcurrquant"
                                                value="{{ $rev->totCurrQuantity }}" id="totCurrQuantity"
                                                name="totCurrQuantity" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm totalcurrsales"
                                                value="{{ $rev->totCurrSales }}" id="totCurrSales" name="totCurrSales"
                                                readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="help-text">
                                (i) Discounts (including but not limited to cash, volume, turnover, target or for any other purpose) provided for the eligible product whether directly attributable to a particular invoice or not may be factored in the revenue reported for the eligible product on an accrual basis of accounting.
                                <br>(ii) Discounts (including but not limited to cash, volume, turnover, target or for any other purpose) provided on a bundle of products may be reasonably apportioned to the revenue reported for the Eligible Product on an accrual basis of accounting.
                                <br>(iii) Sale of Capital Assets may not be factored under Revenue from Operations.
                                <br>(iv) Revenue from Captive Consumption shall mean the actual cost of production of the said product. Cost Accountant Certificate may be submitted at the time of incentive claim.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Employment as on date for Greenfield Project (in absolute numbers)</b>
                    </div>
                    <div class="card-body">
                        <span class="help-text">Employment which is directly involved in the production process or with related activities beginning from when materials enter a production facility and up until the resultant manufactured goods leave the production facility.</span>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        @if ($qrrName == $year.'01')
                                            <th class="text-center">As on 31/03/2021</th>
                                            <th class="text-center">As on 30/06/2021</th>
                                        @else
                                            <th class="text-center">As on {{$oldcolumnName->qtr_date}}</th>
                                            <th class="text-center">As on {{$currcolumnName->qtr_date}}</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="text-center">Particulars</th>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">No.</th>
                                    </tr>
                                    <tr>
                                        <th>On-roll labor</th>
                                        <td><input type="text" class="form-control form-control-sm prevNo"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $greenfield->laborPrevNo }}"
                                                id="laborPrevNo" name="laborPrevNo"></td>
                                        <td><input type="text" class="form-control form-control-sm currNo"
                                                value="{{ $greenfield->laborCurrNo }}" id="laborCurrNo"
                                                name="laborCurrNo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>On-roll employees</th>
                                        <td><input type="text" class="form-control form-control-sm prevNo"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $greenfield->empPrevNo }}"
                                                id="empPrevNo" name="empPrevNo"></td>
                                        <td><input type="text" class="form-control form-control-sm currNo"
                                                value="{{ $greenfield->empCurrNo }}" id="empCurrNo" name="empCurrNo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Contractual</th>
                                        <td><input type="text" class="form-control form-control-sm prevNo"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $greenfield->conPrevNo }}"
                                                id="conPrevNo" name="conPrevNo"></td>
                                        <td><input type="text" class="form-control form-control-sm currNo"
                                                value="{{ $greenfield->conCurrNo }}" id="conCurrNo" name="conCurrNo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Apprentice</th>
                                        <td><input type="text" class="form-control form-control-sm prevNo"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $greenfield->appPrevNo }}"
                                                id="appPrevNo" name="appPrevNo"></td>
                                        <td><input type="text" class="form-control form-control-sm currNo"
                                                value="{{ $greenfield->appCurrNo }}" id="appCurrNo" name="appCurrNo">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td><input type="text" class="form-control form-control-sm totalprevNo"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $greenfield->totPrevNo }}"
                                                id="totPrevNo" name="totPrevNo" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm totalcurrNo"
                                                value="{{ $greenfield->totCurrNo }}" id="totCurrNo" name="totCurrNo"
                                                readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- New Template --}}

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Domestic Value Addition</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        @if ($qrrName == $year.'01')
                                            <th class="text-center" colspan="3">For FY{{$year}}-{{substr($year, -2)+1}}</th>
                                            <th class="text-center" colspan="3">For quarter ended  June-{{substr($year, -2)}}</th>
                                            @else
                                            <th class="text-center" colspan="3">For quarter ended {{$oldcolumnName->qtr_date}}</th>
                                            <th class="text-center" colspan="3">For quarter ended {{$currcolumnName->qtr_date}}</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="text-center">Key Parameters</th>
                                        <th class="text-center">Quantity (Kg)</th>
                                        <th class="text-center">Price (₹)</th>
                                        <th class="text-center">Amount (₹)</th>
                                        <th class="text-center">Quantity (Kg)</th>
                                        <th class="text-center">Price (₹)</th>
                                        <th class="text-center">Amount (₹)</th>
                                    </tr>
                                    <tr>
                                        <th>A) Revenue from Eligible Product (Greenfield Capacity)</th>
                                        <td><input type="text" class="form-control form-control-sm"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->EPprevquant }}"
                                                id="EPprevquant" name="EPprevquant" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->EPprevsales }}"
                                                id="EPprevsales" name="EPprevsales"></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->EPprevamount }}"
                                                id="EPprevamount" name="EPprevamount" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                value="{{ $dva->EPcurrquant }}" id="EPcurrquant" name="EPcurrquant" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                value="{{ $dva->EPcurrsales }}" id="EPcurrsales" name="EPcurrsales"></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                value="{{ $dva->EPcurramount }}" id="EPcurramount" name="EPcurramount" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>B) Consumption of Non-Originating Material & Services against units of eligible product sold </th>
                                        <td><input type="text" class="form-control form-control-sm totalConprevquant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->totConprevquant }}"
                                                id="totConprevquant" name="totConprevquant" readonly></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm totalConprevamount"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->totConprevamount }}"
                                                id="totConprevamount" name="totConprevamount" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm totalConcurrquant"
                                                value="{{ $dva->totConcurrquant }}" id="totConcurrquant"
                                                name="totConcurrquant" readonly></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm totalConcurramount"
                                                value="{{ $dva->totConcurramount }}" id="totConcurramount"
                                                name="totConcurramount" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 50px">-Non-Originating Material & Consumables </th>
                                        <td><input type="text" class="form-control form-control-sm materialprevquant"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->matprevquant }}"
                                                id="matprevquant" name="matprevquant" readonly></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->matprevamount }}"
                                                id="matprevamount" name="matprevamount" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                value="{{ $dva->matcurrquant }}" id="matcurrquant" name="matcurrquant" readonly>
                                        </td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                value="{{ $dva->matcurramount }}" id="matcurramount"
                                                name="matcurramount" readonly> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 50px">-Non-Originating Services </th>
                                        <td><input type="text" class="form-control form-control-sm materialprevquant "
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->serprevquant }}"
                                                id="serprevquant" name="serprevquant" readonly></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->serprevamount }}"
                                                id="serprevamount" name="serprevamount" readonly></td>
                                        <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                value="{{ $dva->sercurrquant }}" id="sercurrquant" name="sercurrquant" readonly>
                                        </td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                value="{{ $dva->sercurramount }}" id="sercurramount"
                                                name="sercurramount" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Domestic Value Addition % (A-B)/(A)</th>
                                        <td></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                @if ($qrrName != $year.'01') readonly @endif value="{{ $dva->prevDVATotal }}"
                                                id="prevDVATotal" name="prevDVATotal" readonly></td>

                                        <td></td>
                                        <td></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                                value="{{ $dva->currDVATotal }}" id="currDVATotal" name="currDVATotal"
                                                readonly></td>

                                    </tr>
                                </tbody>
                            </table>



                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" >
                                    <tbody>
                                        <tr>
                                            <th colspan="10" style="background-color: #007bff; color: #fff">Break up of Non-Originating Raw Material</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="text-align:center;">
                                                <b> @if ($qrrName == $year.'01')FY{{$year}}-{{substr($year, -2)+1}} @else {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }} @endif </b>
                                                @if ($qrrName == $year.'01')
                                                    <button type="button" id="addPrevMat" name="addPrevMat"
                                                        class="btn btn-success btn-sm float-right"><i
                                                            class="fas fa-plus"></i> Add</button>
                                                @endif
                                            </th>
                                            <th colspan="5" style="text-align:center;">
                                                <b> @if ($qrrName == $year.'01') June-{{substr($year, -2)}} @else {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} @endif </b>
                                                <button type="button" id="addcurrMat" name="addcurrMat"
                                                    class="btn btn-success btn-sm float-right"><i
                                                        class="fas fa-plus"></i> Add</button>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="5">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-sm" id="tablePrevMat">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-30">Breakup of Non-Originating Raw Material</th>
                                                                <th class="w-20">Country of Origin</th>
                                                                <th class="w-20">Quantity (kg)</th>
                                                                <th class="w-20">Amount (₹)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (sizeof($matprev) > 0)
                                                                @foreach ($matprev as $key => $item)
                                                                    <tr>
                                                                        <input type="hidden"
                                                                            name="mattprev[{{ $key }}][id]"
                                                                            value='{{ $item->id }}'>
                                                                        <td><input type="text"
                                                                                name="mattprev[{{ $key }}][particulars]"
                                                                                @if ($qrrName != $year.'01') readonly @endif
                                                                                class="form-control form-control-sm"
                                                                                value='{{ $item->mattprevparticulars }}'>
                                                                        </td>
                                                                        
                                                                        <td><input type="text"
                                                                                name="mattprev[{{ $key }}][country]"
                                                                                @if($item->mattprevcountry =='0') value='NA' @else 
                                                                                value='{{ $item->mattprevcountry }}' @endif
                                                                                @if ($qrrName != $year.'01') readonly @endif
                                                                                class="form-control form-control-sm"></td>
                                                                        <td><input type="text"
                                                                                name="mattprev[{{ $key }}][quantity]"
                                                                                @if ($qrrName != $year.'01') readonly @endif
                                                                                class="form-control form-control-sm mattprevQnty"
                                                                                value='{{ $item->mattprevquantity }}'></td>
                                                                        <td><input type="text"
                                                                                name="mattprev[{{ $key }}][amount]"
                                                                                value='{{ $item->mattprevamount }}'
                                                                                @if ($qrrName != $year.'01') readonly @endif
                                                                                class="form-control form-control-sm mattprevAmount">
                                                                        </td>
                                                                        @if ($qrrName == $year.'01')
                                                                            <td><a href="{{ route('revenue.deleteMatPrev', $item->id) }}"
                                                                                    class="btn btn-danger btn-sm float-right remove-prom"
                                                                                    onclick="return confirm('Confirm Delete?')">Remove</a>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><input type="text" name="mattprev[0][particulars]"
                                                                            class="form-control form-control-sm" value=''></td>
                                                                    <td><input type="text" name="mattprev[0][country]"
                                                                            class="form-control form-control-sm"></td>
                                                                    <td><input type="text" name="mattprev[0][quantity]"
                                                                            class="form-control form-control-sm mattprevQnty" value=''></td>
                                                                    <td><input type="text" name="mattprev[0][amount]"
                                                                            class="form-control form-control-sm mattprevAmount">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                @if (sizeof($matprev) > 0)
                                                                    <tr>
                                                                        <th colspan="3">Total</th>
                                                                        <td><input id="mattprevtot" type="text" name="mattprevtot"
                                                                                @if ($qrrName != $year.'01') readonly @endif
                                                                                class="form-control form-control-sm mattprevtot"
                                                                                value='{{ getSum('dva_breakdown_mat_prev', 'mattprevamount', $item->qrr_id) }}'></td>
                                                                    </tr>
                                                                @endif
                                                                @if (sizeof($matprev) == 0)
                                                                    @if ($qrrName == $year.'01')
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <td><input id="mattprevtot" type="text" name="mattprevtot"
                                                                                    class="form-control form-control-sm mattprevtot"></td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </td>

                                            <td colspan="5">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-sm" id="tableCurrMat">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-30">Breakup of Non-Originating Raw Material</th>
                                                                <th class="w-20">Country of Origin</th>
                                                                <th class="w-20">Quantity (kg)</th>
                                                                <th class="w-20">Amount (₹)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (sizeof($mat) > 0)
                                                                @foreach ($mat as $key => $item)
                                                                    <tr>
                                                                        <input type="hidden"
                                                                            name="mattcurr[{{ $key }}][id]"
                                                                            value='{{ $item->id }}'>
                                                                        <td><input type="text"
                                                                                name="mattcurr[{{ $key }}][particulars]"
                                                                                class="form-control form-control-sm"
                                                                                value='{{ $item->mattparticulars }}'></td>
                                                                        <td><input type="text"
                                                                                name="mattcurr[{{ $key }}][country]"
                                                                                value='{{ $item->mattcountry }}'
                                                                                class="form-control form-control-sm"></td>
                                                                        <td><input type="text"
                                                                                name="mattcurr[{{ $key }}][quantity]"
                                                                                class="form-control form-control-sm mattrcurrQnty"
                                                                                value='{{ $item->mattquantity }}'></td>
                                                                        <td><input type="text"
                                                                                name="mattcurr[{{ $key }}][amount]"
                                                                                value='{{ $item->mattamount }}'
                                                                                class="form-control form-control-sm mattcurrAmount">
                                                                        </td>
                                                                        <td><a href="{{ route('revenue.deleteMat', $item->id) }}"
                                                                                class="btn btn-danger btn-sm float-right remove-prom"
                                                                                onclick="return confirm('Confirm Delete?')">Remove</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><input type="text" name="mattcurr[0][particulars]"
                                                                            class="form-control form-control-sm" value=''></td>
                                                                    <td><input type="text" name="mattcurr[0][country]"
                                                                            class="form-control form-control-sm"></td>
                                                                    <td><input type="text" name="mattcurr[0][quantity]"
                                                                            class="form-control form-control-sm mattrcurrQnty" value=''></td>
                                                                    <td><input type="text" name="mattcurr[0][amount]"
                                                                            class="form-control form-control-sm mattcurrAmount">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                        <tr>
                                                            @if (sizeof($mat) > 0)
                                                                <tr>
                                                                    <th colspan="3">Total</th>
                                                                    <td><input id="mattcurrtot" type="text" name="mattcurrtot"
                                                                            class="form-control form-control-sm mattcurrtot"
                                                                            value='{{ getSum('dva_breakdown_mat', 'mattamount', $item->qrr_id) }}' readonly>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @if (sizeof($mat) == 0)
                                                                <tr>
                                                                    <th colspan="3">Total</th>
                                                                    <td><input id="mattcurrtot" type="text" name="mattcurrtot"
                                                                            class="form-control form-control-sm mattcurrtot"></td>
                                                                </tr>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" id="promTable">
                                    <tbody>
                                        <tr>
                                            <th colspan="10" style="background-color: #007bff; color: #fff">Break up of Non-Originating Services</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="text-align:center;">
                                                <b> @if ($qrrName == $year.'01')FY{{$year}}-{{substr($year, -2)+1}} @else {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }} @endif </b>
                                                @if ($qrrName == $year.'01')
                                                    <button type="button" id="addPrevSer" name="addPrevSer"
                                                        class="btn btn-success btn-sm float-right"><i
                                                            class="fas fa-plus"></i> Add</button>
                                                @endif
                                            </th>
                                            <th colspan="5" style="text-align:center;">
                                                <b> @if ($qrrName == $year.'01') June-{{substr($year, -2)}} @else {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} @endif </b>
                                                <button type="button" id="addcurrSer" name="addcurrSer"
                                                class="btn btn-success btn-sm float-right"><i
                                                    class="fas fa-plus"></i> Add</button>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="5">
                                                <table class="table table-bordered table-hover table-sm" id="tablePrevSer">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-30">Breakup of Non-Originating Services</th>
                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (kg)</th>
                                                            <th class="w-20">Amount (₹)</th>
                                                            {{-- <th class="w-10"></th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (sizeof($serprev) > 0)
                                                            @foreach ($serprev as $key => $item)
                                                                <tr>
                                                                    <input type="hidden"
                                                                        name="serrprev[{{ $key }}][id]"
                                                                        value='{{ $item->id }}'>
                                                                    <td><input type="text"
                                                                            name="serrprev[{{ $key }}][particulars]"
                                                                            @if ($qrrName != $year.'01') readonly @endif
                                                                            class="form-control form-control-sm"
                                                                            value='{{ $item->serrprevparticulars }}'>
                                                                    </td>
                                                                    <td><input type="text"
                                                                            name="serrprev[{{ $key }}][country]"
                                                                            @if($item->serrprevcountry =='0') 
                                                                            value='NA'
                                                                            @else
                                                                            value='{{ $item->serrprevcountry }}'
                                                                            @endif
                                                                            @if ($qrrName != $year.'01') readonly @endif
                                                                            class="form-control form-control-sm"></td>
                                                                    <td><input type="text"
                                                                            name="serrprev[{{ $key }}][quantity]"
                                                                            @if ($qrrName != $year.'01') readonly @endif
                                                                            class="form-control form-control-sm serprevQnty"
                                                                            value='{{ $item->serrprevquantity }}'></td>
                                                                    <td><input type="text"
                                                                            name="serrprev[{{ $key }}][amount]"
                                                                            value='{{ $item->serrprevamount }}'
                                                                            @if ($qrrName != $year.'01') readonly @endif
                                                                            class="form-control form-control-sm serrprevAmount">
                                                                    </td>
                                                                    @if ($qrrName == $year.'01')
                                                                        <td><a href="{{ route('revenue.deleteSerPrev', $item->id) }}"
                                                                                class="btn btn-danger btn-sm float-right remove-prom"
                                                                                onclick="return confirm('Confirm Delete?')">Remove</a>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td><input type="text" name="serrprev[0][particulars]"
                                                                        class="form-control form-control-sm" value=''></td>
                                                                <td><input type="text" name="serrprev[0][country]"
                                                                        class="form-control form-control-sm"></td>
                                                                <td><input type="text" name="serrprev[0][quantity]"
                                                                        class="form-control form-control-sm  serprevQnty" value=''></td>
                                                                <td><input type="text" name="serrprev[0][amount]"
                                                                        class="form-control form-control-sm serrprevAmount">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        @if (sizeof($serprev) > 0)
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td><input id="serrprevtot" type="text" name="serrprevtot"
                                                                    @if ($qrrName != $year.'01') readonly @endif
                                                                    class="form-control form-control-sm serrprevtot"
                                                                    value="{{ getSum('dva_breakdown_ser', 'serramount', $item->qrr_id) }}">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if (sizeof($serprev) == 0)
                                                        @if ($qrrName == $year.'01')
                                                            <tr>
                                                                <th colspan="3">Total</th>
                                                                <td><input id="serrprevtot" type="text" name="serrprevtot"
                                                                        @if ($qrrName != $year.'01') readonly @endif
                                                                        class="form-control form-control-sm serrprevtot"></td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                    </tr>
                                                </table>
                                            </td>

                                            <td colspan="5">
                                                <table class="table table-bordered table-hover table-sm" id="tableCurrSer">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-30">Breakup of Non-Originating Services</th>
                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (kg)</th>
                                                            <th class="w-20">Amount (₹)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (sizeof($ser) > 0)
                                                            @foreach ($ser as $key => $item)
                                                                <tr>
                                                                    <input type="hidden"
                                                                        name="serrcurr[{{ $key }}][id]"
                                                                        value='{{ $item->id }}'>
                                                                    <td><input type="text"
                                                                            name="serrcurr[{{ $key }}][particulars]"
                                                                            class="form-control form-control-sm"
                                                                            value='{{ $item->serrparticulars }}'></td>
                                                                    <td><input type="text"
                                                                            name="serrcurr[{{ $key }}][country]"
                                                                            value='{{ $item->serrcountry }}'
                                                                            class="form-control form-control-sm"></td>
                                                                    <td><input type="text"
                                                                            name="serrcurr[{{ $key }}][quantity]"
                                                                            class="form-control form-control-sm sercurrQnty"
                                                                            value='{{ $item->serrquantity }}'></td>
                                                                    <td><input type="text"
                                                                            name="serrcurr[{{ $key }}][amount]"
                                                                            value='{{ $item->serramount }}'
                                                                            class="form-control form-control-sm serrcurrAmount">
                                                                    </td>
                                                                    <td><a href="{{ route('revenue.deleteSer', $item->id) }}"
                                                                            class="btn btn-danger btn-sm float-right remove-prom"
                                                                            onclick="return confirm('Confirm Delete?')">Remove</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td><input type="text" name="serrcurr[0][particulars]"
                                                                        class="form-control form-control-sm" value=''></td>
                                                                <td><input type="text" name="serrcurr[0][country]"
                                                                        class="form-control form-control-sm"></td>
                                                                <td><input type="text" name="serrcurr[0][quantity]"
                                                                        class="form-control form-control-sm sercurrQnty" value=''></td>
                                                                <td><input type="text" name="serrcurr[0][amount]"
                                                                        class="form-control form-control-sm serrcurrAmount">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                    <tr>
                                                        @if (sizeof($ser) > 0)
                                                            <tr>
                                                                <th style="width: 18%" colspan="3">Total</th>
                                                                <td>
                                                                    <input id="serrcurrtot" type="text" name="serrcurrtot"
                                                                        class="form-control form-control-sm serrcurrtot"
                                                                        value="{{ getSum('dva_breakdown_ser', 'serramount', $item->qrr_id) }}" readonly>
                                                                </td>
                                                                <td style="width: 9%" colspan="3"></td>
                                                            </tr>
                                                        @endif
                                                        @if (sizeof($ser) == 0)
                                                            @if ($qrrName == $year.'01')
                                                                <tr>
                                                                    <th style="width: 18%">Total</th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td><input id="serrcurrtot" type="text" name="serrcurrtot"
                                                                            class="form-control form-control-sm serrcurrtot"></td>
                                                                    <td style="width: 9%"></td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <span class="help-text">
                                (i) For definition of DVA and non-originating material and services, refer clause 2.10 and
                                2.26 of the Scheme Guidelines.<br>
                                (ii) Details of only those raw materials, consumables, services and other inputs are
                                required, which are consumed against the units of eligible product sold.<br>
                                (iii) Provide the name of each actual consumption of Raw Material with country of origin
                                being outside India.<br>
                                (iv) In case a material is procured from local dealer, who has imported the material from
                                outside India, the country of origin of such material will be outside India. Therefore,
                                country of origin should be determined based on the country where raw material was
                                manufactured.<br>
                                (v) It is certified that all raw materials, consumables, services and other inputs are
                                originated in India except as disclosed above.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-2 offset-md-0">
                        <a href="{{ route('qpr.edit', $id) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm">
                            <i class="fas fa-angle-double-left"></i>QRR Details</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper swt_alert" onclick="myfunction()"
                            id="submitshareper"><i class="fas fa-save"></i>
                            Save as Draft</button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('projectprogress.create', ['id' => $app_id, 'qrr' => $id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm">
                            <i class="fas fa-angle-double-right"></i>Project Progress</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script>
    $(document).ready(function() {
        $('.swt_alert').click(function() {
            alert('OK');
        }
    }
    </script> --}}
    @include('user.partials.js.prevent_multiple_submit')
    @include('user.partials.js.revenue')
    {!! JsValidator::formRequest('App\Http\Requests\RevenueStore', '#revenue-create') !!}
@endpush
