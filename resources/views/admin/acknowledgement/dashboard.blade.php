@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush


@section('title')
    Admin - Dashboard
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
                            aria-controls="appPhase1Content" aria-selected="true">Applications Phase
                            I</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appPhase2" data-toggle="pill" href="#appPhase2Content" role="tab"
                            aria-controls="appPhase2Content" aria-selected="false">Applications
                            Phase II</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade active show" id="appPhase1Content" role="tabpanel" aria-labelledby="appPhase1Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>Registered Applicants</h5>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                    <div class="col-md-1 offset-md-4">
                        <span class="text-danger">Export: </span>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('admin.users.export') }}"
                            class="btn btn-sm btn-block btn-primary text-white">Excel</a>
                    </div>
                </div> --}}
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover" id="users">
                                    <thead class="userstable-head">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            <th class="text-center">Submitted Date</th>
                                            <th class="text-center">Acknowledgent</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body">
                                        @foreach ($apps as $app)

                                            <tr>
                                                <td>{{ $app->sno }}</td>
                                                <td>@foreach ($user as $use) @if ($use->id == $app->created_by) {{ $use->name }} @endif @endforeach</td>
                                                <td>{{ $app->app_no }}</td>
                                                <td> @foreach ($eligible_pro as $pro)@if ($app->eligible_product == $pro->id){{ $pro->product }}@endif @endforeach</td>
                                                <td>@foreach ($eligible_pro as $pro)@if ($app->eligible_product == $pro->id){{ $pro->target_segment }}@endif @endforeach</td>
                                                <td data-sort='YYYYMMDD'>{{ $app->submitted_at }}
                                                </td>

                                                <td><a href="{{ route('admin.acknowledgement.show', $app->id) }}"
                                                        class="btn btn-primary btn-sm btn-block"><i
                                                            class="right fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade show" id="appPhase2Content" role="tabpanel" aria-labelledby="appPhase2Content-tab">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header text-white bg-primary border-primary">
                            <h5>Registered Applicants</h5>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                    <div class="col-md-1 offset-md-4">
                        <span class="text-danger">Export: </span>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('admin.users.export') }}"
                            class="btn btn-sm btn-block btn-primary text-white">Excel</a>
                    </div>
                </div> --}}
                            <div class="table-responsive">
                                {{-- <table class="table table-striped table-bordered table-hover" class="display nowrap"
                                    width="100%" id="usersR2"> --}}
                                <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                                    <thead class="userstable-head" style="font-size:12px">
                                        <tr class="table-info">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center">Applicant Name</th>
                                            <th class="text-center">Application No</th>
                                            <th class="text-center">Eligible Product</th>
                                            <th class="text-center">Target Segment</th>
                                            <th class="text-center">Submitted Date</th>
                                            <th class="text-center">Acknowledgent</th>
                                        </tr>
                                    </thead>
                                    <tbody class="userstable-body" style="font-size:12px">
                                        @foreach ($appsR2 as $app)

                                            <tr>
                                                <td>{{ $app->sno }}</td>
                                                <td class="col-3">@foreach ($user as $use) @if ($use->id == $app->created_by) {{ $use->name }} @endif @endforeach</td>
                                                <td class="col-3">{{ $app->app_no }}</td>
                                                <td class="col-2"> @foreach ($eligible_pro as $pro)@if ($app->eligible_product == $pro->id){{ $pro->product }}@endif @endforeach</td>
                                                <td class="col-3 ">@foreach ($eligible_pro as $pro)@if ($app->eligible_product == $pro->id){{ $pro->target_segment }}@endif @endforeach</td>
                                                <td class="col-3" data-sort='YYYYMMDD'>{{ $app->submitted_at }}
                                                </td>

                                                <td><a href="{{ route('admin.acknowledgement.show', $app->id) }}"
                                                        class="btn btn-primary btn-sm btn-block"><i
                                                            class="right fas fa-eye"></i></a>
                                                </td>
                                            </tr>
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
    </script>
@endpush
