@extends('layouts.admin.master')

@section('title')
{{-- Applicant - {{Auth::$user->name }} --}}
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-8">
                <div class="row py-4">
                    <div class="col-md-12">
                        <div class="card border-info">
                            <div class="card-header bg-info">
                                <b><div class="text-center" style="font-size: 20px;">Application Status</div></b>
                            </div>
                           <div class="card-body">
                                <table class="table table-sm table-bordered table-hover">
                                    {{-- @foreach($apps as $app) --}}
                                    <tbody>
                                        <tr>
                                            <th>Applicant Name</th>
                                            <td style="font-size: 16px;" class="font-weight-bold" colspan="3">{{$apps->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Application No.</th>
                                            <td colspan="3">{{ $apps->app_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Name</th>
                                            <td colspan="3">{{$apps->product}}</td>
                                        </tr>
                                        <tr>
                                            <th>Target Segment</th>
                                            <td colspan="3">{{$apps->target_segment}}</td>
                                        </tr>
                                        
                                        <!-- <tr colspan=2>
                                            <th >Application Status</th>
                                            <td style="font-size: 16px;" class="font-weight-bold">      {{$apps->flag_name}}
                                            @if($apps->flag_name == 'Approved')
                                                <th>Approval Date</th>
                                                <td style="font-size: 16px;">{{ date('d-m-Y', strtotime($apps->approval_dt)) }}</td>
                                            @endif
                                            </td>
                                        </tr> -->
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th width="20.5%">Application Status</th>
                                            <td style="font-size: 16px;" class="font-weight-bold">      {{$apps->flag_name}}</td>
                                        </tr>
                                        <tr>
                                            @if($apps->flag_name == 'Approved')
                                                <th>Approval Date</th>
                                                <td style="font-size: 16px;">{{ date('d-m-Y', strtotime($apps->approval_dt)) }}</td>
                                            @elseif($apps->flag_name == 'Withdrawn')
                                            <th>Reason of Withdrawn</th>
                                                <td style="font-size: 16px;">{{($apps->remarks)?$apps->remarks : "NA"}}</td>    
                                            @endif
                                        </tr>
                                    </tbody>
                                    {{-- @endforeach --}}
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-2 offset-md-5 float-sm-left">
                        <a href="{{ route('admin.appstatus.index') }}"
                        class="btn btn-primary btn-sm form-control form-control-sm">
                        <i class="fas fa-backword  fas fa-home "></i> Back</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('admin.appstatus.edit', ['id' => $apps->id]) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm">
                        <i class="fas fa-backword right fas fa-edit"></i> Edit</a>
                    </div>
                </div>
        </div>
    </div>

@endsection


