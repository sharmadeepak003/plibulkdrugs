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
        <form action={{ route('projectprogress.store') }} id="pp-create" role="form" method="post"
            class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $id }}">
            <input type="hidden" id="qrr" name="qrr" value="{{ $qrr }}">
            <input type="hidden" id="qrrName" name="qrrName" value="{{ $qrrName }}">

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Project Details - Progress Report</b>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                {{-- <tr><th colspan="4" class="bg-info"></th></tr> --}}
                                @if($qrrName==$year.'01')
                                <tr>
                                    <th>Committed Investment (₹ crore) </th>
                                    <th>Cumulative Investment upto March {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                </tr>
                                <tr>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Total')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm tpreviousExp"
                                        value="" disabled></td>
                                    <td><input type="text" class="form-control form-control-sm tcurrentExp"
                                        value="" disabled></td>
                                </tr>
                                @else
                                <tr>
                                    <th>Committed Investment (₹ crore) </th>
                                    {{-- <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto September {{$year}} (₹ crore)</th> --}}
                                    <th>Cumulative Investment upto {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}} (₹ crore)</th>
                                    <th>Cumulative Investment upto {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} (₹ crore)</th>
                                </tr>
                                <tr>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Total')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm tpreviousExp"
                                    value="{{$finProg->totcurrExpense}}" disabled></td>
                                    <td><input type="text" class="form-control form-control-sm tcurrentExp"
                                        value="" disabled></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                <tr><th colspan="4" class="bg-info">Financial Progress</th></tr>
                                <tr>
                                    <td colspan="4">
                                        <span class="help-text">(i) Please consider eligible investment from 1-4-2020 only as per scheme guidelines
                                            <br>(ii) Provide cumulative value of investment upto the last date of the reportive period.
                                            <br>(iii) Investment amount may be considered on annual basis including capital work in progress.
                                            <br>(iv) Commulative investment as on {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} is to be filled by the applicant.
                                        </span>
                                    </td>
                                </tr>
                                @if($qrrName==$year.'01')
                                <tr>
                                    <th>Particulars</th>
                                    <th>Proposed Investment (₹ crore)</th>
                                    <th>Cumulative Investment upto March {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                </tr>
                                @else
                                <tr>
                                    <th>Particulars</th>
                                    <th>Proposed Investment (₹ crore)</th>
                                    {{-- <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto September {{$year}} (₹ crore)</th> --}}
                                    <th>Cumulative Investment upto {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}} (₹ crore)</th>
                                    <th>Cumulative Investment upto {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} (₹ crore)</th>
                                </tr>
                                @endif
                                <tr>
                                    <td>Building</td>
                                    <td>
                                        @foreach ($proposeInvest as $item)
                                        @if ($item->name=='Building')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                      @if($qrrName!=$year.'01')  value="{{$finProg->bcurrExpense}}" readonly @else value="" @endif  id="bprevExpense" name="bprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="bcurrExpense" name="bcurrExpense"></td>
                                </tr>
                                <tr>
                                    {{-- @php
                                      dd($proposeInvest)  ;
                                    @endphp --}}
                                    <td>Plant & Machinery (Production)
                                        (Provide details of storage tanks,major components like reactors, production line etc.)</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name==' Plant and Machinery (Production)')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->pcurrExpense}}" readonly @else value="" @endif id="pprevExpense" name="pprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="pcurrExpense" name="pcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Lab Equipment and Instruments</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Laboratory Equipment and Instruments')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->lcurrExpense}}" readonly @else value="" @endif  id="lprevExpense" name="lprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="lcurrExpense" name="lcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Establishment of R&D facility</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=="Establishment of Research and Development (R'&'D) Facility")
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->ecurrExpense}}" readonly @else value="" @endif  id="eprevExpense" name="eprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="ecurrExpense" name="ecurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>R&D Equipment & Instruments</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=="R'&'D Equipment and Instruments")
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->rdcurrExpense}}" readonly @else value="" @endif  id="rdprevExpense" name="rdprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="rdcurrExpense" name="rdcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Effluent Treatment Plant and its lines</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Effluent Treatment Plant and its Lines')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->efcurrExpense}}" readonly @else value="" @endif  id="efprevExpense" name="efprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="efcurrExpense" name="efcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td> Solid Waste Management System</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Solid Waste Management System')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->solidcurrExpense}}" readonly @else value="" @endif  id="solidprevExpense" name="solidprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="solidcurrExpense" name="solidcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>HVAC System</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='HVAC System')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->hcurrExpense}}" readonly @else value="" @endif id="hprevExpense" name="hprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="hcurrExpense" name="hcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Water System</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Water System')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->wscurrExpense}}" readonly @else value="" @endif  id="wsprevExpense" name="wsprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="wscurrExpense" name="wscurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Raw Water</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->rwcurrExpense}}" readonly @else value="" @endif  id="rwprevExpense" name="rwprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="rwcurrExpense" name="rwcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Soft Water</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->swcurrExpense}}" readonly @else value="" @endif  id="swprevExpense" name="swprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="swcurrExpense" name="swcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>DM Water</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->dmcurrExpense}}"readonly @else value="" @endif  id="dmprevExpense" name="dmprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="dmcurrExpense" name="dmcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Steam</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Steam')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="@isset($finProg->stmcurrExpense) {{$finProg->stmcurrExpense}} @else 0.00 @endisset" readonly @else value="" @endif  id="stmprevExpense" name="stmprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="stmcurrExpense" name="stmcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Compressed Air</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Compressed Air')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->cacurrExpense}}" readonly @else value="" @endif  id="caprevExpense" name="caprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="cacurrExpense" name="cacurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Cold Water System</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Chilling System')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->cocurrExpense}}" readonly @else value="" @endif  id="coprevExpense" name="coprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="cocurrExpense" name="cocurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Boiler</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Boiler')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->bocurrExpense}}" readonly @else value="" @endif  id="boprevExpense" name="boprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="bocurrExpense" name="bocurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Power Generation & Distribution System</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Power Generation and Distribution System')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->pocurrExpense}}" readonly @else value="" @endif  id="poprevExpense" name="poprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="pocurrExpense" name="pocurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Storage Tanks</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Storage Tanks')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->stcurrExpense}}" readonly @else value="" @endif  id="stprevExpense" name="stprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="stcurrExpense" name="stcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Miscellaneous</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Miscellaneous')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->miscurrExpense}}" readonly @else value="" @endif  id="misprevExpense" name="misprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value=""  id="miscurrExpense" name="miscurrExpense"></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Total')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm tpreviousExp"
                                    @if($qrrName!=$year.'01')  value="{{$finProg->totcurrExpense}}" readonly @else value="" @endif   id="totprevExpense" name="totprevExpense" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm tcurrentExp"
                                            value=""  id="totcurrExpense" name="totcurrExpense" readonly></td>

                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <th  colspan="7" class="bg-info">Status of Land for Greenfield Project</th>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <th class="">State</th>
                                    <th class="">City</th>
                                    <th class="">Pincode</th>
                                    <th>Freehold/Leasehold</th>
                                    <th>Area (Acre)</th>
                                    <th>Status of acquisition</th>
                                </tr>
                                @foreach ($address as $item)
                                <tr>
                                    <th>{{ $item->address }}</th>
                                    <th>{{ $item->state }}</th>
                                    <th>{{ $item->city }}</th>
                                    <th>{{ $item->pincode}}</th>
                                
                                    <td><select class="form-control form-control-sm conditioncheck"
                                        name="address[{{ $item->id }}][freelease]" id="address[{{ $item->id }}][freelease]">
                                            <option value="" selected="selected">Please Select</option>
                                            <option value="freehold">Freehold</option>
                                            <option value="leasehold">Leasehold</option>
                                          </select></td>
                                    <td><input type="text" name="address[{{ $item->id }}][area]" id="address[{{ $item->id }}][area]" class="form-control form-control-sm"
                                        value="" ></td>
                                    <td><input type="text"  name="address[{{ $item->id }}][acqusition]" id="address[{{ $item->id }}][acqusition]" class="form-control form-control-sm"
                                        value="" ></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <span class="help-text">(i) Investment as defined under para 2.21 and 6.1 under Scheme Guidelines.
                            <br>(ii) Expenditure on consumables and raw material used for manufacturing shall not be considered as Investment.
                            <br>(iii) Provide area in Sq.ft. for eligible building and capacity with unit of measurement e.g. MT,Kilos,ltr,CFM etc of the various Plant and Machinery proposed to be installed for the purpose of Greenfield Project approved under the Scheme.
                            <br>(iv) In the remarks column, please provide brief status of the construction commenting on current work in progress, subsequent construction/installations and any anticipated delay from the proposed date etc.

                        </span>
                        <table  class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                <tr><th colspan="6" class="bg-info">Physical Progress</th></tr>
                                <tr>
                                    <th>Major Capital Expenditure Heads</th>
                                    <th>Area in sq. ft./ Estimated Capacity</th>
                                    {{-- <th>Cost      (INR crore)</th> --}}
                                    <th>Schedule Start Date of Construction/Installation</th>
                                    <th>Scheduled Completion Date </th>
                                    <th style="width: 40%;">Brief Status on Progress</th>
                                </tr>
                                <tr>
                                    <td>Building</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                    <td><input type="text" class="form-control form-control-sm"
                                    name="barea" id="barea"  @if($qrrName!=$year.'01') value="{{$physicalProg->bArea}}" @else value="" @endif></td>
                                    <td><input type="date" class="form-control form-control-sm"
                                    @if($qrrName!=$year.'01')  value="{{$physicalProg->bStartDate}}" @else value="" @endif name="bStartDate" id="bStartDate" ></td>
                                    <td><input type="date" class="form-control form-control-sm"
                                    @if($qrrName!=$year.'01')  value="{{$physicalProg->bCompDate}}" @else value="" @endif name="bCompDate" id="bCompDate" ></td>
                                    <td><textarea
                                        class="form-control form-control-sm" rows="2"
                                        placeholder="" name="bRemarks" id="bRemarks">@if($qrrName!=$year.'01') {{$physicalProg->bRemarks}} @endif</textarea></td>

                                </tr>
                                <tr>
                                    <td>Office</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->oArea}}" @else value="" @endif name="oarea" id="oarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->oStartDate}}" @else value="" @endif name="oStartDate" id="oStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->oCompDate}}" @else value="" @endif name="oCompDate" id="oCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="oRemarks" id="oRemarks">@if($qrrName!=$year.'01') {{$physicalProg->oRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Canteen</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->cArea}}" @else value="" @endif name="carea" id="carea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->cStartDate}}" @else value="" @endif name="cStartDate" id="cStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->cCompDate}}" @else value="" @endif name="cCompDate" id="cCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="cRemarks" id="cRemarks">@if($qrrName!=$year.'01') {{$physicalProg->cRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Utilities</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->uArea}}" @else value="" @endif name="uarea" id="uarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->uStartDate}}" @else value="" @endif name="uStartDate" id="uStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->uCompDate}}" @else value="" @endif name="uCompDate" id="uCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="uRemarks" id="uRemarks">@if($qrrName!=$year.'01') {{$physicalProg->uRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Plant & Machinery</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pArea}}" @else value="" @endif name="parea" id="parea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pStartDate}}" @else value="" @endif name="pStartDate" id="pStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pCompDate}}" @else value="" @endif name="pCompDate" id="pCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="pRemarks" id="pRemarks">@if($qrrName!=$year.'01') {{$physicalProg->pRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Laboratory Equipment & Investment</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->lArea}}" @else value="" @endif name="larea" id="larea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->lStartDate}}" @else value="" @endif name="lStartDate" id="lStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->lCompDate}}" @else value="" @endif name="lCompDate" id="lCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="lRemarks" id="lRemarks">@if($qrrName!=$year.'01') {{$physicalProg->lRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>R & D Equipment & Instrument*</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rArea}}" @else value="" @endif name="rarea" id="rarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rStartDate}}" @else value="" @endif name="rStartDate" id="rStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rCompDate}}" @else value="" @endif name="rCompDate" id="rCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="rRemarks" id="rRemarks">@if($qrrName!=$year.'01') {{$physicalProg->rRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Effluent Treatment Plant </td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->eArea}}" @else value="" @endif name="earea" id="earea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->eStartDate}}" @else value="" @endif name="eStartDate" id="eStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->eCompDate}}" @else value="" @endif name="eCompDate" id="eCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="eRemarks" id="eRemarks">@if($qrrName!=$year.'01') {{$physicalProg->eRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Solid Waste Management (SWM) </td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->sArea}}" @else value="" @endif name="sarea" id="sarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->sStartDate}}" @else value="" @endif name="sStartDate" id="sStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->sCompDate}}" @else value="" @endif name="sCompDate" id="sCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="sRemarks" id="sRemarks">@if($qrrName!=$year.'01') {{$physicalProg->sRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                  <td>Heating, Ventilating and Air Conditioning System (HVAC)</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->hArea}}" @else value="" @endif name="harea" id="harea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->hStartDate}}" @else value="" @endif name="hStartDate" id="hStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->hCompDate}}" @else value="" @endif name="hCompDate" id="hCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="hRemarks" id="hRemarks">@if($qrrName!=$year.'01') {{$physicalProg->hRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Water System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->wArea}}" @else value="" @endif name="warea" id="warea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->wStartDate}}" @else value="" @endif name="wStartDate" id="wStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->wCompDate}}" @else value="" @endif name="wCompDate" id="wCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="wRemarks" id="wRemarks">@if($qrrName!=$year.'01') {{$physicalProg->wRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>-Raw Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rwArea}}" @else value="" @endif name="rwarea" id="rwarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rwStartDate}}" @else value="" @endif name="rwStartDate" id="rwStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->rwCompDate}}" @else value="" @endif name="rwCompDate" id="rwCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="rwRemarks" id="rwRemarks">@if($qrrName!=$year.'01') {{$physicalProg->rwRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>-Soft Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->swArea}}" @else value="" @endif name="swarea" id="swarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->swStartDate}}" @else value="" @endif name="swStartDate" id="swStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->swCompDate}}" @else value="" @endif name="swCompDate" id="swCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="swRemarks" id="swRemarks">@if($qrrName!=$year.'01') {{$physicalProg->swRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>-DM Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->dmwArea}}" @else value="" @endif name="dmwarea" id="dmwarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->dmwStartDate}}" @else value="" @endif name="dmwStartDate" id="dmwStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->dmwCompDate}}" @else value="" @endif name="dmwCompDate" id="dmwCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="dmwRemarks" id="dmwRemarks">@if($qrrName!=$year.'01') {{$physicalProg->dmwRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Steam</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stmArea}}" @else value="" @endif name="stmarea" id="stmarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stmStartDate}}" @else value="" @endif name="stmStartDate" id="stmStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stmCompDate}}" @else value="" @endif name="stmCompDate" id="stmCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="stmRemarks" id="stmRemarks">@if($qrrName!=$year.'01') {{$physicalProg->stmRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Compressed Air</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->caArea}}" @else value="" @endif name="caarea" id="caarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->caStartDate}}" @else value="" @endif name="caStartDate" id="caStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->caCompDate}}" @else value="" @endif name="caCompDate" id="caCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="caRemarks" id="caRemarks">@if($qrrName!=$year.'01') {{$physicalProg->caRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Cold Water System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->coArea}}" @else value="" @endif name="coarea" id="coarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->coStartDate}}" @else value="" @endif name="coStartDate" id="coStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->coCompDate}}" @else value="" @endif" name="coCompDate" id="coCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="coRemarks" id="coRemarks">@if($qrrName!=$year.'01') {{$physicalProg->coRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Boiler</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->boArea}}" @else value="" @endif name="boarea" id="boarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->boStartDate}}" @else value="" @endif name="boStartDate" id="boStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->boCompDate}}" @else value="" @endif name="boCompDate" id="boCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="boRemarks" id="boRemarks">@if($qrrName!=$year.'01') {{$physicalProg->boRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Power Generation & Distribution System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pgArea}}" @else value="" @endif name="pgarea" id="pgarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pgStartDate}}" @else value="" @endif name="pgStartDate" id="pgStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->pgCompDate}}" @else value="" @endif name="pgCompDate" id="pgCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="pgRemarks" id="pgRemarks">@if($qrrName!=$year.'01') {{$physicalProg->pgRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Storage Tanks</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stArea}}" @else value="" @endif name="starea" id="starea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stStartDate}}" @else value="" @endif name="stStartDate" id="stStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->stCompDate}}" @else value="" @endif name="stCompDate" id="stCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="stRemarks" id="stRemarks">@if($qrrName!=$year.'01') {{$physicalProg->stRemarks}} @endif</textarea></td>
                                </tr>
                                <tr>
                                    <td>Miscellaneous</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->misArea}}" @else value="" @endif name="misarea" id="misarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->misStartDate}}" @else value="" @endif name="misStartDate" id="misStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                        @if($qrrName!=$year.'01')  value="{{$physicalProg->misCompDate}}" @else value="" @endif name="misCompDate" id="misCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="misRemarks" id="misRemarks">@if($qrrName!=$year.'01') {{$physicalProg->misRemarks}} @endif</textarea></td>
                                </tr>
                                {{-- <tr>
                                    <th>Total</th>
                                     <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td>
                                    <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="" ></td>
                                    <td><input type="text" class="form-control form-control-sm"
                                                value="" ></td>
                                    <td><textarea id="" name=""
                                        class="form-control form-control-sm" rows="2"
                                        placeholder=""></textarea></td>
                                </tr> --}}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-2 offset-md-0">
                    <a href="{{ route('revenue.create',['id' => $id, 'qrr' => $qrr]) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm">
                        <i class="fas fa-angle-double-left"></i>Revenue</a>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper" id="submitshareper"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('uploads.create',['id' => $id, 'qrr' => $qrr]) }}"
                    class="btn btn-warning btn-sm form-control form-control-sm">
                    <i class="fas fa-angle-double-right"></i>Uploads</a>
                </div>
            </div>


        </form>

    </div>
</div>
@endsection
@push('scripts')
@include('user.partials.js.prevent_multiple_submit')
@include('user.partials.js.project_progress')
{!! JsValidator::formRequest('App\Http\Requests\ProjectProgressStore','#pp-create') !!}
@endpush
