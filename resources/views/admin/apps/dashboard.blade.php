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
    <div class="card-header text-bold">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="appPhase1" data-toggle="pill" href="#appPhase1Content" role="tab"
                            aria-controls="appPhase1Content" aria-selected="true">Applications Round
                            I</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase2" data-toggle="pill" href="#appPhase2Content" role="tab"
                            aria-controls="appPhase2Content" aria-selected="false">Applications
                            Round II</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase3" data-toggle="pill" href="#appPhase3Content" role="tab"
                            aria-controls="appPhase3Content" aria-selected="false">Applications
                            Round III</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase4" data-toggle="pill" href="#appPhase4Content" role="tab"
                            aria-controls="appPhase4Content" aria-selected="false">Applications
                            Round IV</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="tab-content">

        <div class="tab-pane fade  active show" id="appPhase1Content" role="tabpanel"
            aria-labelledby="appPhase1Content-tab">
            <div class="col-md-3 my-2 offset-9">
                <a href="{{ route('admin.applications.export') }}" class="btn btn-sm btn-block btn-primary text-white">
                    Export Excel</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="filter" class="text-danger">Please select:</label>
                                </div>
                                <div>
                                    <label for="filter" class="text-danger">Target Segment</label>

                                    <select name="target" id="target" class="custom-select">
                                        <option>Select Target-segment</option>
                                        <option value="999">All</option>
                                        @foreach ($target_segment as $tar)
                                            <option value="{{ substr($tar->target_segment, 0, 1) }}">
                                                {{ $tar->target_segment }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="filter" class="text-danger">Product</label>

                                    <select name="product" id="product" class="custom-select" disabled>
                                        <option value="Select Product" selected>Select Product</option>
                                        <option value="999">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive my-2">
                                <table class="table table-sm table-striped table-bordered table-hover" id="apps1">
                                    <thead class="apps1 table-head">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Organization Name</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Application Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Submitted At</th>
                                            <th class="text-center">View</th>
                                            <th class="text-center">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody class="apps1 table-body">
                                        @php $i = 1; @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '1' and $app->status == 'S' and $app->app_no != '')
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $app->name }}</td>
                                                    <td>{{ $app->product }}</td>
                                                    <td>{{ $app->app_no }}</td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($app->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @isset($app->flag_name)
                                                            <span class="text-primary"
                                                                style="text-size:18px"><b>{{ $app->flag_name }}</b></span>
                                                        @else
                                                            <span><b>No Action</b></span>
                                                        @endisset
                                                    </td>
                                                    <td>{{ date('d/m/Y', strtotime($app->created_at)) }}</td>
                                                    <td>
                                                        @if ($app->status == 'S')
                                                            {{ date('d/m/Y', strtotime($app->submitted_at)) }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <a href="{{ route('admin.applications.preview', ['id' => $app->id]) }}"
                                                                class="btn btn-info btn-sm btn-block"><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @elseif($app->status == 'D')
                                                            <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <a href="{{ route('admin.applications.print', ['id' => $app->id]) }}"
                                                                class="btn btn-info btn-sm btn-block" target="_blank"><i
                                                                    class="fas fa-print"></i></a>
                                                        @elseif($app->status == 'D')
                                                            <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                                                    class="fas fa-print"></i></a>
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

        <div class="tab-pane fade" id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="col-md-3 my-2 offset-9">
                <a href="{{ route('admin.applications.export') }}" class="btn btn-sm btn-block btn-primary text-white">
                    Export Excel</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="filter" class="text-danger">Please select:</label>
                                </div>
                                <div>
                                    <label for="filter" class="text-danger">Target Segment</label>

                                    <select name="target1" id="target1" class="custom-select">
                                        <option>Select Target-segment</option>
                                        <option value="999">All</option>
                                        @foreach ($target_segment as $tar)
                                            <option value="{{ substr($tar->target_segment, 0, 1) }}">
                                                {{ $tar->target_segment }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter" class="text-danger">Product</label>
                                    <select name="product1" id="product1" class="custom-select" disabled>
                                        <option value="Select Product" selected>Select Product</option>
                                        <option value="999">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive my-2">
                                <table class="table table-sm table-striped table-bordered table-hover" id="apps2">
                                    <thead class="apps2 table-head">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Organization Name</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Application Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Submitted At</th>
                                            <th class="text-center">View</th>
                                            <th class="text-center">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody class="apps2 table-body" style="font-size:12px">
                                        @php $i = 1; @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '2' and $app->status == 'S' and $app->app_no != '')
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td class="col-3">{{ $app->name }}</td>
                                                    <td>{{ $app->product }}</td>
                                                    <td>{{ $app->app_no }}</td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($app->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @isset($app->flag_name)
                                                            <span class="text-primary"
                                                                style="text-size:18px"><b>{{ $app->flag_name }}</b></span>
                                                        @else
                                                            <span><b>No Action</b></span>
                                                        @endisset
                                                    </td>
                                                    <td>{{ date('d/m/Y', strtotime($app->created_at)) }}</td>
                                                    <td>
                                                        @if ($app->status == 'S')
                                                            {{ date('d/m/Y', strtotime($app->submitted_at)) }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center ">
                                                        @if ($app->status == 'S')
                                                            <a href="{{ route('admin.applications.preview', ['id' => $app->id]) }}"
                                                                class="btn btn-info btn-sm btn-block"><i
                                                                    class="right fas fa-eye "></i></a>
                                                        @elseif($app->status == 'D')
                                                            <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                                                    class="right fas fa-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <a href="{{ route('admin.applications.print', ['id' => $app->id]) }}"
                                                                class="btn btn-info btn-sm btn-block" target="_blank"><i
                                                                    class="fas fa-print"></i></a>
                                                        @elseif($app->status == 'D')
                                                            <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                                                    class="fas fa-print"></i></a>
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


        <div class="tab-pane fade" id="appPhase3Content" role="tabpanel" aria-labelledby="appPhase3Content-tab">
            <div class="col-md-3 my-2 offset-9">
                <a href="{{ route('admin.applications.export') }}" class="btn btn-sm btn-block btn-primary text-white">
                    Export Excel</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="row">
                               <div class="col-md-2">
                                    <label for="filter" class="text-danger">Please select:</label>
                                </div>
                                <div>
                                    <label for="filter" class="text-danger">Target Segment</label>
                                    <select name="target2" id="target2" class="custom-select">
                                        <option>Select Target-segment</option>
                                        <option value="999">All</option>
                                        @foreach ($target_segment as $tar)
                                            <option value="{{ substr($tar->target_segment, 0, 1) }}">
                                                {{ $tar->target_segment }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter" class="text-danger">Product</label>

                                    <select name="product2" id="product2" class="custom-select" disabled>
                                        <option value="Select Product" selected>Select Product</option>
                                        <option value="999">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive my-2">
                                <table class="table table-sm table-striped table-bordered table-hover" id="apps3">
                                    <thead class="apps3 table-head">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Organization Name</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Application Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Submitted At</th>
                                            <th class="text-center">View</th>
                                            <th class="text-center">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody class="apps3 table-body" style="font-size:12px">
                                        @php $i = 1; @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '3' and $app->status == 'S' and $app->app_no != '')
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td class="col-3">{{ $app->name }}</td>
                                                    <td>{{ $app->product }}</td>
                                                    <td>{{ $app->app_no }}</td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($app->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @isset($app->flag_name)
                                                            <span class="text-primary"
                                                                style="text-size:18px"><b>{{ $app->flag_name }}</b></span>
                                                        @else
                                                            <span><b>No Action</b></span>
                                                        @endisset
                                                    </td>
                                                    <td>{{ date('d/m/Y', strtotime($app->created_at)) }}</td>
                                                    <td>
                                                        @if ($app->status == 'S')
                                                            {{ date('d/m/Y', strtotime($app->submitted_at)) }}
                                                        @endif
                                                    </td>
                                                    @if (!Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2022-04-30 23:59:00')))
                                                        <td class="text-center ">
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('admin.applications.preview', ['id' => $app->id]) }}"
                                                                    class="btn btn-info btn-sm btn-block"><i
                                                                        class="right fas fa-eye "></i></a>
                                                            @elseif($app->status == 'D')
                                                                <a href="#"
                                                                    class="btn btn-info btn-sm btn-block disabled"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('admin.applications.print', ['id' => $app->id]) }}"
                                                                    class="btn btn-info btn-sm btn-block"
                                                                    target="_blank"><i class="fas fa-print"></i></a>
                                                            @elseif($app->status == 'D')
                                                                <a href="#"
                                                                    class="btn btn-info btn-sm btn-block disabled"><i
                                                                        class="fas fa-print"></i></a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="text-danger text-bold text-justify-center">Wait For Last
                                                            Date</td>
                                                        <td class="text-primary font-italic text-justify-center">Not
                                                            Visible</td>
                                                    @endif
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

        <div class="tab-pane fade" id="appPhase4Content" role="tabpanel" aria-labelledby="appPhase4Content-tab">
            <div class="col-md-3 my-2 offset-9">
                <a href="{{ route('admin.applications.export') }}" class="btn btn-sm btn-block btn-primary text-white">
                    Export Excel</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="row">
                               <div class="col-md-2">
                                    <label for="filter" class="text-danger">Please select:</label>
                                </div>
                                <div>
                                    <label for="filter" class="text-danger">Target Segment</label>
                                    <select name="target3" id="target3" class="custom-select">
                                        <option>Select Target-segment</option>
                                        <option value="999">All</option>
                                        @foreach ($target_segment as $tar)
                                            <option value="{{ substr($tar->target_segment, 0, 1) }}">
                                                {{ $tar->target_segment }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filter" class="text-danger">Product</label>

                                    <select name="product3" id="product3" class="custom-select" disabled>
                                        <option value="Select Product" selected>Select Product</option>
                                        <option value="999">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive my-2">
                                <table class="table table-sm table-striped table-bordered table-hover" id="apps4">
                                    <thead class="apps4 table-head">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Organization Name</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Application Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Submitted At</th>
                                            <th class="text-center">View</th>
                                            <th class="text-center">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody class="apps4 table-body" style="font-size:12px">
                                        @php $i = 1; @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '4')
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td class="col-3">{{ $app->name }}</td>
                                                    <td>{{ $app->product }}</td>
                                                    <td>{{ $app->app_no }}</td>
                                                    <td class="text-center">
                                                        @if ($app->status == 'S')
                                                            <span class="text-success"><b>SUBMITTED</b></span>
                                                        @elseif($app->status == 'D')
                                                            <span class="text-primary"><b>DRAFT</b></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @isset($app->flag_name)
                                                            <span class="text-primary"
                                                                style="text-size:18px"><b>{{ $app->flag_name }}</b></span>
                                                        @else
                                                            <span><b>No Action</b></span>
                                                        @endisset
                                                    </td>
                                                    <td>{{ date('d/m/Y', strtotime($app->created_at)) }}</td>
                                                    <td>
                                                        @if ($app->status == 'S')
                                                            {{ date('d/m/Y', strtotime($app->submitted_at)) }}
                                                        @endif
                                                    </td>
                                                    @if (!Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2022-08-24 23:59:00')))
                                                        <td class="text-center ">
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('admin.applications.preview', ['id' => $app->id]) }}"
                                                                    class="btn btn-info btn-sm btn-block"><i
                                                                        class="right fas fa-eye "></i></a>
                                                            @elseif($app->status == 'D')
                                                                <a href="#"
                                                                    class="btn btn-info btn-sm btn-block disabled"><i
                                                                        class="right fas fa-eye"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('admin.applications.print', ['id' => $app->id]) }}"
                                                                    class="btn btn-info btn-sm btn-block"
                                                                    target="_blank"><i class="fas fa-print"></i></a>
                                                            @elseif($app->status == 'D')
                                                                <a href="#"
                                                                    class="btn btn-info btn-sm btn-block disabled"><i
                                                                        class="fas fa-print"></i></a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="text-danger text-bold text-justify-center">Wait For Last
                                                            Date</td>
                                                        <td class="text-primary font-italic text-justify-center">Not
                                                            Visible</td>
                                                    @endif
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
</div>

@endsection

@push('scripts')
    @include('admin.partials.js.appsfilter')
@endpush
