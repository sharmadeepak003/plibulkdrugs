@extends('layouts.user.dashboard-master')

@section('title')
    QRR Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-tabs">
                <div class="card-header pt-1 text-bold">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="appTab" data-toggle="pill" href="#qrrTabContent" role="tab"
                                aria-controls="appTabContent" aria-selected="true">QRR Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="appTab" data-toggle="pill" href="#revenueTabContent" role="tab"
                                aria-controls="appTabContent" aria-selected="false">Revenue</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="appTab" data-toggle="pill" href="#ppTabContent" role="tab"
                                aria-controls="appTabContent" aria-selected="false">Project Progress</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="appTab" data-toggle="pill" href="#uploadTabContent" role="tab"
                                aria-controls="appTabContent" aria-selected="false">Uploads</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="appTab" data-toggle="pill" href="#approvalTab" role="tab"
                                aria-controls="appTabContent" aria-selected="false">Approval Requireds</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="qrrTabContent" role="tabpanel"
                            aria-labelledby="appTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-body p-0">
                                    <div class="card-header bg-gradient-info text-center  font-weight-light">
                                        <b style="font-size: 20px"><b>PLI Bulk Drugs</b><br> Quarterly Review Report (QRR) -
                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} </b>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 25%" class='pl-4'>Applicant Details</th>
                                                    <td style="width: 75%">
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 40%" class='pl-4'>Name</th>
                                                                    <td style="width: 60%">{{ Auth::user()->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Corporate Office Address</th>
                                                                    <td>{{ $companyDet->corp_add }} ,
                                                                        {{ $companyDet->corp_city }},
                                                                        {{ $companyDet->corp_state }},
                                                                        {{ $companyDet->corp_pin }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Approved Eligible Product</th>
                                                                    <td>{{ $prods->product }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Target Segment</th>
                                                                    <td>{{ $prods->target_segment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Application Number</th>
                                                                    <td>{{ $apps->app_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Application Approval Date</th>
                                                                    <td>{{ date('d-m-Y', strtotime($apps->approval_dt)) }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Project Details</th>
                                                    <td>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 40%" class='pl-4'>Committed Annual
                                                                        Capacity (MT)</th>
                                                                    <td style="width: 60%">{{ $eva_det->capacity }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Installed Annual Capacity(MT)</th>
                                                                    <td>
                                                                        @if ($pd)
                                                                            {{ $pd->annual_capacity }}
                                                                        @else
                                                                            NA
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Committed Investment (₹ in crore)</th>
                                                                    <td>{{ $eva_det->investment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Quoted Sales Price (₹ / kg) </th>
                                                                    <td>{{ $eva_det->price }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status Of Commerical Date</th>
                                                    <td>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 40%" class='pl-4'>Scheduled
                                                                        Commercial
                                                                        Date</th>
                                                                    <td style="width: 60%">
                                                                        {{ $proposal_det->prod_date }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Whether the committed annual production capacity of
                                                                        eligible product has been installed and COD has been
                                                                        achieved?</th>
                                                                    <td>
                                                                        @if ($scod->committed_annual == 'yes')
                                                                            Yes
                                                                        @elseif ($scod->committed_annual == 'no')
                                                                            No
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    @if ($scod->committed_annual == 'yes')
                                                                        <th>Actual Date of Commercial Operations</th>
                                                                        <td>{{ $scod->commercial_op }}</td>
                                                                    @else
                                                                        <th>Expected Date of Commercial Operations</th>
                                                                        <td>
                                                                            @if ($scod->commercial_op)
                                                                                {{ $scod->commercial_op }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Manufacturing Location for Greenfield</th>
                                                    <td>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Address</th>
                                                                    <th>State</th>
                                                                    <th>City</th>
                                                                    <th>Pin Code</th>
                                                                </tr>
                                                                @foreach ($green_mAddress as $item)
                                                                    {{-- {{dd($item->state)}} --}}
                                                                    <tr>
                                                                        <td>{{ $item->address }}</td>
                                                                        <td>
                                                                            @if ($item->state)
                                                                                {{ $item->state }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->city)
                                                                                {{ $item->city }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->pincode)
                                                                                {{ $item->pincode }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th
                                                                        style="width: 50%;  text-align: center; padding: -100px">
                                                                        Product Name</th>
                                                                    <th
                                                                        style="width: 30%; text-align: center; padding: -100px">
                                                                        Product Capacity (MT)</th>
                                                                </tr>
                                                                @foreach ($prod_capacity as $item)
                                                                    <tr>
                                                                        @if ($item->type == 'green')
                                                                            <td>{{ $item->product }}</td>
                                                                            <td style="text-align: center;">
                                                                                {{ $item->capacity }}</td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Manufacturing Location for Others</th>
                                                    <td>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Address</th>
                                                                    <th>State</th>
                                                                    <th>City</th>
                                                                    <th>Pin Code</th>
                                                                </tr>
                                                                @foreach ($other_mAddress as $item)
                                                                    <tr>
                                                                        <td>{{ $item->address }}</td>
                                                                        <td>
                                                                            @if ($item->state)
                                                                                {{ $item->state }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->city)
                                                                                {{ $item->city }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->pincode)
                                                                                {{ $item->pincode }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th
                                                                        style="width: 50%;  text-align: center; padding: -100px">
                                                                        Product Name</th>
                                                                    <th
                                                                        style="width: 30%; text-align: center; padding: -100px">
                                                                        Product Capacity (MT)</th>
                                                                </tr>
                                                                @foreach ($prod_capacity as $item)
                                                                    <tr>
                                                                        @if ($item->type == 'other')
                                                                            <td>{{ $item->product }}</td>
                                                                            <td style="text-align: center;">
                                                                                {{ $item->capacity }}</td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Means of Finance</th>
                                                    <td>
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">Particulars</th>
                                                                    <th class="text-center">Amount (₹ in crore)</th>
                                                                    <th class="text-center">Status and Arrangement</th>
                                                                    <th class="text-center">Remarks</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Equity</td>
                                                                    <td class="text-center">{{ $mf->eAmount }}</td>
                                                                    <td class="text-center">
                                                                        @if ($mf->eStatus == 'yes')
                                                                            Yes
                                                                        @elseif ($mf->eStatus == 'no')
                                                                            NO
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $mf->eRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Debt</td>
                                                                    <td class="text-center">{{ $mf->dAmount }}</td>
                                                                    <td class="text-center">
                                                                        @if ($mf->dStatus == 'yes')
                                                                            Yes
                                                                        @elseif ($mf->dStatus == 'no')
                                                                            NO
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $mf->dRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Internal Accrual </td>
                                                                    <td class="text-center">{{ $mf->iAmount }}</td>
                                                                    <td class="text-center">
                                                                        @if ($mf->iStatus == 'yes')
                                                                            Yes
                                                                        @elseif ($mf->iStatus == 'no')
                                                                            NO
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $mf->iRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td class="text-center">{{ $mf->tAmount }}</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ppTabContent" role="tabpanel" aria-labelledby="docTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-header bg-gradient-info">
                                    <b>Project Progress</b>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <th style="width:15%" class='pl-4'>Project Details -Progress Report
                                                    </th>
                                                    <td style="width:85%">
                                                        <table class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width:25%" class='pl-4'>Committed
                                                                        Investment (₹ in crore)
                                                                    </th>
                                                                    <td style="width:75%">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Total')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                {{-- {{dd($oldcolumnName)}} --}}
                                                                @if ($qrrName == $year . '01')
                                                                    <tr>
                                                                        <th>Actual Investment upto March
                                                                            {{ $year }} (₹ in crore)</th>
                                                                        <td>{{ $finProg->totprevExpense }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th style="width:25%" class='pl-4'>Actual
                                                                            Investment upto June {{ $year }} (₹ in
                                                                            crore)</th>
                                                                        <td style="width:75%">
                                                                            {{ $finProg->totcurrExpense }}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <th>Actual Investment upto
                                                                            {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                                            (₹ in crore)</th>
                                                                        <td>{{ $finProg->totprevExpense }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th style="width:25%" class='pl-4'>Actual
                                                                            Investment upto
                                                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                            (₹ in crore)</th>
                                                                        <td style="width:75%">
                                                                            {{ $finProg->totcurrExpense }}</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Financial Progress</th>
                                                    <td>
                                                        <table class="table table-sm  table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">Particulars</th>
                                                                    <th class="text-center">Committed Investment (₹ in
                                                                        crore)
                                                                    </th>
                                                                    @if ($qrrName == $year . '01')
                                                                        <th class="text-center">Actual Investment
                                                                            upto March {{ $year }} (₹ in crore)
                                                                        </th>
                                                                        <th class="text-center">Actual Investment
                                                                            upto June {{ $year }} (₹ in crore)</th>
                                                                    @else
                                                                        <th class="text-center">Actual Investment
                                                                            upto
                                                                            {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}(₹
                                                                            in crore)</th>
                                                                        <th class="text-center">Actual Investment
                                                                            upto
                                                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                            (₹ in crore)</th>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td>Building</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Building')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->bprevExpense }}
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->bcurrExpense }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Plant & Machinery (Production)
                                                                        (Provide details of storage tanks,major components
                                                                        like reactors, production line etc.)</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == ' Plant and Machinery (Production)')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->pprevExpense }}
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->pcurrExpense }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lab Equipment and Instruments</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Laboratory Equipment and Instruments')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->lprevExpense }}
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->lcurrExpense }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Establishment of R&D facility</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == "Establishment of Research and Development (R'&'D) Facility")
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->eprevExpense }}
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->ecurrExpense }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>R&D Equipment & Instruments</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == "R'&'D Equipment and Instruments")
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->rdprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->rdcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Effluent Treatment Plant and its lines</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Effluent Treatment Plant and its Lines')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->efprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->efcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Solid Waste Management System</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Solid Waste Management System')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->solidprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->solidcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>HVAC System</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'HVAC System')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->hprevExpense }}
                                                                    </td>
                                                                    <td class="text-center">{{ $finProg->hcurrExpense }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Water System</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Water System')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->wsprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->wscurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Raw Water</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == '')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->rwprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->rwcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Soft Water</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == '')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->swprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->swcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DM Water</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == '')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->dmprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->dmcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Steam</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Steam')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @isset($finProg->stmprevExpense)
                                                                            {{ $finProg->stmprevExpense }}
                                                                        @else
                                                                            0.00
                                                                        @endisset
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @isset($finProg->stmcurrExpense)
                                                                            {{ $finProg->stmcurrExpense }}
                                                                        @else
                                                                            0.00
                                                                        @endisset
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Compressed Air</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Compressed Air')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->caprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->cacurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cold Water System</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Chilling System')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->coprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->cocurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Boiler</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Boiler')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->boprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->bocurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Power Generation & Distribution System</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Power Generation and Distribution System')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->poprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->pocurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Storage Tanks</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Storage Tanks')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->stprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->stcurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Miscellaneous</td>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Miscellaneous')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->misprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->miscurrExpense }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <td class="text-center">
                                                                        @foreach ($proposeInvest as $item)
                                                                            @if ($item->name == 'Total')
                                                                                {{ $item->amt }}
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->totprevExpense }}</td>
                                                                    <td class="text-center">
                                                                        {{ $finProg->totcurrExpense }}</td>

                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width:15%" class=''>Status of Land for Greenfield
                                                        Project
                                                    </th>
                                                    <td style="width:85%">
                                                        <table class="table table-sm  table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">Address</th>
                                                                    <th class="text-center">State</th>
                                                                    <th class="text-center">City</th>
                                                                    <th class="text-center">Pin Code</th>
                                                                    <th class="text-center">Freehold / Leasehold</th>
                                                                    <th class="text-center">Area (Acre)</th>
                                                                    <th class="text-center">Status of acquisition</th>
                                                                </tr>
                                                                @foreach ($address as $item)
                                                                    <tr>
                                                                        <th>{{ $item->address }}</th>
                                                                        <td>
                                                                            @if ($item->state)
                                                                                {{ $item->state }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->city)
                                                                                {{ $item->city }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($item->pincode)
                                                                                {{ $item->pincode }}
                                                                            @else
                                                                                NA
                                                                            @endif
                                                                        </td>
                                                                        @foreach ($statusLand as $sl)
                                                                            @if ($sl->mid == $item->id)
                                                                                <td>
                                                                                    @if ($sl->freeleash == 'freehold')
                                                                                        Freehold
                                                                                    @elseif($sl->freeleash == 'leasehold')
                                                                                        Leasehold
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $sl->area }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $sl->acqusition }}</td>
                                                                            @endif
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Physical Progress</th>
                                                    <td>
                                                        <table class="table table-sm  table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 20%;" class="text-center">Major
                                                                        Capital Expenditure Heads</th>
                                                                    <th style="width: 10%;" class="text-center">Area in
                                                                        sq. ft./ Estimated Capacity</th>
                                                                    <th style="width: 15%;" class="text-center">Schedule
                                                                        Start Date of Construction / Installation</th>
                                                                    <th style="width: 15%;" class="text-center">
                                                                        Scheduled Completion Date </th>
                                                                    <th style="width: 40%;">Brief Status on Progress</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Building</td>
                                                                    <td class="text-center">{{ $physicalProg->bArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->bStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->bCompDate }}</td>
                                                                    <td>{{ $physicalProg->bRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Office</td>
                                                                    <td class="text-center">{{ $physicalProg->oArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->oStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->oCompDate }}</td>
                                                                    <td>{{ $physicalProg->oRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Canteen</td>
                                                                    <td class="text-center">{{ $physicalProg->cArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->cStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->cCompDate }}</td>
                                                                    <td>{{ $physicalProg->cRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Utilities</td>
                                                                    <td class="text-center">{{ $physicalProg->uArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->uStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->uCompDate }}</td>
                                                                    <td>{{ $physicalProg->uRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Plant & Machinery</td>
                                                                    <td class="text-center">{{ $physicalProg->pArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->pStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->pCompDate }}</td>
                                                                    <td>{{ $physicalProg->pRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Laboratory Equipment & Investment</td>
                                                                    <td class="text-center">{{ $physicalProg->lArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->lStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->lCompDate }}</td>
                                                                    <td>{{ $physicalProg->lRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>R & D Equipment & Instrument</td>
                                                                    <td class="text-center">{{ $physicalProg->rArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->rStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->rCompDate }}</td>
                                                                    <td>{{ $physicalProg->rRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Effluent Treatment Plant </td>
                                                                    <td class="text-center">{{ $physicalProg->eArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->eStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->eCompDate }}</td>
                                                                    <td>{{ $physicalProg->eRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Solid Waste Management (SWM) </td>
                                                                    <td class="text-center">{{ $physicalProg->sArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->sStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->sCompDate }}</td>
                                                                    <td>{{ $physicalProg->sRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Heating, Ventilating and Air Conditioning System
                                                                        (HVAC)</td>
                                                                    <td class="text-center">{{ $physicalProg->hArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->hStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->hCompDate }}</td>
                                                                    <td>{{ $physicalProg->hRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Water System</td>
                                                                    <td class="text-center">{{ $physicalProg->wArea }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->wStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->wCompDate }}</td>
                                                                    <td>{{ $physicalProg->wRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Raw Water</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->rwArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->rwStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->rwCompDate }}</td>
                                                                    <td>{{ $physicalProg->rwRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Soft Water</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->swArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->swStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->swCompDate }}</td>
                                                                    <td>{{ $physicalProg->swRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DM Water</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->dmwArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->dmwStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->dmwCompDate }}</td>
                                                                    <td>{{ $physicalProg->dmwRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Steam</td>
                                                                    <td class="text-center">
                                                                        @isset($physicalProg->stmArea)
                                                                            {{ $physicalProg->stmArea }}
                                                                        @else
                                                                            NA
                                                                        @endisset
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @isset($physicalProg->stmStartDate)
                                                                            {{ $physicalProg->stmStartDate }}
                                                                        @else
                                                                            NA
                                                                        @endisset
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @isset($physicalProg->stmCompDate)
                                                                            {{ $physicalProg->stmCompDate }}
                                                                        @else
                                                                            NA
                                                                        @endisset
                                                                    </td>
                                                                    <td>
                                                                        @isset($physicalProg->stmRemarks)
                                                                            {{ $physicalProg->stmRemarks }}
                                                                        @else
                                                                            NA
                                                                        @endisset
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Compressed Air</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->caArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->caStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->caCompDate }}</td>
                                                                    <td>{{ $physicalProg->caRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cold Water System</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->coArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->coStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->coCompDate }}</td>
                                                                    <td>{{ $physicalProg->coRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Boiler</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->boArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->boStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->boCompDate }}</td>
                                                                    <td>{{ $physicalProg->boRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Power Generation & Distribution System</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->pgArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->pgStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->pgCompDate }}</td>
                                                                    <td>{{ $physicalProg->pgRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Storage Tanks</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->stArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->stStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->stCompDate }}</td>
                                                                    <td>{{ $physicalProg->stRemarks }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Miscellaneous</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->misArea }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->misStartDate }}</td>
                                                                    <td class="text-center">
                                                                        {{ $physicalProg->misCompDate }}</td>
                                                                    <td>{{ $physicalProg->misRemarks }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="approvalTab" role="tabpanel" aria-labelledby="docTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-header bg-gradient-info">
                                    <b>Approval Details</b>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover"
                                            id="tablePrevMat">
                                            <thead class="table-primary">
                                                <th class="w-40" style=" width: 29%;">Approvals / Certification
                                                    Required</th>
                                                <th class="w-30">Concerned Authority</th>
                                                <th class="w-5">Availability of Approval (Yes/No)</th>
                                                <th class="w-5">Validity of approval (If Available)</th>
                                                <th class="w-5">Expected Date of Approval (if not available)
                                                </th>
                                                <th class="w-15"> Inputs on any specific handholding required for
                                                    any approval process</th>

                                                <thead>

                                                <tbody>
                                                    @foreach ($approvalsDetails as $key => $item)
                                                        <tr>
                                                            <td>{{ $item->reqapproval }}</td>
                                                            <td>{{ $item->concernbody }}</td>
                                                            <td>
                                                                @if ($item->isapproval == 'Y')
                                                                    YES
                                                                @elseif($item->isapproval == 'N')
                                                                    NO
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->dtvalidity }}</td>
                                                            <td>{{ $item->dtexpected }}</td>
                                                            <td>{{ $item->process }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="revenueTabContent" role="tabpanel"
                            aria-labelledby="docTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-header bg-gradient-info">
                                    <b>Revenue</b>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm  table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <th style="width:15%">Revenue from Operations -[net of credit notes,
                                                        discounts and taxes applicable]</th>
                                                    <td style="width:85%">
                                                        <table class="table table-sm  table-bordered table-hover">
                                                            <tbody>
                                                                @if ($qrrName == $year . '01')
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center" colspan="2">
                                                                            {{ $year }}-{{ substr($year, -2) + 1 }}
                                                                        </th>
                                                                        <th class="text-center" colspan="2">For quarter
                                                                            ended {{ $year }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center">Quantity (kg)</th>
                                                                        <th class="text-center">Sales for
                                                                            {{ $year }}-{{ substr($year, -2) + 1 }}
                                                                            (₹)</th>
                                                                        <th class="text-center">Quantity (kg)</th>
                                                                        <th class="text-center">Sales in quarter ended
                                                                            30th June {{ $year }} (₹)</th>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center" colspan="2">For quarter
                                                                            ended
                                                                            {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                                        </th>
                                                                        <th class="text-center" colspan="2">For quarter
                                                                            ended
                                                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center">Quantity (kg)</th>
                                                                        <th class="text-center">Sales for
                                                                            {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                                            (₹)
                                                                        </th>
                                                                        <th class="text-center">Quantity (Kg)</th>
                                                                        <th class="text-center">Sales in quarter ended
                                                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                            (₹)
                                                                        </th>
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
                                                                    <th>i. Revenue from Eligible Product (Greenfield
                                                                        Capacity)</th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(a) Domestic Sales</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcDomPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcDomPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcDomCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcDomCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(b) Export</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcExpPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcExpPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcExpCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcExpCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(c) Captive Consumption</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcCapPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcCapPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcCapCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcCapCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total (i)</th>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcTotPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcTotPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->gcTotCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->gcTotCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>ii. Revenue from Existing Capacity of Eligible
                                                                        Product </th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(a) Domestic Sales</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecDomPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecDomPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecDomCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecDomCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(b) Export</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecExpPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecExpPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecExpCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecExpCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>(c) Captive Consumption</td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecCapPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecCapPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecCapCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecCapCurrSales }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total (ii)</th>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecTotPrevQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecTotPrevSales }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $rev->ecTotCurrQuantity }}</td>
                                                                    <td class="text-center">{{ $rev->ecTotCurrSales }}
                                                                    </td>
                                                                </tr>
                                                </tr>
                                                <tr>
                                                    <th>iii. Other than Eligible Product</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>(a) Domestic Sales</td>
                                                    <td class="text-center">{{ $rev->otDomPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otDomPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->otDomCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otDomCurrSales }}</td>
                                                </tr>
                                                <tr>
                                                    <td>(b) Export</td>
                                                    <td class="text-center">{{ $rev->otExpPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otExpPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->otExpCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otExpCurrSales }}</td>
                                                </tr>

                                                <tr>
                                                    <td>(c) Captive Consumption</td>
                                                    <td class="text-center">{{ $rev->otCapPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otCapPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->otCapCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otCapCurrSales }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total (iii)</th>
                                                    <td class="text-center">{{ $rev->otTotPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otTotPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->otTotCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otTotCurrSales }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Other Activities</th>
                                                    <td class="text-center">{{ $rev->otherPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otherPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->otherCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->otherCurrSales }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Revenue</th>
                                                    <td class="text-center">{{ $rev->totPrevQuantity }}</td>
                                                    <td class="text-center">{{ $rev->totPrevSales }}</td>
                                                    <td class="text-center">{{ $rev->totCurrQuantity }}</td>
                                                    <td class="text-center">{{ $rev->totCurrSales }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </td>
                                        </tr>
                                        <tr>
                                            <th style="width:15%">Employment as on Date for Greenfield Project (in absolute
                                                numbers)</th>
                                            <td style="width:85%">
                                                <table class="table table-sm  table-bordered table-hover">
                                                    <tbody>
                                                        @if ($qrrName == $year . '01')
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">As on 31/03/{{ $year }}
                                                                </th>
                                                                <th class="text-center">As on 30/06/{{ $year }}
                                                                </th>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">As on
                                                                    {{ $oldcolumnName->qtr_date }}</th>
                                                                <th class="text-center">As on
                                                                    {{ $currcolumnName->qtr_date }}</th>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th class="text-center">Particulars</th>
                                                            <th class="text-center">No.</th>
                                                            <th class="text-center">No.</th>
                                                        </tr>
                                                        <tr>
                                                            <th>On-roll labor</th>
                                                            <td class="text-center">{{ $greenfield->laborPrevNo }}
                                                            </td>
                                                            <td class="text-center">{{ $greenfield->laborCurrNo }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>On-roll employees</th>
                                                            <td class="text-center">{{ $greenfield->empPrevNo }}</td>
                                                            <td class="text-center">{{ $greenfield->empCurrNo }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contractual</th>
                                                            <td class="text-center">{{ $greenfield->conPrevNo }}</td>
                                                            <td class="text-center">{{ $greenfield->conCurrNo }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Apprentice</th>
                                                            <td class="text-center">{{ $greenfield->appPrevNo }}</td>
                                                            <td class="text-center">{{ $greenfield->appCurrNo }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total</th>
                                                            <td class="text-center">{{ $greenfield->totPrevNo }}</td>
                                                            <td class="text-center">{{ $greenfield->totCurrNo }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:15%">Domestic Value Addition</th>
                                            <td style="width:85%">
                                                <table class="table table-sm table-striped table-bordered table-hover">
                                                    <tbody>
                                                        @if ($qrrName == $year . '01')
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center" colspan="3">For
                                                                    {{ $year }}-{{ substr($year, -2) + 1 }}</th>
                                                                <th class="text-center" colspan="3">For quarter ended
                                                                    30th June {{ $year }}</th>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center" colspan="3">For
                                                                    {{ $oldcolumnName->qtr_date }}</th>
                                                                <th class="text-center" colspan="3">For quarter ended
                                                                    {{ $currcolumnName->qtr_date }}</th>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th class="text-center">Key Parameters</th>
                                                            <th class="text-center">Quantity (Kg)</th>
                                                            <th class="text-center"> Cost Price (₹ in crore)</th>
                                                            <th class="text-center">Amount (₹ in crore)</th>
                                                            <th class="text-center">Quantity (Kg)</th>
                                                            <th class="text-center">Cost Price (₹ in crore)</th>
                                                            <th class="text-center">Amount (₹ in crore)</th>
                                                        </tr>
                                                        <tr>
                                                            <th>(A)- Eligible Product Manufactured </th>
                                                            <td class="text-center">{{ $dva->EPprevquant }}</td>
                                                            <td class="text-center">{{ $dva->EPprevsales }}</td>
                                                            <td class="text-center">{{ $dva->EPprevamount }}</td>
                                                            <td class="text-center">{{ $dva->EPcurrquant }}</td>
                                                            <td class="text-center">{{ $dva->EPcurrsales }}</td>
                                                            <td class="text-center">{{ $dva->EPcurramount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>(B)- Consumption of Non-Originating Material & Services
                                                            </th>
                                                            <td class="text-center">{{ $dva->totConprevquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->totConprevamount }}</td>
                                                            <td class="text-center">{{ $dva->totConcurrquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->totConcurramount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>- Non-Originating Material & Consumables </th>
                                                            <td class="text-center">{{ $dva->matprevquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->matprevamount }}</td>
                                                            <td class="text-center">{{ $dva->matcurrquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->matcurramount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>- Non-Originating Services </th>
                                                            <td class="text-center">{{ $dva->serprevquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->serprevamount }}</td>
                                                            <td class="text-center">{{ $dva->sercurrquant }}</td>
                                                            <td></td>
                                                            <td class="text-center">{{ $dva->sercurramount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Domestic Value Addition % (B-A)/(B)</th>
                                                            <td></td>
                                                            <td></td>
                                                            @if ($dva->EPprevamount != 0)
                                                                <td class="text-center">
                                                                    {{ number_format((($dva->EPprevamount - ($dva->matprevamount + $dva->serprevamount)) / $dva->EPprevamount) * 100, 2) }}
                                                                </td>
                                                                {{-- @if ($dva->prevDVATotal != 0)
                                                                <td class="text-center">{{ $dva->prevDVATotal }}</td>
                                                            @else
                                                                <td class="text-center">{{number_format((((($dva->EPprevamount)-($dva->matprevamount + $dva->serprevamount))/($dva->EPprevamount))*100), 2)}}</td>
                                                            @endif --}}
                                                            @else
                                                                <td class="text-center">{{ $dva->prevDVATotal }}</td>
                                                            @endif
                                                            <td></td>
                                                            <td></td>
                                                            @if ($dva->EPcurramount != 0)
                                                                <td class="text-center">
                                                                    {{ number_format((($dva->EPcurramount - ($dva->matcurramount + $dva->sercurramount)) / $dva->EPcurramount) * 100, 2) }}
                                                                </td>
                                                                {{-- @if ($dva->currDVATotal != 0)
                                                                <td class="text-center">{{ $dva->currDVATotal }}</td>
                                                            @else
                                                                <td class="text-center">{{number_format((((($dva->EPcurramount)-($dva->matcurramount + $dva->sercurramount))/($dva->EPcurramount))*100), 2)}}</td>
                                                            @endif --}}
                                                            @else
                                                                <td class="text-center">{{ $dva->currDVATotal }}</td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            @if ($qrrName == $year . '01')
                                                <th>Breakup of Non-Originating Raw Material for {{$year}}-{{substr($year, -2)+1}}</th>
                                            @else
                                                <th>Breakup of Non-Originating Raw Material for quarter ended {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}}</th>
                                            @endif
                                            <td>
                                                <table class="table table-bordered table-hover table-sm" id="tablePrevMat">
                                                    <thead>
                                                        <tr>@if ($qrrName == $year . '01')
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and
                                                                Services For {{$year}}-{{substr($year, -2)+1}}</th>
                                                            @else
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and
                                                                Services For {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}}</th>
                                                            @endif
                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (Kg)</th>
                                                            <th class="w-20">Amount (₹ in crore)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($matprev as $key => $item)
                                                            <tr>
                                                                <td>{{ $item->mattprevparticulars }}</td>
                                                                <td>{{ $item->mattprevcountry }}</td>
                                                                <td class="text-center">{{ $item->mattprevquantity }}
                                                                </td>
                                                                <td class="text-center">{{ $item->mattprevamount }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td class="text-center">
                                                                {{ getSum($item->getTable(), 'mattprevamount', $item->qrr_id) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> --}}
                                        {{-- <tr>
                                            @if ($qrrName == $year . '01')
                                                <th>Breakup of Non-Originating Services for {{$year}}-{{substr($year, -2)+1}}</th>
                                            @else
                                                <th>Breakup of Non-Originating Services for quarter ended {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}}</th>

                                            @endif
                                            <td>
                                                <table class="table table-bordered table-hover table-sm" id="tablePrevMat">
                                                    <thead>
                                                        <tr>
                                                            @if ($qrrName == $year . '01')
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and Services For {{$year}}-{{substr($year, -2)+1}}</th>
                                                            @else
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and
                                                                Services For {{$oldcolumnName->month}}-{{$oldcolumnName->yr_short}}</th>
                                                            @endif
                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (Kg)</th>
                                                            <th class="w-20">Amount (₹ in crore)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($serprev as $key => $item)
                                                            <tr>
                                                                <td>{{ $item->serrprevparticulars }}</td>
                                                                <td>{{ $item->serrprevcountry }}</td>
                                                                <td class="text-center">{{ $item->serrprevquantity }}
                                                                </td>
                                                                <td class="text-center">{{ $item->serrprevamount }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td class="text-center">
                                                                {{ getSum($item->getTable(), 'serrprevamount', $item->qrr_id) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> --}}
                                        {{-- <tr>
                                            @if ($qrrName == $year . '01')
                                                <th>Breakup of Non-Originating Raw Material for quarter endedn 30th June
                                                    {{$year}}</th>
                                            @else
                                                <th>Breakup of Non-Originating Raw Material for quarter endedn {{$currcolumnName->month}}-{{$currcolumnName->yr_short}}
                                                </th>

                                            @endif
                                            <td>
                                                <table class="table table-bordered table-hover table-sm" id="tablePrevMat">
                                                    <thead>
                                                        <tr>
                                                            @if ($qrrName == $year . '01')
                                                            <th class="w-35">Breakup of non-originating Raw Material and
                                                                Services For {{$year}}-{{substr($year, -2)+1}}</th>
                                                            @else
                                                            <th class="w-35">Breakup of non-originating Raw Material and
                                                                Services For  {{$currcolumnName->month}}-{{$currcolumnName->yr_short}}</th>
                                                            @endif

                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (Kg)</th>
                                                            <th class="w-20">Amount (₹ in crore)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($mat) > 0)
                                                        @foreach ($mat as $key => $item)
                                                            <tr>
                                                                <td>{{ $item->mattparticulars }}</td>
                                                                <td>{{ $item->mattcountry }}</td>
                                                                <td class="text-center">{{ $item->mattquantity }}</td>
                                                                <td class="text-center">{{ $item->mattamount }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td class="text-center">
                                                                {{ getSum($item->getTable(), 'mattamount', $item->qrr_id) }}
                                                            </td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <td>0</td>
                                                            <td>NA</td>
                                                            <td class="text-center">0</td>
                                                            <td class="text-center">0</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <td class="text-center">
                                                                0.0
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> --}}
                                        {{-- <tr>
                                            @if ($qrrName == $year . '01')
                                                <th>Breakup of Non-Originating Services for quarter endedn 30th June {{$year}}
                                                </th>
                                            @else
                                                <th>Breakup of Non-Originating Services for quarter endedn {{$currcolumnName->month}}-{{$currcolumnName->yr_short}}</th>
                                            @endif
                                            <td>
                                                <table class="table table-bordered table-hover table-sm" id="tablePrevMat">
                                                    <thead>
                                                        <tr>
                                                            @if ($qrrName == $year . '01')
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and
                                                                Services For {{$year}}-{{substr($year, -2)+1}}</th>
                                                            @else
                                                            <th class="w-35">Breakup of Non-Originating Raw Material and
                                                                Services For {{$currcolumnName->month}}-{{$currcolumnName->yr_short}}</th>
                                                            @endif
                                                            <th class="w-20">Country of Origin</th>
                                                            <th class="w-20">Quantity (Kg)</th>
                                                            <th class="w-20">Amount (₹ in crore)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($ser) > 0)
                                                            @foreach ($ser as $key => $item)
                                                                <tr>
                                                                    <td>{{ $item->serrparticulars }}</td>
                                                                    <td>{{ $item->serrcountry }}</td>
                                                                    <td class="text-center">{{ $item->serrquantity }}
                                                                    </td>
                                                                    <td class="text-center">{{ $item->serramount }}
                                                                    </td>
                                                                </tr>
                                                            <tr>
                                                                <th colspan="3">Total</th>
                                                                <td class="text-center">
                                                                    {{ getSum($item->getTable(), 'serramount', $item->qrr_id) }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        @else
                                                        <tr>
                                                            <td>0</td>
                                                            <td>NA</td>
                                                            <td class="text-center">0
                                                            </td>
                                                            <td class="text-center">0
                                                            </td>
                                                        </tr>
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <td class="text-center">
                                                            0.0
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> --}}
                                        {{-- New Template --}}
                                        <tr>
                                            <th style="width:15%">Breakup of Non-Originating Material & Consumables </th>
                                            <td style="width:85%">
                                                <table class="table table-sm  table-hover">
                                                    <thead>
                                                        <tr>
                                                            @if ($qrrName == $year . '01')
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $year }}-{{ substr($year, -2) + 1 }}</th>
                                                                <th class="text-center" colspan="4">For
                                                                    June-{{ substr($year, -2) }}</th>
                                                            @else
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                                </th>
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td colspan="4">
                                                            <table class="table  table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="w-40">Breakup of Non-Originating Raw
                                                                            Material and Services</th>
                                                                        <th class="w-20 text-center">Country of Origin</th>
                                                                        <th class="w-15 text-center">Quantity <br>(Kg)</th>
                                                                        <th class="w-20 text-center">Amount <br>(₹ in
                                                                            crore)</th>
                                                                    </tr>
                                                                    @foreach ($matprev as $key => $item)
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                {{ $item->mattprevparticulars }}</td>
                                                                            <td class="text-center">
                                                                                {{ $item->mattprevcountry }}</td>
                                                                            <td class="text-center">
                                                                                {{ $item->mattprevquantity }}</td>
                                                                            <td class="text-center">
                                                                                {{ $item->mattprevamount }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <th colspan="3">Total</th>
                                                                        <td class="text-center">
                                                                            {{ getSum($item->getTable(), 'mattamount', $item->qrr_id) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td colspan="4">
                                                            <table class="table  table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="w-40">Breakup of Non-Originating Raw
                                                                            Material and Services</th>
                                                                        <th class="w-20 text-center">Country of Origin</th>
                                                                        <th class="w-15 text-center">Quantity <br>(Kg)</th>
                                                                        <th class="w-20 text-center">Amount <br>(₹ in
                                                                            crore)</th>
                                                                    </tr>
                                                                    @if (count($mat) > 0)
                                                                        @foreach ($mat as $key => $item)
                                                                            <tr>
                                                                                <td>{{ $item->mattparticulars }}</td>
                                                                                <td>{{ $item->mattcountry }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $item->mattquantity }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $item->mattamount }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <td class="text-center">
                                                                                @if ($item->getTable() == 'dva_breakdown_mat')
                                                                                    {{ getSum($item->getTable(), 'mattamount', $item->qrr_id) }}
                                                                                @else
                                                                                    {{ getSum($item->getTable(), 'mattprevamount', $item->qrr_id) }}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td>0</td>
                                                                            <td>NA</td>
                                                                            <td class="text-center">0</td>
                                                                            <td class="text-center">0</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <td class="text-center">
                                                                                0.0
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th style="width:15%">Breakup of Non-Originating Services</th>
                                            <td style="width:85%">
                                                <table class="table table-sm  table-hover">
                                                    <thead>
                                                        <tr>
                                                            @if ($qrrName == $year . '01')
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $year }}-{{ substr($year, -2) + 1 }}</th>
                                                                <th class="text-center" colspan="4">For
                                                                    June-{{ substr($year, -2) }}</th>
                                                            @else
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $oldcolumnName->month }}-{{ $oldcolumnName->yr_short }}
                                                                </th>
                                                                <th class="text-center" colspan="4">For
                                                                    {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td colspan="4">
                                                            <table class="table  table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="w-40">Breakup of Non-Originating Raw
                                                                            Material and Services</th>
                                                                        <th class="w-20 text-center">Country of Origin</th>
                                                                        <th class="w-15 text-center">Quantity <br>(Kg)</th>
                                                                        <th class="w-20 text-center">Amount <br>(₹ in
                                                                            crore)</th>
                                                                    </tr>
                                                                    @if (count($serprev) > 0)
                                                                        @foreach ($serprev as $key => $item)
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    {{ $item->serrprevparticulars }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $item->serrprevcountry }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $item->serrprevquantity }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $item->serrprevamount }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <td class="text-center">
                                                                                @if ($item->getTable() == 'dva_breakdown_ser')
                                                                                    {{ getSum($item->getTable(), 'serramount', $item->qrr_id) }}
                                                                                @else
                                                                                    {{ getSum($item->getTable(), 'serrprevamount', $item->qrr_id) }}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td colspan="4">
                                                            <table class="table  table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="w-40">Breakup of Non-Originating Raw
                                                                            Material and Services</th>
                                                                        <th class="w-20 text-center">Country of Origin</th>
                                                                        <th class="w-15 text-center">Quantity <br>(Kg)</th>
                                                                        <th class="w-20 text-center">Amount <br>(₹ in
                                                                            crore)</th>
                                                                    </tr>
                                                                    @if (count($ser) > 0)
                                                                        @foreach ($ser as $key => $item)
                                                                            <tr>
                                                                                <td>{{ $item->serrparticulars }}</td>
                                                                                <td>{{ $item->serrcountry }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $item->serrquantity }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $item->serramount }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th colspan="3">Total</th>
                                                                                <td class="text-center">
                                                                                    {{ getSum($item->getTable(), 'serramount', $item->qrr_id) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td>0</td>
                                                                            <td>NA</td>
                                                                            <td class="text-center">0
                                                                            </td>
                                                                            <td class="text-center">0
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th colspan="3">Total</th>
                                                                            <td class="text-center">
                                                                                0.0
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        {{-- End --}}
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="uploadTabContent" role="tabpanel"
                            aria-labelledby="docTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-header bg-gradient-info">
                                    <b>Uploads</b>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover uploadTable">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th class=" text-center">Photograph Name</th>
                                                </tr>
                                            </thead>
                                            <tbody class="applicant-uploads">
                                                <tr>
                                                    <th><b>Photograph of the factory gate covering surroundings</b> </th>

                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="text-align: center;padding : 8px">

                                                        @if (in_array('22', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '22')
                                                                    <img id="output1" width="1000" alt=""
                                                                        src="{{ $doc }}" />

                                                    <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                    @endif
                                                    @endforeach
                                                @else
                                                    <img id="output1" alt="" width="1000" />
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><b>Photograph of main building block for Plant and Machinery. In
                                                            case Plant and Machinery is being installed in existing
                                                            building, the photograph of site location</b>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;padding : 8px">
                                                        @if (in_array('23', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '23')
                                                                    <img id="output2" width="1000" alt=""
                                                                        src="{{ $doc }}" />
                                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img id="output2" alt="" width="1000" />
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th> Photograph 1 of area where reactors and main production line is to
                                                        be installed depicting installation work in progress<sup
                                                            class="text-danger">*</sup>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;padding : 8px">
                                                        @if (in_array('24', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '24')
                                                                    <img id="output3" alt="" width="1000"
                                                                        src="{{ $doc }}" />
                                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img id="output3" alt="" width="1000" />
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th> Photograph 2 of area where reactors and main production line is to
                                                        be installed depicting installation work in progress<sup
                                                            class="text-danger">*</sup>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;padding : 8px">
                                                        @if (in_array('25', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '25')
                                                                    <img id="outputt" alt="" width="1000"
                                                                        src="{{ $doc }}" />
                                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img id="outputt" alt="" width="1000" />
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Photograph of area where main utilities are proposed to be installed
                                                        like
                                                        Boiler, ZLD, Storage Tank, etc.</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;padding : 8px">
                                                        @if (in_array('26', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '26')
                                                                    <img id="output4" alt="" width="1000"
                                                                        src="{{ $doc }}" />
                                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img id="output4" alt="" width="1000" />
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Any Additional Document</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;padding : 8px">
                                                        @if (in_array('27', $docids))
                                                            @foreach ($docs as $key => $doc)
                                                                @if ($key == '27')
                                                                    <img id="output5" alt="" width="1000"
                                                                        src="{{ $doc }}" />
                                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', $contents->where('doc_id',$key)->first()->id) }}"><i class="fa fa-download"> Download File</i></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img id="output5" alt="" width="1000" />
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="">
                        <span style="float: right;" id="datetime">{{ Carbon\Carbon::now() }} &nbsp;@if ($qrrData->status == 'D')
                                Draft
                            @else
                                Submitted
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <div onclick="printPage();" class="btn btn-warning btn-sm form-control form-control-sm">
                        Print <i class="fas fa-print"></i>
                    </div>
                </div>
                @if ($qrrData->status == 'D')
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('qpr.submit', $qrrData->id) }}"
                            class="btn btn-success btn-sm form-control form-control-sm">
                            <i class="fas fa-angle-double-right"></i>Submit</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('user.partials.js.qprViewPrint')
@endpush
