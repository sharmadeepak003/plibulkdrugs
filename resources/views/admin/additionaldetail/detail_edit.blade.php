@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush


@section('title')
    Applications - Dashboard
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <br>
            <br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container ">
        <div class="row">
            <div class="col bg-mute text-center">
                <span style="color:#DC3545;font-size:20px"> <b> Application Name :</b></span><span
                    style="color:black;font-size:20px"> {{ $apps->name }}</p></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Application Number :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->app_no }}</span>
            </div>
            <div class="col-5 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Target Segment :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->target_segment }}</span>
            </div>
            <div class="col-3 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Product Name :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->product }}</span>
            </div>
        </div>
    </div>

    <div class="card border-primary m-4 ">
        <div class="card-header text-white bg-primary border-primary">
            <h5>Update Detail</h5>
        </div>
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                    <thead class="userstable-head">
                        <tr class="table-info">
                            <th class="text-center ">Sr No</th>
                            <th class="text-center">Task Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="userstable-body" style="font-size:12px">
                        @php
                            $sno = 1;
                        @endphp
                        @foreach ($additional as $add)
                            <tr>
                                {{-- {{dd($sno++)}} --}}
                                <td class="text-center">
                                    {{ $sno++ }}
                                </td>
                                <td class="pl-5">
                                    <h5>{{ $add->additional_name }}</h5>
                                </td>
                                <td>
                                    @php $task_id=$add->id; @endphp
                                    @if (AUTH::user()->hasRole('Admin'))
                                        <a href="{{ route('admin.additionaldetail.edit', [$apps->id,encrypt($task_id)]) }}"
                                            class="btn btn-warning btn-sm btn-block"><i class="right fas fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2 offset-md-5">
        <a href="{{ route('admin.additionaldetail.index') }}" class="btn btn-success btn-sm form-control form-control-sm">
            <i class="fas fa-backword right fas fa-home"></i> Home</a>
    </div>

@endsection
