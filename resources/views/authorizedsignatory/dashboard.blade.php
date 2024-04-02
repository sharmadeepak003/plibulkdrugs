@extends('layouts.user.dashboard-master')

@section('title')
    Change Request Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')


<div class="row py-4">
    <div class="col-md-12">
        <div class="card border-primary">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="">
                        <thead class="bg-primary">
                           <tr>
                            <th>Sr.No</th>
                            <th>Request Type</th>
                            <th>Action</th>
                           </tr>
                        </thead>
                        <tbody class="">
                            <tr>
                                <td>1</td>
                                <td>Authorised Signatory</td>
                                <td><a href="{{ route('admin.authoriseSignatory',['A',$corporate_add->id]) }}">Click</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Corporate Address</td>
                                <td><a href="{{ route('admin.authoriseSignatory',['C',$corporate_add->id]) }}">Click</a></td>
                            </tr>
                          
                            <tr>
                            <td>3</td>
                                <td>Registered Address</td>
                                <td><a href="#" data-toggle="modal" data-target="#corpAddCreateModal">Click</a>
                                    @include('authorizedsignatory.partials.modal.corpAddChangeModal')
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


