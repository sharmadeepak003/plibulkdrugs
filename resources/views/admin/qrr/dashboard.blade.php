@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
    {{--By Shakiv Ali--}}
    <style>
    .loading-buttons{
        display:block;

        cursor: pointer;
        }
    #overlay{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
        }
    .cv-spinner {
        height: 100%;
        display: flex;

        justify-content: center;
        align-items: center;
        }
        .spinner {
        width: 50px;
        height: 50px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
        }
        @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
        }
        .is-hide{
        display:none;
        }
        .break {
            flex-basis: 100%;
            height: 0;
        }
</style>
@endpush



@section('title')
    QRR - Dashboard
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div style="display: flex; margin:0.3rem; place-content:center;">
                <h3>Select Quarter</h3>


                {{--By Ajaharuddin Ansari--}}
                <select name="1qrrvalue" id="1qrrvalue" onchange="dropdown1()" class="1qrrval"
                    style="margin:0.1rem 2rem;">

                    @foreach ($qtrMast as $qtr1)
                        {{-- @if ($qtr1->status=='1') --}}
                            <option value="{{$qtr1->qtr_id}}" @if($qtr == $qtr1->qtr_id) selected @endif>{{$qtr1->month}},{{$qtr1->year}}</option>
                        {{-- @endif --}}
                    @endforeach
                </select>
                <div class="col-md-2" style="float:left; padding:0;">
                        <a href="{{ route('admin.qrr.qrractivedash')}}"
                        class="btn btn-secondary btn-sm form-control form-control-sm" >
                        <i class="fas fa-home"></i>Activate QRR</a>
                </div>
                    {{--! Ajaharuddin Ansari--}}
            </div>
            <div class="col-md-2" style="float:right; padding:0;">
                <a href="{{ route('admin.qrr.exportall', ['qtr' => $qtr,'type'=>'A']) }}" class="btn btn-sm btn-warning"
                    style="float:right;">Export All Data (Excel)</a>
            </div>
        </div>
    </div>
    <div>
        <div class="card border-primary">
            <div class="card-body p-1 py-3">
                <div class="card-header text-bold">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="appPhase1" data-toggle="tab" href="#appPhase1Content"
                                        role="tab" aria-controls="appPhase1Content" aria-selected="true">QRR for
                                        Applications Round
                                        I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase2" data-toggle="tab" href="#appPhase2Content"
                                        role="tab" aria-controls="appPhase2Content" aria-selected="false">QRR for
                                        Applications
                                        Round II</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase3" data-toggle="tab" href="#appPhase3Content"
                                        role="tab" aria-controls="appPhase3Content" aria-selected="false">QRR for
                                        Applications
                                        Round III</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase4" data-toggle="tab" href="#appPhase4Content"
                                        role="tab" aria-controls="appPhase3Content" aria-selected="false">QRR for
                                        Applications
                                        Round IV</a>
                                </li>
                                <div class="col-md-4">
                                    <div class="progress-group">
                                        @if ($qtr == 202101)
                                            <span class="col-form-label col-form-label-sm text-success">Received QRR<b
                                                    class="text-dark"> - JUNE-2021</b></span>
                                        @else
                                            <span class="col-form-label col-form-label-sm text-success">Received QRR<b
                                                    class="text-dark"> -
                                                    {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}</b></span>
                                        @endif
                                        <span class="float-right"><b
                                                class="text-success">{{ $fillqrr }}</b>/{{ $totalqrr }}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ ($fillqrr / $totalqrr) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto">
                                    <button type="button" class="btn btn-primary float-right" aria-pressed="false"
                                        autocomplete="off" style="margin:0.5rem" data-toggle="modal"
                                        data-target="#PendingQrr" href="">
                                        Pending QRR
                                    </button>
                                </div>
                                {{-- By Ajaharuddin Ansari --}}
                                @if (AUTH::user()->hasRole('Admin'))
                                <div class="col-md-auto loading-buttons" style="padding-top: 4px;padding-bottom:3px">
                                    <a href="{{ route('admin.qrr.pendingQrrMail',$qtr)}}"
                                    class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold loading_mail" style="height: 45Px; width: 100px;">Send <i class="fa fa-envelope" aria-hidden="true" style="color:red"></i> Pending QRR</a>
                                </div>
                                @endif
                                <div class="col-md-auto " style="padding-top: 4px;padding-bottom:3px">
                                    @php
                                    use Carbon\Carbon;
                                    $today=Carbon::now()->format('Y-m-d');
                                    @endphp
                                    <a href="{{ route('admin.qrr.QrrMailLog',$today)}}"
                                    class="btn btn-primary btn-sm form-control form-control-sm font-weight-bold" style="height: 45Px; width: 100px;">QRR Mail History <i class="fa fa-info"></i></a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="appPhase1Content" role="tabpanel" aria-labelledby="appPhase1Content-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body p-1 py-3">
                            <div class="table-responsive">
                                <div>
                                    @if ($qtr == 202101)
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center">June-21 QRR</h5>
                                    @else
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center" colspan="2">
                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} QRR</h5>
                                    @endif
                                </div>
                                <table class="table table-sm table-striped table-bordered table-hover qrrsTables" id="qrrs1"
                                    style="font-size: 13px">
                                    <thead class="appstable-head">
                                        <tr class="table-info">
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-auto p-3">Organization Name</th>
                                            <th class="text-center w-auto p-3">Target Segment</th>
                                            <th class="text-center w-auto p-3">Eligible Product</th>
                                            <th class="text-center w-auto p-3">Status</th>
                                            @if (AUTH::user()->hasRole('Admin'))
                                                <th class="text-center" id='qrr_location'>Greenfield <br>Location Change</th>
                                            @endif
                                            <th class="text-center w-auto p-3">Submissiom Date</th>
                                            <th class="text-center w-auto p-3">Revision Date</th>
                                            <th class="text-center" id='1prev1'>View</th>
                                            <th class="text-center">Open Edit Mode QRR </th>
                                        </tr>
                                    </thead>
                                    <tbody class="appstable-body">
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($qrr as $item)
                                            @if ($item->round == '1')
                                                <tr>
                                                    <td>{{ $key++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->target_segment }}</td>
                                                    <td>{{ $item->product }}</td>
                                                    <td>
                                                        @if ($item->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($item->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <td>
                                                        <a  href="{{ route('admin.qrr_location',['id' => $item->id, 'qtr_id' => $item->qtr_id])}}" class="btn btn-warning btn-sm btn-block"style="text-center"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                    </td>
                                                    @endif
                                                    <td>@if($item->submitted_at != null){{  date('j \\ F Y', strtotime($item->submitted_at)) }}@endif</td>
                                                    <td>@if($item->revision_dt != null && ($item->submitted_at != $item->revision_dt)){{  date('j \\ F Y', strtotime($item->revision_dt)) }}@endif</td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            <a href='javascript:void(0)'
                                                                class="btn btn-info btn-sm btn-block disabled " id=""><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @else
                                                            <a href="{{ route('admin.qrr.view', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-block "
                                                                id=""><i class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            @if (AUTH::user()->hasRole('Admin'))
                                                                <a href="{{ route('admin.qrr.closeeditmode', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                class="btn btn-success btn-sm btn-block" id="">Close Open QRR</a>
                                                            @endif
                                                        @else
                                                        <a href="#"
                                                        class="btn btn-info btn-sm btn-block disabled " id=""><i class="fa fa-lock" aria-hidden="true"></i></a>
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

        <div class="tab-pane fade  show" id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body p-1 py-3">
                            <div class="table-responsive">
                                <div>
                                    @if ($qtr == 202101)
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center">June-21 QRR</h5>
                                    @else
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center" colspan="2">
                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} QRR</h5>
                                    @endif
                                </div>
                                <table class="table table-sm table-striped table-bordered table-hover qrrsTables" id="qrrs2"
                                    style="font-size: 13px">
                                    <thead class="appstable-head">
                                        <tr class="table-info">
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-auto p-3">Organization Name</th>
                                            <th class="text-center w-auto p-3">Target Segment</th>
                                            <th class="text-center w-auto p-3">Eligible Product</th>
                                            <th class="text-center w-auto p-3">Status</th>
                                            @if (AUTH::user()->hasRole('Admin'))
                                            <th class="text-center" id='qrr_location'>Greenfield <br>Location Change</th>
                                            @endif
                                            <th class="text-center w-auto p-3">Submissiom Date</th>
                                            <th class="text-center w-auto p-3">Revision Date</th>
                                            <th class="text-center" id='1prev1'>View</th>
                                            <th class="text-center">Open Edit Mode QRR </th>
                                        </tr>
                                    </thead>

                                    <tbody class="appstable-body">
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($qrr as $item)
                                            @if ($item->round == '2')
                                                <tr>
                                                    <td>{{ $key++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->target_segment }}</td>
                                                    <td>{{ $item->product }}</td>
                                                    <td>
                                                        @if ($item->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($item->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <td>
                                                        <a  href="{{ route('admin.qrr_location',['id' => $item->id, 'qtr_id' => $item->qtr_id])}}" class="btn btn-warning btn-sm btn-block"style="text-center"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                    </td>
                                                    @endif
                                                    <td>@if($item->submitted_at != null){{  date('j \\ F Y', strtotime($item->submitted_at)) }}@endif</td>
                                                    <td>@if($item->revision_dt != null && ($item->submitted_at != $item->revision_dt)){{  date('j \\ F Y', strtotime($item->revision_dt)) }}@endif</td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            <a href='javascript:void(0)'
                                                                class="btn btn-info btn-sm btn-block disabled " id=""><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @else
                                                            <a href="{{ route('admin.qrr.view', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-block "
                                                                id=""><i class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            @if (AUTH::user()->hasRole('Admin'))
                                                                <a href="{{ route('admin.qrr.closeeditmode', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                class="btn btn-success btn-sm btn-block" id="">Close Open QRR</a>
                                                            @endif
                                                        @else
                                                        <a href="#"
                                                        class="btn btn-info btn-sm btn-block disabled " id=""><i class="fa fa-lock" aria-hidden="true"></i></a>
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
        {{--by Shakiv_Ali--}}
        <div class="tab-pane fade  show" id="appPhase3Content" role="tabpanel" aria-labelledby="appPhase3Content-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body p-1 py-3">
                            <div class="table-responsive">
                                <div>
                                    @if ($qtr == 202101)
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center">June-21 QRR</h5>
                                    @else
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center" colspan="2">
                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} QRR</h5>
                                    @endif
                                </div>
                                <table class="table table-sm table-striped table-bordered table-hover qrrsTables" id="qrrs2"
                                    style="font-size: 13px">
                                    <thead class="appstable-head">
                                        <tr class="table-info">
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-auto p-3">Organization Name</th>
                                            <th class="text-center w-auto p-3">Target Segment</th>
                                            <th class="text-center w-auto p-3">Eligible Product</th>
                                            <th class="text-center w-auto p-3">Status</th>
                                            @if (AUTH::user()->hasRole('Admin'))
                                            <th class="text-center" id='qrr_location'>Greenfield <br>Location Change</th>
                                            @endif
                                            <th class="text-center w-auto p-3">Submissiom Date</th>
                                            <th class="text-center w-auto p-3">Revision Date</th>
                                            <th class="text-center" id='1prev1'>View</th>
                                            <th class="text-center">Open Edit Mode QRR </th>
                                        </tr>
                                    </thead>
                                    <tbody class="appstable-body">
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($qrr as $item)
                                            @if ($item->round == '3')
                                                <tr>
                                                    <td>{{ $key++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->target_segment }}</td>
                                                    <td>{{ $item->product }}</td>
                                                    <td>
                                                        @if ($item->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($item->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <td>
                                                        <a  href="{{ route('admin.qrr_location',['id' => $item->id, 'qtr_id' => $item->qtr_id])}}" class="btn btn-warning btn-sm btn-block"style="text-center"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                    </td>
                                                    @endif
                                                    <td>@if($item->submitted_at != null){{  date('j \\ F Y', strtotime($item->submitted_at)) }}@endif</td>
                                                    <td>@if($item->revision_dt != null && ($item->submitted_at != $item->revision_dt)){{  date('j \\ F Y', strtotime($item->revision_dt)) }}@endif</td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            <a href='javascript:void(0)'
                                                                class="btn btn-info btn-sm btn-block disabled " id=""><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @else
                                                            <a href="{{ route('admin.qrr.view', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-block "
                                                                id=""><i class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            @if (AUTH::user()->hasRole('Admin'))
                                                                <a href="{{ route('admin.qrr.closeeditmode', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                class="btn btn-success btn-sm btn-block" id="">Close Open QRR</a>
                                                            @endif
                                                        @else
                                                        <a href="#"
                                                        class="btn btn-info btn-sm btn-block disabled " id=""><i class="fa fa-lock" aria-hidden="true"></i></a>
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
        <div class="tab-pane fade  show" id="appPhase4Content" role="tabpanel" aria-labelledby="appPhase4Content-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body p-1 py-3">
                            <div class="table-responsive">
                                <div>
                                    @if ($qtr == 202101)
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center">June-21 QRR</h5>
                                    @else
                                        <h5 class="p-2 mb-2 bg-primary text-white text-center" colspan="2">
                                            {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }} QRR</h5>
                                    @endif
                                </div>
                                <table class="table table-sm table-striped table-bordered table-hover qrrsTables" id="qrrs2"
                                    style="font-size: 13px">
                                    <thead class="appstable-head">
                                        <tr class="table-info">
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-auto p-3">Organization Name</th>
                                            <th class="text-center w-auto p-3">Target Segment</th>
                                            <th class="text-center w-auto p-3">Eligible Product</th>
                                            <th class="text-center w-auto p-3">Status</th>
                                            @if (AUTH::user()->hasRole('Admin'))
                                            <th class="text-center" id='qrr_location'>Greenfield <br>Location Change</th>
                                            @endif
                                            <th class="text-center w-auto p-3">Submissiom Date</th>
                                            <th class="text-center w-auto p-3">Revision Date</th>
                                            <th class="text-center" id='1prev1'>View</th>
                                            <th class="text-center">Open Edit Mode QRR </th>
                                        </tr>
                                    </thead>

                                    <tbody class="appstable-body">
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($qrr as $item)
                                            @if ($item->round == '4')
                                                <tr>
                                                    <td>{{ $key++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->target_segment }}</td>
                                                    <td>{{ $item->product }}</td>
                                                    <td>
                                                        @if ($item->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($item->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    {{-- {{dd(AUTH::user()->id)}} --}}
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <td>
                                                        <a  href="{{ route('admin.qrr_location',['id' => $item->id, 'qtr_id' => $item->qtr_id])}}" class="btn btn-warning btn-sm btn-block"style="text-center"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                                    </td>
                                                    @endif
                                                    <td>@if($item->submitted_at != null){{  date('j \\ F Y', strtotime($item->submitted_at)) }}@endif</td>
                                                    <td>@if($item->revision_dt != null && ($item->submitted_at != $item->revision_dt)){{  date('j \\ F Y', strtotime($item->revision_dt)) }}@endif</td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            <a href='javascript:void(0)'
                                                                class="btn btn-info btn-sm btn-block disabled " id=""><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @else
                                                            <a href="{{ route('admin.qrr.view', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-block "
                                                                id=""><i class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'D')
                                                            @if (AUTH::user()->hasRole('Admin'))
                                                                <a href="{{ route('admin.qrr.closeeditmode', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                class="btn btn-success btn-sm btn-block" id="">Close Open QRR</a>
                                                            @endif
                                                        @else
                                                        <a href="#"
                                                        class="btn btn-info btn-sm btn-block disabled " id=""><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        @if ($item->status == 'D')
                                                            <a href='javascript:void(0)'
                                                                class="btn btn-info btn-sm btn-block disabled " id=""><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @else
                                                            <a href="{{ route('admin.qrr.view', ['id' => $item->id, 'qtr' => $item->qtr_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-block "
                                                                id=""><i class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td> --}}
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
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>&nbsp;
            <div class="loading-message" style="color:white; font-weight: bold; font-size: x-large;">Please wait...until sending message</div>
        </div>
    </div>
    <!-- window.location = '{{ route('admin.qrr.pendingQrrMail',$qtr)}}'; -->

@endsection

@push('scripts')
    <script>

        function dropdown1() {
            window.location.href = '' + $('#1qrrvalue').val();
        }

        $(document).ready(function() {
            $('#qrrs1').DataTable({
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


            $(document).ready(function() {
                $('#qrrs2').DataTable({
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
        });
        // by Shakiv Ali
        $(document).ready(function() {

            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(300);　
            });

            $('.loading-buttons').click(function(){
                $.ajax({
                    type: 'POST',
                    success: function(data){
                        window.location = "{{ route('admin.qrr.pendingQrrMail',$qtr)}}";
                    }
                    }).done(function() {
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },5000);
                });
            });
        });
    </script>
    @include('admin.qrr.modal.pendingQRR')
@endpush
