@extends('layouts.admin.master')

@section('title')
    Claim Correspondence View
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        .align_right tr td:not(:first-child) input {
            text-align: right !important;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-2 offset-md-10">
        <a href="{{ route('admin.claims.incentive',['fy'=>'1']) }}" class="btn btn-warning btn-sm btn-block">
            <i class="fas fa-angle-double-left"></i> Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <b> Claim Correspondence View</b>
                        </div>
                        @foreach($claim_corres as $val)
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%">Query Raise Date</th>
                                        <td style="width: 60%">{{$val->raise_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Query Response Date</th>
                                        <td>{{ ($val->response_date != '')?$val->response_date:'-'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Document</th>
                                        <td>                                @if($val->doc_id != null)
                                            <a class="btn btn-success btn-sm" href="{{ route('doc.download', $val->doc_id) }}">View</a>
                                            @else
                                            -
                                            
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{!! $val->message !!}</td>
                                    </tr>
                                    
                                                                        
                                    

                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
@endsection
@push('scripts')
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js></script>

   
@endpush
