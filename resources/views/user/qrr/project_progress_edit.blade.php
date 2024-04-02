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
        <form action={{ route('projectprogress.update',$id) }} id="pp-create" role="form" method="post"
            class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $app_id }}">
            <input type="hidden" id="qrr" name="qrr" value="{{ $id }}">
            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Project Details - Progress Report</b>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                {{-- <tr><th colspan="4" class="bg-info"></th></tr> --}}
                                <tr>
                                    <th>Committed Investment (₹ crore) </th>
                                    @if($qrrName==$year.'01')
                                    <th>Cumulative Investment upto March {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                    @else
                                    <th>Cumulative Investment upto {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}} (₹ crore)</th>
                                    <th>Cumulative Investment upto {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} (₹ crore)</th>
                                    @endif
                                </tr>
                                <tr>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Total')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm tpreviousExp"
                                        value="{{$finProg->totprevExpense}}" disabled></td>
                                    <td><input type="text" class="form-control form-control-sm tcurrentExp"
                                        value="{{$finProg->totcurrExpense}}" disabled></td>
                                </tr>
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
                                <tr>
                                    <th>Particulars</th>
                                    <th>Proposed Investment (₹ crore)</th>
                                    @if($qrrName==$year.'01')
                                    <th>Cumulative Investment upto March {{$year}} (₹ crore)</th>
                                    <th>Cumulative Investment upto June {{$year}} (₹ crore)</th>
                                    @else
                                    <th>Cumulative Investment upto {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}} (₹ crore)</th>
                                    <th>Cumulative Investment upto {{$currcolumnName->month}}-{{$currcolumnName->yr_short}} (₹ crore)</th>
                                    @endif
                                </tr>
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
                                    @if($qrrName!=$year.'02') readonly @endif value="{{$finProg->bprevExpense}}"  id="bprevExpense" name="bprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->bcurrExpense}}"  id="bcurrExpense" name="bcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Plant & Machinery (Production)
                                        (Provide details of storage tanks,major components like reactors, production line etc.)</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name==' Plant and Machinery (Production)')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'02') readonly @endif value="{{$finProg->pprevExpense}}"  id="pprevExpense" name="pprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->pcurrExpense}}"  id="pcurrExpense" name="pcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->lprevExpense}}"  id="lprevExpense" name="lprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->lcurrExpense}}"  id="lcurrExpense" name="lcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif   value="{{$finProg->eprevExpense}}"  id="eprevExpense" name="eprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->ecurrExpense}}"  id="ecurrExpense" name="ecurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif   value="{{$finProg->rdprevExpense}}"  id="rdprevExpense" name="rdprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->rdcurrExpense}}"  id="rdcurrExpense" name="rdcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif   value="{{$finProg->efprevExpense}}"  id="efprevExpense" name="efprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->efcurrExpense}}"  id="efcurrExpense" name="efcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->solidprevExpense}}"  id="solidprevExpense" name="solidprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->solidcurrExpense}}"  id="solidcurrExpense" name="solidcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif      value="{{$finProg->hprevExpense}}" id="hprevExpense" name="hprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->hcurrExpense}}"  id="hcurrExpense" name="hcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->wsprevExpense}}"  id="wsprevExpense" name="wsprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->wscurrExpense}}"  id="wscurrExpense" name="wscurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->rwprevExpense}}"  id="rwprevExpense" name="rwprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->rwcurrExpense}}"  id="rwcurrExpense" name="rwcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->swprevExpense}}"  id="swprevExpense" name="swprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->swcurrExpense}}"  id="swcurrExpense" name="swcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->dmprevExpense}}"  id="dmprevExpense" name="dmprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->dmcurrExpense}}"  id="dmcurrExpense" name="dmcurrExpense"></td>
                                </tr>
                                <tr>
                                    <td>Steam</td>
                                    <td>@foreach ($proposeInvest as $item)
                                        @if ($item->name=='Steam')
                                        <input type="text" class="form-control form-control-sm proposedInvest"
                                        value="{{$item->amt}}" disabled>
                                        @endif
                                        @endforeach</td>
                                    <td><input type="text" class="form-control form-control-sm previousExp"
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->stmprevExpense}}"  id="stmprevExpense" name="stmprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->stmcurrExpense}}"  id="stmcurrExpense" name="stmcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->caprevExpense}}"  id="caprevExpense" name="caprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->cacurrExpense}}"  id="cacurrExpense" name="cacurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif value="{{$finProg->coprevExpense}}"  id="coprevExpense" name="coprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->cocurrExpense}}"  id="cocurrExpense" name="cocurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->boprevExpense}}"  id="boprevExpense" name="boprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->bocurrExpense}}"  id="bocurrExpense" name="bocurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->poprevExpense}}"  id="poprevExpense" name="poprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->pocurrExpense}}"  id="pocurrExpense" name="pocurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->stprevExpense}}"  id="stprevExpense" name="stprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->stcurrExpense}}"  id="stcurrExpense" name="stcurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif  value="{{$finProg->misprevExpense}}"  id="misprevExpense" name="misprevExpense"></td>
                                    <td><input type="text" class="form-control form-control-sm currentExp"
                                            value="{{$finProg->miscurrExpense}}"  id="miscurrExpense" name="miscurrExpense"></td>
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
                                    @if($qrrName!=$year.'02') readonly @endif   value="{{$finProg->totprevExpense}}"   id="totprevExpense" name="totprevExpense" readonly></td>
                                    <td><input type="text" class="form-control form-control-sm tcurrentExp"
                                            value="{{$finProg->totcurrExpense}}"  id="totcurrExpense" name="totcurrExpense" readonly></td>
                                        
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
                                
                                {{-- @foreach ($address as $item)
                                
                                <tr>
                                    <th>{{ $item->address }}</th>
                                        @foreach ($statusLand as $sl)
                                           
                                        @if($sl->mid==$item->id) 
                                            <td><select class="form-control form-control-sm conditioncheck" 
                                                name="address[{{ $item->id }}][freelease]" id="address[{{ $item->id }}][freelease]">
                                                    <option value="" >Please Select</option>
                                                    <option value="freehold" @if($sl->freeleash=='freehold') selected @endif>Freehold</option>
                                                    <option value="leasehold" @if( $sl->freeleash=='leasehold') selected @endif>Leasehold</option>
                                                </select></td>
                                            <td><input type="text" name="address[{{ $item->id }}][area]" id="address[{{ $item->id }}][area]" class="form-control form-control-sm"
                                                value="{{$sl->area}}" ></td>
                                            <td><input type="text"  name="address[{{ $item->id }}][acqusition]" id="address[{{ $item->id }}][acqusition]" class="form-control form-control-sm"
                                                value=" {{$sl->acqusition}} " ></td>
                                        
                                        @endif
                                        @endforeach
                                    
                                </tr>
                                
                                @endforeach --}}


                                @foreach ($address as $key=> $item)
                                {{-- {{dd($item,$key,$item->id)}} --}}
                                <tr>
                                    <th>{{ $item->address }}</th>
                                    <th>{{ $item->state }}</th>
                                    <th>{{ $item->city }}</th>
                                    <th>{{ $item->pincode}}</th>
                                    <td><select class="form-control form-control-sm conditioncheck" 
                                        name="address[{{ $item->id }}][freelease]" id="address[{{ $item->id }}][freelease]">
                                            <option value="" >Please Select</option>
                                            <option value="freehold" @if($item->freeleash=='freehold') selected @endif>Freehold</option>
                                            <option value="leasehold" @if($item->freeleash=='leasehold') selected @endif>Leasehold</option>
                                        </select></td>
                                    <td><input type="text" name="address[{{ $item->id }}][area]" id="address[{{ $item->id }}][area]" class="form-control form-control-sm"
                                        value="{{ $item->area }}" ></td>
                                    <td><input type="text"  name="address[{{ $item->id }}][acqusition]" id="address[{{ $item->id }}][acqusition]" class="form-control form-control-sm"
                                        value="{{ $item->acqusition }}" ></td>        
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
                                        value="{{$physicalProg->bArea}}" name="barea" id="barea"></td>
                                    <td><input type="date" class="form-control form-control-sm"
                                            value="{{$physicalProg->bStartDate}}" name="bStartDate" id="bStartDate" ></td>
                                    <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->bCompDate}}" name="bCompDate" id="bCompDate" ></td>
                                    <td><textarea  value=""
                                        class="form-control form-control-sm" rows="2" name="bRemarks" id="bRemarks">{{$physicalProg->bRemarks}}</textarea></td>

                                </tr>
                                <tr>
                                    <td>Office</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->oArea}}" name="oarea" id="oarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->oStartDate}}" name="oStartDate" id="oStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->oCompDate}}" name="oCompDate" id="oCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="oRemarks" id="oRemarks">{{$physicalProg->oRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Canteen</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->cArea}}" name="carea" id="carea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->cStartDate}}" name="cStartDate" id="cStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->cCompDate}}" name="cCompDate" id="cCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="cRemarks" id="cRemarks">{{$physicalProg->cRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Utilities</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->uArea}}" name="uarea" id="uarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->uStartDate}}" name="uStartDate" id="uStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->uCompDate}}" name="uCompDate" id="uCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="uRemarks" id="uRemarks">{{$physicalProg->uRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Plant & Machinery</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->pArea}}" name="parea" id="parea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->pStartDate}}" name="pStartDate" id="pStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->pCompDate}}" name="pCompDate" id="pCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="pRemarks" id="pRemarks">{{$physicalProg->pRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Laboratory Equipment & Investment</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->lArea}}" name="larea" id="larea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->lStartDate}}" name="lStartDate" id="lStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->lCompDate}}" name="lCompDate" id="lCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="lRemarks" id="lRemarks">{{$physicalProg->lRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>R & D Equipment & Instrument*</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->rArea}}" name="rarea" id="rarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->rStartDate}}" name="rStartDate" id="rStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->rCompDate}}" name="rCompDate" id="rCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="rRemarks" id="rRemarks">{{$physicalProg->rRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Effluent Treatment Plant </td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->eArea}}" name="earea" id="earea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->eStartDate}}" name="eStartDate" id="eStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->eCompDate}}" name="eCompDate" id="eCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="eRemarks" id="eRemarks">{{$physicalProg->eRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Solid Waste Management (SWM) </td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->sArea}}" name="sarea" id="sarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->sStartDate}}" name="sStartDate" id="sStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->sCompDate}}" name="sCompDate" id="sCompDate" ></td>
                                        <td><textarea value=""
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="sRemarks" id="sRemarks">{{$physicalProg->sRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                  <td>Heating, Ventilating and Air Conditioning System (HVAC)</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->hArea}}" name="harea" id="harea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->hStartDate}}" name="hStartDate" id="hStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->hCompDate}}" name="hCompDate" id="hCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="hRemarks" id="hRemarks">{{$physicalProg->hRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Water System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->wArea}}" name="warea" id="warea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->wStartDate}}" name="wStartDate" id="wStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->wCompDate}}" name="wCompDate" id="wCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="wRemarks" id="wRemarks">{{$physicalProg->wRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>-Raw Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->rwArea}}" name="rwarea" id="rwarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->rwStartDate}}" name="rwStartDate" id="rwStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->rwCompDate}}" name="rwCompDate" id="rwCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="rwRemarks" id="rwRemarks">{{$physicalProg->rwRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>-Soft Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->swArea}}" name="swarea" id="swarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->swStartDate}}" name="swStartDate" id="swStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->swCompDate}}" name="swCompDate" id="swCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="swRemarks" id="swRemarks">{{$physicalProg->swRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>-DM Water</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->dmwArea}}" name="dmwarea" id="dmwarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->dmwStartDate}}" name="dmwStartDate" id="dmwStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->dmwCompDate}}" name="dmwCompDate" id="dmwCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="dmwRemarks" id="dmwRemarks">{{$physicalProg->dmwRemarks}}</textarea></td>
                                </tr>
                                <tr> 
                                    <td>Steam</td>
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->stmArea}}" name="stmarea" id="stmarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                            value="{{$physicalProg->stmStartDate}}" name="stmStartDate" id="stmStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                            value="{{$physicalProg->stmCompDate}}"name="stmCompDate" id="stmCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder=""   name="stmRemarks" id="stmRemarks">{{$physicalProg->stmRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Compressed Air</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->caArea}}" name="caarea" id="caarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->caStartDate}}" name="caStartDate" id="caStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->caCompDate}}" name="caCompDate" id="caCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="caRemarks" id="caRemarks">{{$physicalProg->caRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Cold Water System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->coArea}}" name="coarea" id="coarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->coStartDate}}" name="coStartDate" id="coStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->coCompDate}}" name="coCompDate" id="coCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="coRemarks" id="coRemarks">{{$physicalProg->coRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Boiler</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->boArea}}" name="boarea" id="boarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->boStartDate}}" name="boStartDate" id="boStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->boCompDate}}" name="boCompDate" id="boCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="boRemarks" id="boRemarks">{{$physicalProg->boRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Power Generation & Distribution System</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->pgArea}}" name="pgarea" id="pgarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->pgStartDate}}" name="pgStartDate" id="pgStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->pgCompDate}}" name="pgCompDate" id="pgCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="pgRemarks" id="pgRemarks">{{$physicalProg->pgRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Storage Tanks</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->stArea}}" name="starea" id="starea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->stStartDate}}" name="stStartDate" id="stStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->stCompDate}}" name="stCompDate" id="stCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="stRemarks" id="stRemarks">{{$physicalProg->stRemarks}}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Miscellaneous</td>
                                    {{-- <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> --}}
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->misArea}}" name="misarea" id="misarea"></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                value="{{$physicalProg->misStartDate}}" name="misStartDate" id="misStartDate" ></td>
                                        <td><input type="date" class="form-control form-control-sm"
                                                    value="{{$physicalProg->misCompDate}}" name="misCompDate" id="misCompDate" ></td>
                                        <td><textarea
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="" name="misRemarks" id="misRemarks">{{$physicalProg->misRemarks}}</textarea></td>
                                </tr>
                                {{-- <tr>
                                    <th>Total</th>
                                     <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td> 
                                    <td><input type="text" class="form-control form-control-sm"
                                        value="{{$physicalProg->bArea}}" ></td>
                                        <td><input type="text" class="form-control form-control-sm"
                                            value="{{$physicalProg->bArea}}" ></td>
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
                    <a href="{{ route('revenue.create',['id' => $app_id, 'qrr' => $id]) }}" 
                        class="btn btn-warning btn-sm form-control form-control-sm">
                        <i class="fas fa-angle-double-left"></i>Revenue</a>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper swt_alert" id="submitshareper"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('uploads.create',['id' => $app_id, 'qrr' => $id]) }}" 
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
{!! JsValidator::formRequest('App\Http\Requests\ProjectProgressUpdate','#pp-create') !!}
@endpush