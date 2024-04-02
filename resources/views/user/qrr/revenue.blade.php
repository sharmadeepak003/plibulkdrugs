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
            <form action='{{ route('revenue.store') }}' id="revenue-create" role="form" method="post"
                class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8" onsubmit="return myfunction(this)">
                @csrf
                <input type="hidden" id="app_id" name="app_id" value="{{ $id }}">
                <input type="hidden" id="qrr" name="qrr" value="{{ $qrr }}">
                <input type="hidden" id="qrrName" name="qrrName" value="{{ $qrrName }}">

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Revenue from Operations – [net of credit notes, discounts, and taxes applicable]</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                @if ($qrrName == $year.'01')
                                    <tbody>
                                        <tr> 
                                            <th></th>
                                            <th class='text-center' colspan="2">For FY{{$year}}-{{substr($year, -2)+1}}</th>
                                            <th class='text-center' colspan="2">For quarter ended June-{{substr($year, -2)}}<br>(Revenue for quarter June-{{substr($year, -2)}})</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th class='text-center'>Quantity (Kg)</th>
                                            <th>Sales for FY{{$year}}-{{substr($year, -2)+1}} (₹)</th>
                                            <th class='text-center'>Quantity (Kg)</th>
                                            <th>Sales in quarter ended June-{{substr($year, -2)}} (₹)</th>
                                        </tr>
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
                                                    value="" id="gcDomPrevQuantity" name="gcDomPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="" id="gcDomPrevSales" name="gcDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcDomCurrQuantity" name="gcDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcDomCurrSales" name="gcDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                    value="" id="gcExpPrevQuantity" name="gcExpPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="" id="gcExpPrevSales" name="gcExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcExpCurrQuantity" name="gcExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcExpCurrSales" name="gcExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                    value="" id="gcCapPrevQuantity" name="gcCapPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="" id="gcCapPrevSales" name="gcCapPrevSales" ></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcCapCurrQuantity" name="gcCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcCapCurrSales" name="gcCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (i)</th>
                                            <td><input type="text" class="form-control form-control-sm greenprevtotquant"
                                                    value="" id="gcTotPrevQuantity" name="gcTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greenprevtotsales"
                                                    value="" id="gcTotPrevSales" name="gcTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greencurrtotquant"
                                                    value="" id="gcTotCurrQuantity" name="gcTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greencurrtotsales"
                                                    value="" id="gcTotCurrSales" name="gcTotCurrSales" readonly></td>
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
                                                    value="" id="ecDomPrevQuantity" name="ecDomPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="" id="ecDomPrevSales" name="ecDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecDomCurrQuantity" name="ecDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecDomCurrSales" name="ecDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                    value="" id="ecExpPrevQuantity" name="ecExpPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="" id="ecExpPrevSales" name="ecExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecExpCurrQuantity" name="ecExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecExpCurrSales" name="ecExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                    value="" id="ecCapPrevQuantity" name="ecCapPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="" id="ecCapPrevSales" name="ecCapPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecCapCurrQuantity" name="ecCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecCapCurrSales" name="ecCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (ii)</th>
                                            <td><input type="text" class="form-control form-control-sm existprevtotquant"
                                                    value="" id="ecTotPrevQuantity" name="ecTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existprevtotsales"
                                                    value="" id="ecTotPrevSales" name="ecTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existcurrtotquant"
                                                    value="" id="ecTotCurrQuantity" name="ecTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existcurrtotsales"
                                                    value="" id="ecTotCurrSales" name="ecTotCurrSales" readonly></td>
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
                                                    value="" id="otDomPrevQuantity" name="otDomPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="" id="otDomPrevSales" name="otDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otDomCurrQuantity" name="otDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otDomCurrSales" name="otDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                    value="" id="otExpPrevQuantity" name="otExpPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="" id="otExpPrevSales" name="otExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otExpCurrQuantity" name="otExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otExpCurrSales" name="otExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                    value="" id="otCapPrevQuantity" name="otCapPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="" id="otCapPrevSales" name="otCapPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otCapCurrQuantity" name="otCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otCapCurrSales" name="otCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (iii)</th>
                                            <td><input type="text" class="form-control form-control-sm otherprevtotquant "
                                                    value="" id="otTotPrevQuantity" name="otTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm otherprevtotsales "
                                                    value="" id="otTotPrevSales" name="otTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm othercurrtotquant "
                                                    value="" id="otTotCurrQuantity" name="otTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm othercurrtotsales "
                                                    value="" id="otTotCurrSales" name="otTotCurrSales" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Other Activities</th>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractprevquant grandPrevTotalQuant"
                                                    value="" id="otherPrevQuantity" name="otherPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractprevsales grandPrevTotalSales"
                                                    value="" id="otherPrevSales" name="otherPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractcurrquant grandCurrTotalQuant"
                                                    value="" id="otherCurrQuantity" name="otherCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractcurrsales grandCurrTotalSales"
                                                    value="" id="otherCurrSales" name="otherCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Revenue</th>
                                            <td><input type="text" class="form-control form-control-sm totalprevquant"
                                                    value="" id="totPrevQuantity" name="totPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalprevsales"
                                                    value="" id="totPrevSales" name="totPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrquant"
                                                    value="" id="totCurrQuantity" name="totCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrsales"
                                                    value="" id="totCurrSales" name="totCurrSales" readonly></td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th class='text-center' colspan="2">Quarter ended
                                                {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                            </th>
                                            <th class='text-center' colspan="2">Quarter ended
                                                {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}<br>(Revenue for quarter {{$currcolumnName->month}}-{{$currcolumnName->yr_short}})
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th class='text-center'>Quantity (Kg)</th>
                                            <th class='text-center'>Sales for
                                                {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }} (₹)</th>
                                            <th class='text-center'>Quantity (Kg)</th>
                                            <th class='text-center'>Sales for
                                                {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} (₹)</th>
                                        </tr>
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
                                                    value="{{ $revPrev->gcDomCurrQuantity }}" id="gcDomPrevQuantity"
                                                    readonly name="gcDomPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->gcDomCurrSales }}" id="gcDomPrevSales" readonly
                                                    name="gcDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcDomCurrQuantity" name="gcDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcDomCurrSales" name="gcDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->gcExpCurrQuantity }}" id="gcExpPrevQuantity"
                                                    name="gcExpPrevQuantity"></td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->gcExpCurrSales }}" id="gcExpPrevSales"
                                                    name="gcExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcExpCurrQuantity" name="gcExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcExpCurrSales" name="gcExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm greenprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->gcCapCurrQuantity }}" id="gcCapPrevQuantity"
                                                    name="gcCapPrevQuantity"></td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm greenprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->gcCapCurrSales }}" id="gcCapPrevSales"
                                                    name="gcCapPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrquant grandCurrTotalQuant"
                                                    value="" id="gcCapCurrQuantity" name="gcCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm greencurrsales grandCurrTotalSales"
                                                    value="" id="gcCapCurrSales" name="gcCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (i)</th>
                                            <td><input type="text" class="form-control form-control-sm greenprevtotquant"
                                                    value="{{ $revPrev->gcTotCurrQuantity }}" id="gcTotPrevQuantity"
                                                    name="gcTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greenprevtotsales"
                                                    value="{{ $revPrev->gcTotCurrSales }}" id="gcTotPrevSales"
                                                    name="gcTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greencurrtotquant"
                                                    value="" id="gcTotCurrQuantity" name="gcTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm greencurrtotsales"
                                                    value="" id="gcTotCurrSales" name="gcTotCurrSales" readonly></td>
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
                                                    value="{{ $revPrev->ecDomCurrQuantity }}" id="ecDomPrevQuantity"
                                                    readonly name="ecDomPrevQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->ecDomCurrSales }}" id="ecDomPrevSales" readonly
                                                    name="ecDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecDomCurrQuantity" name="ecDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecDomCurrSales" name="ecDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->ecExpCurrQuantity }}" id="ecExpPrevQuantity"
                                                    name="ecExpPrevQuantity"></td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->ecExpCurrSales }}" id="ecExpPrevSales"
                                                    name="ecExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecExpCurrQuantity" name="ecExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecExpCurrSales" name="ecExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm existprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->ecCapCurrQuantity }}" id="ecCapPrevQuantity"
                                                    name="ecCapPrevQuantity"></td>
                                            <td><input type="text" readonly
                                                    class="form-control form-control-sm existprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->ecCapCurrSales }}" id="ecCapPrevSales"
                                                    name="ecCapPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrquant grandCurrTotalQuant"
                                                    value="" id="ecCapCurrQuantity" name="ecCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm existcurrsales grandCurrTotalSales"
                                                    value="" id="ecCapCurrSales" name="ecCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (ii)</th>
                                            <td><input type="text" class="form-control form-control-sm existprevtotquant"
                                                    value="{{ $revPrev->ecTotCurrQuantity }}" id="ecTotPrevQuantity"
                                                    name="ecTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existprevtotsales"
                                                    value="{{ $revPrev->ecTotCurrSales }}" id="ecTotPrevSales"
                                                    name="ecTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existcurrtotquant"
                                                    value="" id="ecTotCurrQuantity" name="ecTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm existcurrtotsales"
                                                    value="" id="ecTotCurrSales" name="ecTotCurrSales" readonly></td>
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
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->otDomCurrQuantity }}" id="otDomPrevQuantity"
                                                    name="otDomPrevQuantity"></td>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->otDomCurrSales }}" id="otDomPrevSales"
                                                    name="otDomPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otDomCurrQuantity" name="otDomCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otDomCurrSales" name="otDomCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(b) Export</th>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->otExpCurrQuantity }}" id="otExpPrevQuantity"
                                                    name="otExpPrevQuantity"></td>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->otExpCurrSales }}" id="otExpPrevSales"
                                                    name="otExpPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otExpCurrQuantity" name="otExpCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otExpCurrSales" name="otExpCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <td>(c) Captive Consumption</td>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->otCapCurrQuantity }}" id="otCapPrevQuantity"
                                                    name="otCapPrevQuantity"></td>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otherprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->otCapCurrSales }}" id="otCapPrevSales"
                                                    name="otCapPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrquant grandCurrTotalQuant"
                                                    value="" id="otCapCurrQuantity" name="otCapCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm othercurrsales grandCurrTotalSales"
                                                    value="" id="otCapCurrSales" name="otCapCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total (iii)</th>
                                            <td><input type="text" class="form-control form-control-sm otherprevtotquant "
                                                    value="{{ $revPrev->otTotCurrQuantity }}" id="otTotPrevQuantity"
                                                    name="otTotPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm otherprevtotsales "
                                                    value="{{ $revPrev->otTotCurrSales }}" id="otTotPrevSales"
                                                    name="otTotPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm othercurrtotquant "
                                                    value="" id="otTotCurrQuantity" name="otTotCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm othercurrtotsales "
                                                    value="" id="otTotCurrSales" name="otTotCurrSales" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Other Activities</th>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otheractprevquant grandPrevTotalQuant"
                                                    value="{{ $revPrev->otherCurrQuantity }}" id="otherPrevQuantity"
                                                    name="otherPrevQuantity"></td>
                                            <td><input readonly type="text"
                                                    class="form-control form-control-sm otheractprevsales grandPrevTotalSales"
                                                    value="{{ $revPrev->otherCurrSales }}" id="otherPrevSales"
                                                    name="otherPrevSales"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractcurrquant grandCurrTotalQuant"
                                                    value="" id="otherCurrQuantity" name="otherCurrQuantity"></td>
                                            <td><input type="text"
                                                    class="form-control form-control-sm otheractcurrsales grandCurrTotalSales"
                                                    value="" id="otherCurrSales" name="otherCurrSales"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Revenue</th>
                                            <td><input type="text" class="form-control form-control-sm totalprevquant"
                                                    value="{{ $revPrev->totCurrQuantity }}" id="totPrevQuantity"
                                                    name="totPrevQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalprevsales"
                                                    value="{{ $revPrev->totCurrSales }}" id="totPrevSales"
                                                    name="totPrevSales" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrquant"
                                                    value="" id="totCurrQuantity" name="totCurrQuantity" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrsales"
                                                    value="" id="totCurrSales" name="totCurrSales" readonly></td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                            <span class="help-text">
                                (i) Discounts (including but not limited to cash, volume, turnover, target or for any other
                                purpose) provided for the eligible product whether directly attributable to a particular
                                invoice or not may be factored in the revenue reported for the eligible product on an
                                accrual basis of accounting.
                                <br>(ii) Discounts (including but not limited to cash, volume, turnover, target or for any
                                other purpose) provided on a bundle of products may be reasonably apportioned to the revenue
                                reported for the Eligible Product on an accrual basis of accounting.
                                <br>(iii) Sale of Capital Assets may not be factored under Revenue from Operations.
                                <br>(iv) Revenue from Captive Consumption shall mean the actual cost of production of the
                                said product. Cost Accountant Certificate may be submitted at the time of incentive claim.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Employment as on date for Greenfield Project (in absolute numbers)</b>
                    </div>
                    <div class="card-body">
                        <span class="help-text">Employment which is directly involved in the production process or
                            with related activities beginning from when materials enter a production facility and up until
                            the resultant manufactured goods leave the production facility.</span>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                @if ($qrrName == $year.'01')
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th class='text-center'>As on 31/03/20{{substr($year, -2)}}</th>
                                            <th class='text-center'>As on 30/06/20{{substr($year, -2)}}</th>
                                        </tr>
                                        <tr>
                                            <th class='text-center'>Particulars</th>
                                            <th class='text-center'>No.</th>
                                            <th class='text-center'>No.</th>
                                        </tr>
                                        <tr>
                                            <th>On-roll labor</th>
                                            <td><input type="text" class="form-control form-control-sm prevNo" value=""
                                                    id="laborPrevNo" name="laborPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="laborCurrNo" name="laborCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>On-roll employees</th>
                                            <td><input type="text" class="form-control form-control-sm prevNo" value=""
                                                    id="empPrevNo" name="empPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="empCurrNo" name="empCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Contractual</th>
                                            <td><input type="text" class="form-control form-control-sm prevNo" value=""
                                                    id="conPrevNo" name="conPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="conCurrNo" name="conCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Apprentice</th>
                                            <td><input type="text" class="form-control form-control-sm prevNo" value=""
                                                    id="appPrevNo" name="appPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="appCurrNo" name="appCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td><input type="text" class="form-control form-control-sm totalprevNo"
                                                    value="" id="totPrevNo" name="totPrevNo" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrNo"
                                                    value="" id="totCurrNo" name="totCurrNo" readonly></td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th class="text-center">As on {{ $oldcolumnName->qtr_date }}</th>
                                            <th class="text-center">As on {{ $currcolumnName->qtr_date }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Particulars</th>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">No.</th>
                                        </tr>
                                        <tr>
                                            <th>On-roll labor</th>
                                            <td><input readonly type="text" class="form-control form-control-sm prevNo"
                                                    value="{{ $green->laborCurrNo }}" id="laborPrevNo"
                                                    name="laborPrevNo">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="laborCurrNo" name="laborCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>On-roll employees</th>
                                            <td><input readonly type="text" class="form-control form-control-sm prevNo"
                                                    value="{{ $green->empCurrNo }}" id="empPrevNo" name="empPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="empCurrNo" name="empCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Contractual</th>
                                            <td><input readonly type="text" class="form-control form-control-sm prevNo"
                                                    value="{{ $green->conCurrNo }}" id="conPrevNo" name="conPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="conCurrNo" name="conCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Apprentice</th>
                                            <td><input readonly type="text" class="form-control form-control-sm prevNo"
                                                    value="{{ $green->appCurrNo }}" id="appPrevNo" name="appPrevNo"></td>
                                            <td><input type="text" class="form-control form-control-sm currNo" value=""
                                                    id="appCurrNo" name="appCurrNo"></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td><input type="text" class="form-control form-control-sm totalprevNo"
                                                    value="{{ $green->totCurrNo }}" id="totPrevNo" name="totPrevNo"
                                                    readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalcurrNo"
                                                    value="" id="totCurrNo" name="totCurrNo" readonly></td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Domestic Value Addition</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                @if ($qrrName == $year.'01')
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th colspan="3">For FY{{$year}}-{{substr($year, -2)+1}}</th>
                                            <th colspan="3">For quarter ended June-{{substr($year, -2)}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Key Parameters</th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Cost Price (₹)</th>
                                            <th class="text-center">Amount (₹)</th>
                                            <th class="text-center">Quantity (Kg)</th>
                                            <th class="text-center">Cost Price (₹)</th>
                                            <th class="text-center">Amount (₹)</th>
                                        </tr>
                                        <tr>
                                            <th>Greenfield Capacity (A)</th>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPprevquant" name="EPprevquant">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPprevsales" name="EPprevsales"></td>
                                            <td><input type="text" class="form-control form-control-sm " value=""
                                                    id="EPprevamount" name="EPprevamount"></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurrquant" name="EPcurrquant" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurrsales" name="EPcurrsales"></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurramount" name="EPcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Consumption of Non-Originating Material & Services (B)</th>
                                            <td><input type="text" class="form-control form-control-sm totalConprevquant"
                                                    value="" id="totConprevquant" name="totConprevquant" readonly></td>
                                            <td>
                                            <td><input type="text" class="form-control form-control-sm totalConprevamount"
                                                    value="" id="totConprevamount" name="totConprevamount" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalConcurrquant"
                                                    value="" id="totConcurrquant" name="totConcurrquant" readonly></td>
                                            <td>
                                            <td><input type="text" class="form-control form-control-sm totalConcurramount"
                                                    value="" id="totConcurramount" name="totConcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- Non-Originating Material & Consumables </th>
                                            <td><input type="text" class="form-control form-control-sm materialprevquant"
                                                    value="" id="matprevquant" name="matprevquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                    value="" id="matprevamount" name="matprevamount" readonly></td>

                                            <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                    value="" id="matcurrquant" name="matcurrquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                    value="" id="matcurramount" name="matcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- Non-Originating Services </th>
                                            <td><input type="text" class="form-control form-control-sm materialprevquant"
                                                    value="" id="serprevquant" name="serprevquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                    value="" id="serprevamount" name="serprevamount" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                    value="" id="sercurrquant" name="sercurrquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                    value="" id="sercurramount" name="sercurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Domestic Value Addition % (A-B)/(A)</th>
                                            <td></td>
                                            <td></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="prevDVATotal" name="prevDVATotal" readonly></td>

                                            <td></td>
                                            <td></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="currDVATotal" name="currDVATotal" readonly></td>

                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th class="text-center" colspan="3">For quarter ended
                                                {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                            </th>
                                            <th class="text-center" colspan="3">For quarter ended
                                                {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                            </th>
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
                                            <th>Revenue from Eligible Product (Greenfield Capacity) </th>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="{{ $dva->EPcurrquant }}" readonly id="EPprevquant"
                                                    name="EPprevquant" readonly></td>
                                            <td><input readonly type="text" class="form-control form-control-sm"
                                                    value="{{ $dva->EPcurrsales }}" id="EPprevsales" name="EPprevsales">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm"
                                                    value="{{ $dva->EPcurramount }}" readonly id="EPprevamount"
                                                    name="EPprevamount" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurrquant" name="EPcurrquant" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurrsales" name="EPcurrsales"></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="EPcurramount" name="EPcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Consumption of Non-Originating Material & Services </th>
                                            <td><input type="text" class="form-control form-control-sm totalConprevquant"
                                                    value="{{ $dva->totConcurrquant }}" id="totConprevquant"
                                                    name="totConprevquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm totalConprevamount"
                                                    value="{{ $dva->totConcurramount }}" id="totConprevamount"
                                                    name="totConprevamount" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm totalConcurrquant"
                                                    value="" id="totConcurrquant" name="totConcurrquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm totalConcurramount"
                                                    value="" id="totConcurramount" name="totConcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- Non-Originating Material & Consumables </th>
                                            <td><input type="text" class="form-control form-control-sm materialprevquant"
                                                    value="{{ $dva->matcurrquant }}" readonly id="matprevquant"
                                                    name="matprevquant"></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                    value="{{ $dva->matcurramount }}" readonly id="matprevamount"
                                                    name="matprevamount"></td>
                                            <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                    value="" id="matcurrquant" name="matcurrquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                    value="" id="matcurramount" name="matcurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>- Non-Originating Services </th>
                                            <td><input type="text" class="form-control form-control-sm materialprevquant"
                                                    value="{{ $dva->sercurrquant }}" readonly id="serprevquant"
                                                    name="serprevquant"></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialprevamount"
                                                    value="{{ $dva->sercurramount }}" readonly id="serprevamount"
                                                    name="serprevamount"></td>
                                            <td><input type="text" class="form-control form-control-sm materialcurrquant"
                                                    value="" id="sercurrquant" name="sercurrquant" readonly></td>
                                            <td>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm materialcurramount"
                                                    value="" id="sercurramount" name="sercurramount" readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Domestic Value Addition % (A-B)/(A)</th>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                {{-- Add by Ajaharuddin Ansari --}}
                                                @if ($dva->currDVATotal != 0)
                                                    <input type="text" class="form-control form-control-sm"
                                                    value="{{ $dva->currDVATotal }}" id="prevDVATotal"
                                                    name="prevDVATotal" readonly></td>
                                                @else
                                                    @if ($dva->currDVATotal != 0)
                                                        <input type="text" class="form-control form-control-sm"
                                                        value="{{number_format((((($dva->EPcurramount)-($dva->matcurramount + $dva->sercurramount))/($dva->EPcurramount))*100), 2)}}" id="prevDVATotal"
                                                        name="prevDVATotal" readonly></td>
                                                    @else
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dva->currDVATotal }}" id="prevDVATotal"
                                                        name="prevDVATotal" readonly>
                                                    @endif
                                                @endif
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    value="{{ $dva->currDVATotal }}" id="prevDVATotal"
                                                    name="prevDVATotal" readonly> --}}
                                            </td>

                                            <td></td>
                                            <td></td>
                                            <td><input type="text" class="form-control form-control-sm" value=""
                                                    id="currDVATotal" name="currDVATotal" readonly></td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>

                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <th colspan="10" style="background-color: #007bff; color: #fff">Break up of
                                                Non-Originating Raw Material</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="text-align:center;">
                                                <b>
                                                    @if ($qrrName == $year.'01')
                                                        FY{{$year}}-{{substr($year, -2)+1}}
                                                    @else
                                                        {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                    @endif
                                                </b>
                                                @if ($qrrName == $year.'01')
                                                    <button type="button" id="addPrevMat" name="addPrevMat"
                                                        class="btn btn-success btn-sm float-right"><i
                                                            class="fas fa-plus"></i> Add</button>
                                                @endif
                                            </th>
                                            <th colspan="5" style="text-align:center;">
                                                <b>
                                                    @if ($qrrName == $year.'01')
                                                        June-{{substr($year, -2)}}
                                                    @else
                                                        {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                    @endif
                                                </b>
                                                <button type="button" id="addcurrMat" name="addcurrMat"
                                                    class="btn btn-success btn-sm float-right"><i
                                                        class="fas fa-plus"></i> Add</button>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="5">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-sm"
                                                        id="tablePrevMat">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-30">Breakup of Non-Originating Raw
                                                                    Material</th>
                                                                <th class="w-20">Country of Origin</th>
                                                                <th class="w-20">Quantity (kg)</th>
                                                                <th class="w-20">Amount (₹)</th>
                                                            </tr>
                                                        </thead>
                                                        @if ($qrrName == $year.'01')
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="text" name="mattprev[0][particulars]"
                                                                            class="form-control form-control-sm" value=''>
                                                                    </td>
                                                                    <td><input type="text" name="mattprev[0][country]"
                                                                            class="form-control form-control-sm"></td>
                                                                    <td><input type="text" name="mattprev[0][quantity]"
                                                                            class="form-control form-control-sm mattprevQnty" value=''>
                                                                    </td>
                                                                    <td><input type="text" name="mattprev[0][amount]"
                                                                            class="form-control form-control-sm mattprevAmount">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        @else
                                                            <tbody>
                                                                @if (count($matprev))
                                                                    @foreach ($matprev as $key => $item)
                                                                        <tr>
                                                                            <input type="hidden"
                                                                                name="mattprev[{{ $key }}][id]"
                                                                                value='{{ $item->id }}'>
                                                                            <td><input type="text"
                                                                                    name="mattprev[{{ $key }}][particulars]"
                                                                                    class="form-control form-control-sm"
                                                                                    readonly
                                                                                    value='{{ $item->mattparticulars }}'>
                                                                            </td>
                                                                            <td><input type="text"
                                                                                    name="mattprev[{{ $key }}][country]"
                                                                                    @if($item->mattcountry == '0')
                                                                                    value='NA' @else
                                                                                    value='{{ $item->mattcountry }}'
                                                                                    @endif
                                                                                    class="form-control form-control-sm"
                                                                                    readonly>
                                                                            </td>
                                                                            <td><input type="text"
                                                                                    name="mattprev[{{ $key }}][quantity]"
                                                                                    class="form-control form-control-sm"
                                                                                    readonly
                                                                                    value='{{ $item->mattquantity }}'>
                                                                            </td>
                                                                            <td><input type="text"
                                                                                    name="mattprev[{{ $key }}][amount]"
                                                                                    value='{{ $item->mattamount }}'
                                                                                    class="form-control form-control-sm mattprevAmount"
                                                                                    readonly></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <input type="hidden" name="mattprev[0][id]"
                                                                            value=''>
                                                                        <td><input type="text"
                                                                                name="mattprev[0][particulars]"
                                                                                class="form-control form-control-sm"
                                                                                readonly value='0'></td>
                                                                        <td><input type="text" name="mattprev[0][country]"
                                                                                value='NA'
                                                                                class="form-control form-control-sm"
                                                                                readonly>
                                                                        </td>
                                                                        <td><input type="text" name="mattprev[0][quantity]"
                                                                                class="form-control form-control-sm"
                                                                                readonly value='0'></td>
                                                                        <td><input type="text" name="mattprev[0][amount]"
                                                                                value='0'
                                                                                class="form-control form-control-sm mattprevAmount"
                                                                                readonly></td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        @endif
                                                        <tr>

                                                            @if ($qrrName == $year.'01')
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td><input id="mattprevtot" type="text" name="mattprevtot"
                                                                    class="form-control form-control-sm mattprevtot"
                                                                    readonly value='0.00'></td>
                                                        </tr>
                                                    @else
                                                        @if (count($matprev))
                                                            <tr>
                                                                <th colspan="3">Total</th>
                                                                <td>
                                                                    @foreach ($matprev as $key => $item)
                                                                        <input id="mattprevtot" type="text"
                                                                            name="mattprevtot"
                                                                            class="form-control form-control-sm mattprevtot"
                                                                            readonly
                                                                            value='{{ getSum($item->getTable(), 'mattamount', $item->qrr_id) }}'>
                                                                </td>
                                                            @break
                                                    @endforeach

                                    </tr>
                                @else
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <td><input id="mattprevtot" type="text" name="mattprevtot"
                                                class="form-control form-control-sm mattprevtot" readonly value='0.00'>
                                        </td>
                                    </tr>
                                    @endif
                                    @endif

                                    </tr>
                            </table>
                        </div>
                        </td>


                        <td colspan="5">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm" id="tableCurrMat">
                                    <thead>
                                        <tr>
                                            <th class="w-30">Breakup of Non-Originating Raw Material </th>
                                            <th class="w-20">Country of Origin</th>
                                            <th class="w-20">Quantity (kg)</th>
                                            <th class="w-20">Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                        </tr>
                                    </tbody>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <td><input readonly id="mattcurrtot" type="text" name="mattcurrtot"
                                                class="form-control form-control-sm mattcurrtot" value=''></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                    </div>

                    <div class="table-responsive rounded m-0 p-0">
                        <table class="table table-bordered table-hover table-sm">
                            <tbody>
                                <tr>
                                    <th colspan="10" style="background-color: #007bff; color: #fff">Break up of
                                        Non-Originating Services</th>
                                </tr>
                                <tr>
                                    <th colspan="5" style="text-align:center;">
                                        <b>
                                            @if ($qrrName == $year.'01')
                                                FY{{$year}}-{{substr($year, -2)+1}}
                                            @else
                                                {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                            @endif
                                        </b>
                                        @if ($qrrName == $year.'01')
                                            <button type="button" id="addPrevSer" name="addPrevSer"
                                                class="btn btn-success btn-sm float-right"><i
                                                    class="fas fa-plus"></i> Add</button>
                                        @endif
                                    </th>
                                    <th colspan="5" style="text-align:center;">
                                        <b>
                                            @if ($qrrName == $year.'01')
                                                June-{{substr($year, -2)}}
                                            @else
                                                {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                            @endif
                                        </b>
                                        <button type="button" id="addcurrSer" name="addcurrSer"
                                            class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i>
                                            Add</button>
                                    </th>
                                </tr>

                                <tr>
                                    <td colspan="5">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm" id="tablePrevSer">
                                                <thead>
                                                    <tr>
                                                        <th class="w-30">Breakup of Non-Originating Raw
                                                                Services</th>
                                                        <th class="w-20">Country of Origin</th>
                                                        <th class="w-20">Quantity (kg)</th>
                                                        <th class="w-20">Amount (₹)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($qrrName == $year.'01')
                                                        <tr>
                                                            <td><input type="text" name="serrprev[0][particulars]"
                                                                    class="form-control form-control-sm" value=''>
                                                            </td>
                                                            <td><input type="text" name="serrprev[0][country]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td><input type="text" name="serrprev[0][quantity]"
                                                                    class="form-control form-control-sm serprevQnty" value=''>
                                                            </td>
                                                            <td><input type="text" name="serrprev[0][amount]"
                                                                    class="form-control form-control-sm serrprevAmount">
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @if (count($serprev))
                                                            @foreach ($serprev as $key => $item)
                                                                <tr>
                                                                    <input type="hidden"
                                                                        name="serrprev[{{ $key }}][id]"
                                                                        value='{{ $item->id }}'>
                                                                    <td><input type="text" readonly
                                                                            name="serrprev[{{ $key }}][particulars]"
                                                                            class="form-control form-control-sm"
                                                                            value='{{ $item->serrparticulars }}'>
                                                                    </td>
                                                                    <td><input type="text" readonly
                                                                            name="serrprev[{{ $key }}][country]"
                                                                            @if($item->serrcountry =='0') 
                                                                            value='NA'
                                                                            @else
                                                                            value='{{ $item->serrcountry }}'
                                                                            @endif
                                                                          
                                                                            class="form-control form-control-sm">
                                                                    </td>
                                                                    <td><input type="text" readonly
                                                                            name="serrprev[{{ $key }}][quantity]"
                                                                            class="form-control form-control-sm"
                                                                            value='{{ $item->serrquantity }}'>
                                                                    </td>
                                                                    <td><input type="text" readonly
                                                                            name="serrprev[{{ $key }}][amount]"
                                                                            value='{{ $item->serramount }}'
                                                                            class="form-control form-control-sm serrprevAmount">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td><input type="text" readonly
                                                                        name="serrprev[0][particulars]"
                                                                        class="form-control form-control-sm" value='0'>
                                                                </td>
                                                                <td><input type="text" readonly
                                                                        name="serrprev[0][country]" value='NA'
                                                                        class="form-control form-control-sm"></td>
                                                                <td><input type="text" readonly
                                                                        name="serrprev[0][quantity]"
                                                                        class="form-control form-control-sm"
                                                                        value=0.00></td>
                                                                <td><input type="text" readonly
                                                                        name="serrprev[0][amount]" value=0.00
                                                                        class="form-control form-control-sm serrprevAmount">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                </tbody>
                                                <tr>

                                                    @if ($qrrName == $year.'01')
                                                <tr>
                                                    <th colspan="3">Total</th>
                                                    <td><input readonly id="serrprevtot" type="text" name="serrprevtot"
                                                            class="form-control form-control-sm serrprevtot" value=''>
                                                    </td>
                                                </tr>
                                            @else
                                                @if (count($serprev) > 0)
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        @foreach ($serprev as $key => $item)
                                                            <td><input id="serrprevtot" type="text" name="serrprevtot"
                                                                    class="form-control form-control-sm serrprevtot"
                                                                    readonly
                                                                    value='{{ getSum($item->getTable(), 'serramount', $item->qrr_id) }}'>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <td><input id="serrprevtot" type="text" name="serrprevtot"
                                                                class="form-control form-control-sm serrprevtot"
                                                                readonly value=0.00></td>
                                                    </tr>
                                                @endif
                                                @endif

                                </tr>
                        </table>
                    </div>
                    </td>


                    <td colspan="5">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="tableCurrSer">
                                <thead>
                                    <tr>
                                        <th class="w-30">Breakup of Non-Originating Services
                                        </th>
                                        <th class="w-20">Country of Origin</th>
                                        <th class="w-20">Quantity (kg)</th>
                                        <th class="w-20">Amount (₹)</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    </tr>
                                </tbody>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <td><input readonly id="serrcurrtot" type="text" name="serrcurrtot"
                                            class="form-control form-control-sm serrcurrtot" value=''></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                </div>

                <span class="help-text">
                    (i) For definition of DVA and non-originating material and services, refer clause 2.10 and 2.26 of
                    the Scheme Guidelines.<br>
                    (ii) <mark>Details of only those raw materials, consumables, services and other inputs are required, which
                    are consumed against the units of eligible product sold.</mark><br>
                    (iii) Provide the name of each actual consumption of Raw Material with country of origin being
                    outside India.<br>
                    (iv) In case a material is procured from local dealer, who has imported the material from outside
                    India, the country of origin of such material will be outside India. Therefore, country of origin
                    should be determined based on the country where raw material was manufactured.<br>
                    (v) It is certified that all raw materials, consumables, services and other inputs are originated in
                    India except as disclosed above.
                </span>
            </div>
    </div>
</div>

<div class="row pb-2">
    <div class="col-md-2 offset-md-0">
        <a href="{{ route('qpr.edit', $qrr) }}" class="btn btn-warning btn-sm form-control form-control-sm">
            <i class="fas fa-angle-double-left"></i>QRR Details</a>
    </div>
    <div class="col-md-2 offset-md-3">
        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper onsubmit"
            id="submitshareper" onclick="myfunction()"><i class="fas fa-save"></i>
            Save as Draft</button>
    </div>
    <div class="col-md-2 offset-md-3">
        <a href="{{ route('projectprogress.create', ['id' => $id, 'qrr' => $qrr]) }}"
            class="btn btn-warning btn-sm form-control form-control-sm">
            <i class="fas fa-angle-double-right"></i>Project Progress</a>
    </div>
</div>
</form>
</div>
</div>
@endsection

@push('scripts')
@include('user.partials.js.prevent_multiple_submit')
@include('user.partials.js.revenue')
{!! JsValidator::formRequest('App\Http\Requests\RevenueStore', '#revenue-create') !!}
@endpush
