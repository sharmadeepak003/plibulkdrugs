@extends('layouts.admin.master')

<style>
    .table th,.table td
    {
        font-size: 12px;
        padding: 8px;
    }
</style>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
    MIS - Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div>
            <h5 class="text-center">Select Financial year & Quarter</h5>
        </div>
        <div style="display: flex; margin:0.3rem; place-content:center; margin-bottom: 20px">
            <select name="fy" id="fy"  class="fyval form-control-sm"
                style="margin:0.1rem 2rem;">
                <option class="text-center" value=""  selected disabled>Select Financial Year</option>
                @foreach ($fys as $fy)
                <option class="text-center" value="{{$fy}}">FY {{$fy}}</option>
                @endforeach
            </select>
            <select name="qtrvalue" id="qtrvalue" class="qtrval form-control-sm"
                style="margin:0.1rem 2rem;">
                    <option class="text-center" value="" selected disabled>Select Quarter</option>
            </select>
            <button type="button" onclick="MISqtr(document.getElementById('qtrvalue').value)" class="btn btn-primary">Filter</button>
        </div>
    </div>
</div>
    <div class="card-header text-bold">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="appPhase1" data-toggle="pill" href="#appPhase1Content" role="tab"
                            aria-controls="appPhase1Content" aria-selected="true">Investment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase2" data-toggle="pill" href="#appPhase2Content" role="tab"
                            aria-controls="appPhase2Content" aria-selected="false">SCOD</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase3" data-toggle="pill" href="#appPhase3Content" role="tab"
                            aria-controls="appPhase3Content" aria-selected="false">Revenue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase4" data-toggle="pill" href="#appPhase4Content" role="tab"
                            aria-controls="appPhase4Content" aria-selected="false">Employment</a>
                    </li>
                    <li class="nav-item">
                            <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Investment']) }}" class="btn btn-sm btn-warning">Investment (Excel) <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Scod']) }}" class="btn btn-sm btn-warning"
                                >SCOD (Excel) <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Revenue']) }}" class="btn btn-sm btn-warning"
                                >Revenue (Excel) <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Employment']) }}" class="btn btn-sm btn-warning"
                                >Employment (Excel) <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Master']) }}" class="btn btn-sm btn-warning"
                                >Master (Excel) <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    @if (AUTH::user()->hasRole('Admin'))
                    <li class="nav-item">
                        <div style="float:left; padding-left:20; padding-top:5; padding-bottom:5">
                            <a href="{{ route('admin.MIS.MISExport', ['qtr' => $qtr_id,'data'=>'Applicant_Info']) }}" class="btn btn-sm btn-warning"
                                >Applicant Info MIS <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div class="tab-pane fade active show" id="appPhase1Content" role="tabpanel" aria-labelledby="appPhase1Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            @if ($qtrMaster)
                            <h5 class="text-center"> {{$qtrMaster->month}}-{{$qtrMaster->yr_short}} - Investment</h5>
                            @else
                            <h5 class="text-center"> F.Y. {{$qtr_id}} - Investment</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" style="width: 100%" id="users">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center " rowspan="2">Sr No</th>
                                            <th class="w-65 text-center "  rowspan="2">Name of Applicant</th>
                                            <th class="w-65 text-center "  rowspan="2">Target Segment</th>
                                            <th class="w-65 text-center "  rowspan="2">Product Name</th>
                                            <th class="w-65 text-center " colspan="4"> (₹ in Cr.)</th>
                                        </tr>
                                        <tr>
                                            <th class="w-65 text-center ">Committed Investment</th>
                                            <th class="w-65 text-center ">Actual Investment till Date (@if($qtrMaster) {{$qtrMaster->qtr_date}}@else F.Y. {{$qtr_id}}@endif)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn=1;
                                        @endphp
                                        @if($qtrMaster)
                                            @foreach ($investment as $app )
                                            <tr>
                                                <td class="text-center">{{$sn++}}</td>
                                                <td>{{$app->name}}</td>
                                                <td>{{$app->target_segment}}</td>
                                                <td class="text-center">{{$app->product}}</td>
                                                <td class="text-center">{{$app->investment}}</td>
                                                <td class="text-center">{{$app->totcurrExpense}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach ($all_investment as $app )
                                            <tr>
                                                <td class="text-center">{{$sn++}}</td>
                                                <td>{{$app->name}}</td>
                                                <td>{{$app->target_segment}}</td>
                                                <td class="text-center">{{$app->product}}</td>
                                                <td class="text-center">{{$app->investment}}</td>
                                                <td class="text-center">{{$app->totcurrexpense}}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <th class="w-65 text-center" colspan="4">Total</th>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($investment,'investment'))}}@else {{array_sum(array_column($all_investment,'investment'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{(array_sum(array_column($investment,'totcurrExpense')))}}@else {{array_sum(array_column($all_investment,'totcurrexpense'))}} @endif</td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade show" id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            @if ($qtrMaster)
                            <h5 class="text-center"> {{$qtrMaster->month}}.{{$qtrMaster->yr_short}} - SCOD</h5>
                            @else
                            <h5 class="text-center"> F.Y. {{$qtr_id}}- SCOD</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " style="width: 100%" id="users1">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center ">Sr No</th>
                                            <th class="w-65 text-center ">Name of Applicant</th>
                                            <th class="w-65 text-center ">Target Segment</th>
                                            <th class="w-65 text-center ">Product Name</th>
                                            <th class="w-65 text-center ">Committed Investment (₹ in Cr.)</th>
                                            <th class="w-65 text-center ">Project Location</th>
                                            <th class="w-65 text-center ">Project Location Product Name</th>
                                            <th class="w-65 text-center ">Original SCOD</th>
                                            <th class="w-65 text-center ">Actual COD</th>
                                            <th class="w-65 text-center ">Achieved Capacity <br> (in kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn=1;
                                        @endphp
                                        @if($qtrMaster)
                                        @foreach ($scod as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->investment}}</td>
                                            <td>{{$app->address}}</td>
                                            <td class="text-center">{{$app->green_product}}</td>
                                            <td class="text-center">{{$app->prod_date}}</td>
                                            <td class="text-center">{{$app->commercial_op}}</td>
                                            <td class="text-center">{{$app->capacity}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($all_scod as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->investment}}</td>
                                            <td>{{$app->address}}</td>
                                            <td class="text-center">{{$app->green_product}}</td>
                                            <td class="text-center">{{$app->prod_date}}</td>
                                            <td class="text-center">{{$app->commercial_op}}</td>
                                            <td class="text-center">{{$app->capacity}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade show" id="appPhase3Content" role="tabpanel" aria-labelledby="appPhase3Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            @if ($qtrMaster)
                            <h5 class="text-center"> {{$qtrMaster->month}}.{{$qtrMaster->yr_short}} - Revenue</h5>
                            @else
                            <h5 class="text-center"> F.Y. {{$qtr_id}} - Revenue</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " style="width: 100%" id="users2">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center " rowspan="3">Sr No</th>
                                            <th class="w-65 text-center "  rowspan="3">Name of Applicant</th>
                                            <th class="w-65 text-center "  rowspan="3">Target Segment</th>
                                            <th class="w-65 text-center "  rowspan="3">Product Name</th>
                                            <th class="w-65 text-center " colspan="9"> Revenue from Greenfield Project</th>
                                            <th class="w-65 text-center " rowspan="3">Total Sales <br>(in ₹)</th>
                                        </tr>
                                        <tr>
                                            <th class="w-65 text-center " colspan="3">Domestic</th>
                                            <th class="w-65 text-center " colspan="3" >Export</th>
                                            <th class="w-65 text-center " colspan="3">Captive Consumption</th>
                                        </tr>
                                        <tr>
                                            <th class="w-65 text-center ">Qty <br> (in kg)</th>
                                            <th class="w-65 text-center ">Total <br>(in ₹)</th>
                                            <th class="w-65 text-center ">Price<br>(in ₹)</th>
                                            <th class="w-65 text-center ">Qty <br> (in kg)</th>
                                            <th class="w-65 text-center ">Total <br>(in ₹)</th>
                                            <th class="w-65 text-center ">Price <br>(in ₹)</th>
                                            <th class="w-65 text-center ">Qty <br> (in kg)</th>
                                            <th class="w-65 text-center ">Total<br>(in ₹)</th>
                                            <th class="w-65 text-center ">Price <br>(in ₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn=1;
                                        @endphp
                                        @if($qtrMaster)
                                        @foreach ($revenue as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->gcDomCurrQuantity}}</td>
                                            <td class="text-center">{{$app->gcDomCurrSales}}</td>
                                            <td class="text-center">@if($app->gcDomCurrQuantity>0) {{round($app->gcDomCurrSales/$app->gcDomCurrQuantity,2)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->gcExpCurrQuantity}}</td>
                                            <td class="text-center">{{$app->gcExpCurrSales}}</td>
                                            <td class="text-center">@if($app->gcExpCurrQuantity>0) {{round($app->gcExpCurrSales/$app->gcExpCurrQuantity,2)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->gcCapCurrQuantity}}</td>
                                            <td class="text-center">{{$app->gcCapCurrSales}}</td>
                                            <td class="text-center">@if($app->gcCapCurrQuantity>0) {{round($app->gcCapCurrSales/$app->gcCapCurrQuantity,2)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->gcTotCurrSales}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($all_revenue as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->gcdomcurrquantity}}</td>
                                            <td class="text-center">{{$app->gcdomcurrsales}}</td>
                                            <td class="text-center">@if($app->gcdomcurrquantity>0) {{round($app->gcdomcurrsales/$app->gcdomcurrquantity)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->gcexpcurrquantity}}</td>
                                            <td class="text-center">{{$app->gcexpcurrsales}}</td>
                                            <td class="text-center">@if($app->gcexpcurrquantity>0) {{round($app->gcexpcurrsales/$app->gcexpcurrquantity)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->gccapcurrquantity}}</td>
                                            <td class="text-center">{{$app->gccapcurrsales}}</td>
                                            <td class="text-center">@if($app->gccapcurrquantity>0) {{round($app->gccapcurrsales/$app->gccapcurrquantity)}} @else 0 @endif</td>
                                            <td class="text-center">{{$app->totcurrsales}}</td>
                                        </tr>
                                        @endforeach
                                        @endif

                                    </tbody>
                                    <tfoot>
                                        <th class="w-65 text-center" colspan="4">Total</th>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcDomCurrQuantity'))}}@else {{array_sum(array_column($all_revenue,'gcdomcurrquantity'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcDomCurrSales'))}}@else {{array_sum(array_column($all_revenue,'gcdomcurrsales'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{round(array_sum(array_column($revenue,'gcdomprice')),2)}}@else {{round(array_sum(array_column($all_revenue,'gcdomprice')),2)}} @endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcExpCurrQuantity'))}}@else {{array_sum(array_column($all_revenue,'gcexpcurrquantity'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcExpCurrSales'))}}@else {{array_sum(array_column($all_revenue,'gcexpcurrsales'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{round(array_sum(array_column($revenue,'gcexpprice')),2)}}@else {{round(array_sum(array_column($all_revenue,'gcexpprice')),2)}} @endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcCapCurrQuantity'))}}@else {{array_sum(array_column($all_revenue,'gccapcurrquantity'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcCapCurrSales'))}}@else {{array_sum(array_column($all_revenue,'gccapcurrsales'))}}@endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{round(array_sum(array_column($revenue,'gccapprice')),2)}}@else {{round(array_sum(array_column($all_revenue,'gccapprice')),2)}} @endif</td>
                                        <td class="w-65 text-center ">@if($qtrMaster){{array_sum(array_column($revenue,'gcTotCurrSales'))}}@else {{array_sum(array_column($all_revenue,'totcurrsales'))}} @endif</td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade show" id="appPhase4Content" role="tabpanel" aria-labelledby="appPhase4Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            @if ($qtrMaster)
                            <h5 class="text-center"> {{$qtrMaster->month}}.{{$qtrMaster->yr_short}} - Employment</h5>
                            @else
                            <h5 class="text-center"> F.Y. {{$qtr_id}} - Employment</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " id="users3" style="width: 100%">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center " rowspan="2">Sr No</th>
                                            <th class="w-65 text-center " rowspan="2">Name of Applicant</th>
                                            <th class="w-65 text-center " rowspan="2">Target Segment</th>
                                            <th class="w-65 text-center " rowspan="2">Product Name</th>
                                            <th class="w-65 text-center "  rowspan="2">Committed Investment (₹ in Cr.)</th>
                                            <th class="w-65 text-center " colspan="4">Employment (in numbers)</th>
                                            <th class="w-65 text-center " rowspan="2">Total Employment (in numbers)</th>
                                        </tr>
                                        <tr>
                                            <th class="w-65 text-center ">On-Roll Labour</th>
                                            <th class="w-65 text-center ">On-Roll Employees</th>
                                            <th class="w-65 text-center ">Contractual</th>
                                            <th class="w-65 text-center ">Apprentice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn=1;
                                        @endphp
                                        @if($qtrMaster)
                                        @foreach ($employment as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->investment}}</td>
                                            <td class="text-center">{{$app->laborCurrNo}}</td>
                                            <td class="text-center">{{$app->empCurrNo}}</td>
                                            <td class="text-center">{{$app->conCurrNo}}</td>
                                            <td class="text-center">{{$app->appCurrNo}}</td>
                                            <td class="text-center">{{$app->totCurrNo}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        @foreach ($all_employment as $app )
                                        <tr>
                                            <td class="text-center">{{$sn++}}</td>
                                            <td>{{$app->name}}</td>
                                            <td>{{$app->target_segment}}</td>
                                            <td class="text-center">{{$app->product}}</td>
                                            <td class="text-center">{{$app->investment}}</td>
                                            <td class="text-center">{{$app->laborcurrno}}</td>
                                            <td class="text-center">{{$app->empcurrno}}</td>
                                            <td class="text-center">{{$app->concurrno}}</td>
                                            <td class="text-center">{{$app->appcurrno}}</td>
                                            <td class="text-center">{{$app->totcurrno}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center" colspan="4">Total</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'investment'))}} @else {{array_sum(array_column($all_employment,'investment'))}} @endif</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'laborCurrNo'))}} @else {{array_sum(array_column($all_employment,'laborcurrno'))}} @endif</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'empCurrNo'))}} @else {{array_sum(array_column($all_employment,'empcurrno'))}} @endif</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'conCurrNo'))}} @else {{array_sum(array_column($all_employment,'concurrno'))}} @endif</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'appCurrNo'))}} @else {{array_sum(array_column($all_employment,'appcurrno'))}} @endif</td>
                                            <td class="text-center"> @if($qtrMaster){{array_sum(array_column($employment,'totCurrNo'))}} @else {{array_sum(array_column($all_employment,'totcurrno'))}} @endif</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')

<script type="text/javascript">
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
    $('#fy').change(function(){
        var val = $(this).val();

        if (val) {
                    $.ajax({
                        url: '/admin/main/' + val,
                        type: "GET",
                        dataType: "json",
                        success: function (data){
                            if(data)
                                {
                                    $("#qtrvalue").empty();
                                    $("#qtrvalue").append('<option value="'+val+'" class="text-center"  selected>All Quarter</option>');
                                    $.each(data,function(key,value){
                                        $("#qtrvalue").append('<option class="text-center"  value="'+value['qtr_id']+'">'+value['month']+'</option>');
                                    });
                                }

                        }
                    });
                } else {
                    $('#tSeg').empty();
                }
    });
    </script>
    <script>

        function MISqtr(a) {
            var b= window.location.href = '' + a;
        }
        $(document).ready(function() {
            $('#users').DataTable({
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
                buttons: ['copyHtml5'],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#users1').DataTable(
            {
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
               buttons: ['copyHtml5'],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#users2').DataTable(
            {
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
                buttons: ['copyHtml5'],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#users3').DataTable(
            {
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                dom: 'Bfrtip',
               buttons: ['copyHtml5'],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });
    </script>

@endpush










