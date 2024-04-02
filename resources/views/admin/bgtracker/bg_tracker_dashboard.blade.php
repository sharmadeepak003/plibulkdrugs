@extends('layouts.admin.master')

<style>
    .userstable-body {
        font-size: 13px !important;
    }
    th{
        font-size: 15px !important;
        padding: 8px;
    }
    td {
        padding: 8px;
    }
</style>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
    BG TRACKER - Dashboard
@endsection

@section('content')
    <div class="card-header text-bold">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="appPhase1" data-toggle="pill" href="#appPhase1Content" role="tab"
                            aria-controls="appPhase1Content" aria-selected="true">BG Round I</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase2" data-toggle="pill" href="#appPhase2Content" role="tab"
                            aria-controls="appPhase2Content" aria-selected="false">BG Round II</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase3" data-toggle="pill" href="#appPhase3Content" role="tab"
                            aria-controls="appPhase3Content" aria-selected="false">BG Round III</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="appPhase4" data-toggle="pill" href="#appPhase4Content" role="tab"
                            aria-controls="appPhase4Content" aria-selected="false">BG Round IV</a>
                    </li>
                    <li class="nav-item" style="margin-left: auto; padding-right:20; padding-top:5; padding-bottom:5">
                        <a href="{{ route('admin.bgtracker.bgExport') }}" class="btn btn-sm btn-warning">Excel Export <i class="fa fa-download" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{{--Round 1--}}
    <div class="tab-content">
        <div class="tab-pane fade active show" id="appPhase1Content" role="tabpanel" aria-labelledby="appPhase1Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>Approved Applicants</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " id="users" style="">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center ">Sr No</th>
                                            <th class="w-65 text-center ">Applicant Name</th>
                                            <th class="w-65 text-center ">Eligible Product</th>
                                            <th class="w-65 text-center ">Target Segment</th>
                                            <th class="w-65 text-center ">BG No.</th>
                                            <th class="w-65 text-center ">BG Amount (in ₹)</th>
                                            <th class="w-65 text-center ">Issue Date</th>
                                            <th class="w-65 text-center ">Expiry Date</th>
                                            <th class="w-65 text-center ">Claim Date</th>
                                            <th class="w-65 text-center ">BG Status</th>
                                            <th class="w-65 text-center ">BG</th>
                                        </tr>
                                    </thead>
                                    {{-- {{dd($apps)}} --}}
                                    <tbody class="userstable-body">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '1')
                                                <tr>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td class="w-65 p-1">
                                                        {{ $app->name }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center ">
                                                        {{ $app->product }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if ( $app->target_segment == 'A. Key Fermentation based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">A</p>
                                                        @elseif( $app->target_segment  == 'B. Fermentation based niche KSMs/Drug Intermediates/APIs')
                                                            <p class="font-weight-bold">B</p>
                                                        @elseif( $app->target_segment == 'C. Key Chemical Synthesis based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">C</p>
                                                        @elseif( $app->target_segment == 'D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs')
                                                            <p class="font-weight-bold">D</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_no }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_amount }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->issued_dt }}
                                                    </td>
                                                    @if ($date >= $app->expiry_dt && $app->expiry_dt != null)
                                                        <td class="alert-danger  text-center text-nowrap">
                                                            @if ($app->bg_status == 'IN')
                                                                {{ $app->expiry_dt }}
                                                            @elseif ($today > $app->expiry_dt && $app->expiry_dt != null)
                                                                <p class="font-weight-bold text-danger">BG Expired</p>
                                                                {{ $app->expiry_dt }}
                                                            @else
                                                                <p class="font-weight-bold text-danger">BG Expiring on</p>
                                                                {{ $app->expiry_dt }}
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="w-65 p-1 text-center text-nowrap">
                                                            {{ $app->expiry_dt }}
                                                        </td>
                                                    @endif
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->claim_dt }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{-- @if ($today > $app->expiry_dt && $app->expiry_dt != null) --}}
                                                        {{-- <p class="font-weight-bold text-danger">BG Expired</p> --}}
                                                        @if ($app->bg_status == 'IN')
                                                            <p class="font-weight-bold text-danger">Invoked</p>
                                                        @elseif($today > $app->expiry_dt && $app->expiry_dt != null)
                                                            <!-- <p class="font-weight-bold text-danger">BG Expired</p> -->
                                                            @if($app->bg_status == 'RE')
                                                            <p class="font-weight-bold text-success">Release</p>
                                                            @else
                                                            <p class="font-weight-bold text-danger">BG Expired</p>
                                                            @endif
                                                        @elseif($app->bg_status == 'RO')
                                                            <p class="font-weight-bold text-success">Roll Over</p>
                                                        @elseif($app->bg_status == 'RE')
                                                            <p class="font-weight-bold text-success">Release</p>
                                                        @elseif($app->bg_status == 'EX')
                                                            <p class="font-weight-bold text-black ">Existing</p>
                                                        @else
                                                            <p class="text-info">Not Submit</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-warning btn-sm btn-block"><i
                                                                        class="right fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        @elseif(AUTH::user()->hasRole('Admin-Ministry'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <p class="font-weight-bold text-black ">Waiting</p>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Round 2--}}
        <div class="tab-pane fade show" id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>Approved Applicants</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " id="users1">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center ">Sr No</th>
                                            <th class="w-75 text-center ">Applicant Name</th>
                                            <th class="w-50 text-center ">Eligible Product</th>
                                            <th class="w-65 text-center ">Target Segment</th>
                                            <th class="w-65 text-center ">BG No.</th>
                                            <th class="w-65 text-center ">BG Amount (in ₹)</th>
                                            <th class="w-65 text-center ">Issue Date</th>
                                            <th class="w-65 text-center ">Expiry Date</th>
                                            <th class="w-65 text-center ">Claim Date</th>
                                            <th class="w-65 text-center ">BG Status</th>
                                            <th class="w-65 text-center ">BG</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '2')
                                                <tr>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td class="w-75 p-1">
                                                        {{ $app->name }}
                                                    </td>
                                                    <td class="w-50 p-1 text-center ">
                                                        {{ $app->product }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if ( $app->target_segment == 'A. Key Fermentation based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">A</p>
                                                        @elseif( $app->target_segment  == 'B. Fermentation based niche KSMs/Drug Intermediates/APIs')
                                                            <p class="font-weight-bold">B</p>
                                                        @elseif( $app->target_segment == 'C. Key Chemical Synthesis based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">C</p>
                                                        @elseif( $app->target_segment == 'D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs')
                                                            <p class="font-weight-bold">D</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_no }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_amount }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->issued_dt }}
                                                    </td>
                                                    @if ($date >= $app->expiry_dt && $app->expiry_dt != null)
                                                        <td class="alert-danger  text-center text-nowrap">
                                                            @if ($app->bg_status == 'IN')
                                                                {{ $app->expiry_dt }}
                                                            @elseif ($today > $app->expiry_dt && $app->expiry_dt != null)
                                                                <p class="font-weight-bold text-danger">BG Expired</p>
                                                                {{ $app->expiry_dt }}
                                                            @else
                                                                <p class="font-weight-bold text-danger">BG Expiring on</p>
                                                                {{ $app->expiry_dt }}
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="w-65 p-1 text-center text-nowrap">
                                                            {{ $app->expiry_dt }}
                                                        </td>
                                                    @endif
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->claim_dt }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{-- @if ($today > $app->expiry_dt && $app->expiry_dt != null) --}}
                                                        {{-- <p class="font-weight-bold text-danger">BG Expired</p> --}}
                                                        @if ($app->bg_status == 'IN')
                                                            <p class="font-weight-bold text-danger">Invoked</p>
                                                        @elseif($today > $app->expiry_dt && $app->expiry_dt != null)
                                                            <p class="font-weight-bold text-danger">BG Expired</p>
                                                        @elseif($app->bg_status == 'RO')
                                                            <p class="font-weight-bold text-success">Roll Over</p>
                                                        @elseif($app->bg_status == 'RE')
                                                            <p class="font-weight-bold text-success">Release</p>
                                                        @elseif($app->bg_status == 'EX')
                                                            <p class="font-weight-bold text-black ">Existing</p>
                                                        @else
                                                            <p class="text-info">Not Submit</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-warning btn-sm btn-block"><i
                                                                        class="right fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        @elseif(AUTH::user()->hasRole('Admin-Ministry'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <p class="font-weight-bold text-black ">Waiting</p>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--Round 3--}}
        <div class="tab-pane fade show" id="appPhase3Content" role="tabpanel" aria-labelledby="appPhase3Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>Approved Applicants</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " id="users2">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center ">Sr No</th>
                                            <th class="w-65 text-center ">Applicant Name</th>
                                            <th class="w-65 text-center ">Eligible Product</th>
                                            <th class="w-65 text-center ">Target Segment</th>
                                            <th class="w-65 text-center ">BG No.</th>
                                            <th class="w-65 text-center ">BG Amount (in ₹)</th>
                                            <th class="w-65 text-center ">Issue Date</th>
                                            <th class="w-65 text-center ">Expiry Date</th>
                                            <th class="w-65 text-center ">Claim Date</th>
                                            <th class="w-65 text-center ">BG Status</th>
                                            <th class="w-65 text-center ">BG</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '3')
                                                <tr>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td class="w-65 p-1">
                                                        {{ $app->name }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center ">
                                                        {{ $app->product }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if ( $app->target_segment == 'A. Key Fermentation based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">A</p>
                                                        @elseif( $app->target_segment  == 'B. Fermentation based niche KSMs/Drug Intermediates/APIs')
                                                            <p class="font-weight-bold">B</p>
                                                        @elseif( $app->target_segment == 'C. Key Chemical Synthesis based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">C</p>
                                                        @elseif( $app->target_segment == 'D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs')
                                                            <p class="font-weight-bold">D</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_no }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_amount }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->issued_dt }}
                                                    </td>
                                                    @if ($date >= $app->expiry_dt && $app->expiry_dt != null)
                                                        <td class="alert-danger  text-center text-nowrap">
                                                            @if ($app->bg_status == 'IN')
                                                                {{ $app->expiry_dt }}
                                                            @elseif ($today > $app->expiry_dt && $app->expiry_dt != null)
                                                                <p class="font-weight-bold text-danger">BG Expired</p>
                                                                {{ $app->expiry_dt }}
                                                            @else
                                                                <p class="font-weight-bold text-danger">BG Expiring on</p>
                                                                {{ $app->expiry_dt }}
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="w-65 p-1 text-center text-nowrap">
                                                            {{ $app->expiry_dt }}
                                                        </td>
                                                    @endif
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->claim_dt }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{-- @if ($today > $app->expiry_dt && $app->expiry_dt != null) --}}
                                                        {{-- <p class="font-weight-bold text-danger">BG Expired</p> --}}
                                                        @if ($app->bg_status == 'IN')
                                                            <p class="font-weight-bold text-danger">Invoked</p>
                                                        @elseif($today > $app->expiry_dt && $app->expiry_dt != null)
                                                            <p class="font-weight-bold text-danger">BG Expired</p>
                                                        @elseif($app->bg_status == 'RO')
                                                            <p class="font-weight-bold text-success">Roll Over</p>
                                                        @elseif($app->bg_status == 'RE')
                                                            <p class="font-weight-bold text-success">Release</p>
                                                        @elseif($app->bg_status == 'EX')
                                                            <p class="font-weight-bold text-black ">Existing</p>
                                                        @else
                                                            <p class="text-info">Not Submit</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-warning btn-sm btn-block"><i
                                                                        class="right fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        @elseif(AUTH::user()->hasRole('Admin-Ministry'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <p class="font-weight-bold text-black ">Waiting</p>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
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
                            <h5>Approved Applicants</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover " id="users1">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="w-65 text-center ">Sr No</th>
                                            <th class="w-75 text-center ">Applicant Name</th>
                                            <th class="w-50 text-center ">Eligible Product</th>
                                            <th class="w-65 text-center ">Target Segment</th>
                                            <th class="w-65 text-center ">BG No.</th>
                                            <th class="w-65 text-center ">BG Amount (in ₹)</th>
                                            <th class="w-65 text-center ">Issue Date</th>
                                            <th class="w-65 text-center ">Expiry Date</th>
                                            <th class="w-65 text-center ">Claim Date</th>
                                            <th class="w-65 text-center ">BG Status</th>
                                            <th class="w-65 text-center ">BG</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '4')
                                                <tr>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td class="w-75 p-1">
                                                        {{ $app->name }}
                                                    </td>
                                                    <td class="w-50 p-1 text-center ">
                                                        {{ $app->product }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if ( $app->target_segment == 'A. Key Fermentation based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">A</p>
                                                        @elseif( $app->target_segment  == 'B. Fermentation based niche KSMs/Drug Intermediates/APIs')
                                                            <p class="font-weight-bold">B</p>
                                                        @elseif( $app->target_segment == 'C. Key Chemical Synthesis based KSMs/Drug Intermediates')
                                                            <p class="font-weight-bold">C</p>
                                                        @elseif( $app->target_segment == 'D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs')
                                                            <p class="font-weight-bold">D</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_no }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->bg_amount }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->issued_dt }}
                                                    </td>
                                                    @if ($date >= $app->expiry_dt && $app->expiry_dt != null)
                                                        <td class="alert-danger  text-center text-nowrap">
                                                            @if ($app->bg_status == 'IN')
                                                                {{ $app->expiry_dt }}
                                                            @elseif ($today > $app->expiry_dt && $app->expiry_dt != null)
                                                                <p class="font-weight-bold text-danger">BG Expired</p>
                                                                {{ $app->expiry_dt }}
                                                            @else
                                                                <p class="font-weight-bold text-danger">BG Expiring on</p>
                                                                {{ $app->expiry_dt }}
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="w-65 p-1 text-center text-nowrap">
                                                            {{ $app->expiry_dt }}
                                                        </td>
                                                    @endif
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{ $app->claim_dt }}
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        {{-- @if ($today > $app->expiry_dt && $app->expiry_dt != null) --}}
                                                        {{-- <p class="font-weight-bold text-danger">BG Expired</p> --}}
                                                        @if ($app->bg_status == 'IN')
                                                            <p class="font-weight-bold text-danger">Invoked</p>
                                                        @elseif($today > $app->expiry_dt && $app->expiry_dt != null)
                                                            <p class="font-weight-bold text-danger">BG Expired</p>
                                                        @elseif($app->bg_status == 'RO')
                                                            <p class="font-weight-bold text-success">Roll Over</p>
                                                        @elseif($app->bg_status == 'RE')
                                                            <p class="font-weight-bold text-success">Release</p>
                                                        @elseif($app->bg_status == 'EX')
                                                            <p class="font-weight-bold text-black ">Existing</p>
                                                        @else
                                                            <p class="text-info">Not Submit</p>
                                                        @endif
                                                    </td>
                                                    <td class="w-65 p-1 text-center text-nowrap">
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block"><i
                                                                        class="right fas fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.bgtracker.create', $app->id) }}"
                                                                    class="btn btn-warning btn-sm btn-block"><i
                                                                        class="right fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        @elseif(AUTH::user()->hasRole('Admin-Ministry'))
                                                            @if ($today < $app->expiry_dt)
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-primary btn-sm btn-block"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @elseif ($app->bg_status == 'RO' || $app->bg_status == 'RE' || $app->bg_status == 'IN' || $app->bg_status == 'EX')
                                                                <a href="{{ route('admin.bgtracker.show', ['app_id' => $app->id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                                    class="btn btn-danger btn-sm btn-block"><i
                                                                        class="right fas fa-eye">View</i>
                                                                </a>
                                                            @else
                                                                <p class="font-weight-bold text-black ">Waiting</p>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
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
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>',
                    }
                }
            });
        });
        $(document).ready(function() {
            $('#users1').DataTable({
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
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
            $('#users2').DataTable({
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
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
