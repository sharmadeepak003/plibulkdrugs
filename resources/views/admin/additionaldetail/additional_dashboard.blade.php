@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
    Application Status -- Dashboard
@endsection

@section('content')
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

        <div class="tab-pane fade active show" id="appPhase1Content" role="taxbpanel"
            aria-labelledby="appPhase1Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary ">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>All Applications</h5>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" id="users">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="text-center ">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No.</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            @if (AUTH::user()->hasRole('Admin'))
                                            <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body" style="font-size:12px">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '1' and $app->app_no != '')
                                                <tr>
                                                    <td>
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td>
                                                        {{ $app->name }}
                                                    </td>
                                                    <td>
                                                        {{ $app->app_no }}
                                                    </td>
                                                    <td>
                                                        {{ $app->product }}
                                                    </td>
                                                    <td>
                                                        {{ $app->target_segment }}
                                                    </td>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <td>
                                                        <!-- @if (AUTH::user()->hasRole('Admin')) -->
                                                            <a href="{{ route('admin.additionaldetail.create', ['id' => $app->id]) }}"
                                                                class="btn btn-success btn-sm btn-block"><i
                                                                    class="fa fa-edit" style="color:white"></i>
                                                            </a>
                                                        <!-- @endif -->
                                                    </td>
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

        <div class="tab-pane fade show " id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary ">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>All Applications</h5>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="text-center ">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No.</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body" style="font-size:12px">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '2' and $app->app_no != '')
                                                <tr>
                                                    <td>
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td>
                                                        {{ $app->name }}
                                                    </td>
                                                    <td>
                                                        {{ $app->app_no }}
                                                    </td>
                                                    <td>
                                                        {{ $app->product }}
                                                    </td>
                                                    <td>
                                                        {{ $app->target_segment }}
                                                    </td>

                                                    <td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            <a href="{{ route('admin.additionaldetail.create', ['id' => $app->id]) }}"
                                                                class="btn btn-success btn-sm btn-block"><i
                                                                    class="fa fa-edit" style="color:white"></i>
                                                            </a>
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

        <div class="tab-pane fade show " id="appPhase3Content" role="tabpanel" aria-labelledby="appPhase3Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary ">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>All Applications</h5>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" id="users2">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="text-center ">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No.</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body" style="font-size:12px">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '3' and $app->app_no != '')
                                                <tr>
                                                    <td>
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td>
                                                        {{ $app->name }}
                                                    </td>
                                                    <td>
                                                        {{ $app->app_no }}
                                                    </td>
                                                    <td>
                                                        {{ $app->product }}
                                                    </td>
                                                    <td>
                                                        {{ $app->target_segment }}
                                                    </td>

                                                    <td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            <a href="{{ route('admin.additionaldetail.create', ['id' => $app->id]) }}"
                                                                class="btn btn-success btn-sm btn-block"><i
                                                                    class="fa fa-edit" style="color:white"></i>
                                                            </a>
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
        <div class="tab-pane fade show " id="appPhase4Content" role="tabpanel" aria-labelledby="appPhase4Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary ">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>All Applications</h5>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" id="users2">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="text-center ">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No.</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body" style="font-size:12px">
                                        @php
                                            $sno = 1;
                                        @endphp
                                        @foreach ($apps as $app)
                                            @if ($app->round == '4')
                                                <tr>
                                                    <td>
                                                        {{ $sno++ }}
                                                    </td>
                                                    <td>
                                                        {{ $app->name }}
                                                    </td>
                                                    <td>
                                                        {{ $app->app_no }}
                                                    </td>
                                                    <td>
                                                        {{ $app->product }}
                                                    </td>
                                                    <td>
                                                        {{ $app->target_segment }}
                                                    </td>

                                                    <td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                            <a href="{{ route('admin.additionaldetail.create', ['id' => $app->id]) }}"
                                                                class="btn btn-success btn-sm btn-block"><i
                                                                    class="fa fa-edit" style="color:white"></i>
                                                            </a>
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
            $('#users1').DataTable({
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
