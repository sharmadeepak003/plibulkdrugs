@extends('layouts.adminshared.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('title')
Authorize Signatory Request - List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-tabs">
            <div class="card-header text-bold">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="regPhase1" data-toggle="pill" href="#regPhase1Content"
                                    role="tab" aria-controls="regPhase1Content" aria-selected="true">Authorize Signatory Request -List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="regPhase2" data-toggle="pill" href="#regPhase2Content"
                                    role="tab" aria-controls="regPhase2Content" aria-selected="false">Approved Authorized Signatory List</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade" id="regPhase1Content" role="tabpanel"
                        aria-labelledby="regPhase1Content-tab">

                        <div class="card border-primary">

                        <!--
                            <div class="card-header border-primary">
                                <div class="row">
                                    <div class="col-md-2 pt-1">
                                        <h5>Export Data:</h5>
                                    </div>
                                    <div class="col-md-2 ml-0">
                                        <a href="{{ route('admin.users.export') }}"
                                            class="btn btn-sm btn-block btn-success mb-1 mr-1">Download Excel</a>
                                    </div>
                                </div>
                            </div>-->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover usersTable" id="tablePh1">
                                    <thead class="userstable-head">
                                            <tr class="table-info">
                                                <th rowspan="2" class="text-center">Sr No</th>
                                                <th rowspan="2" class="text-center">Organization Name</th>
                                                <th rowspan="2" class="text-center">current Contact Person</th>
                                                <th rowspan="2" class="text-center">Current Email</th>
                                                <th rowspan="2" class="text-center">Current Mobile</th>
                                                <th rowspan="2" class="text-center">Current Designation</th>
                                                <th rowspan="2" class="text-center">New Contact Person</th>
                                                <th rowspan="2" class="text-center">New Email</th>
                                                <th rowspan="2" class="text-center">New Mobile</th>
                                                <th rowspan="2" class="text-center">New Designation</th>
                                                <th rowspan="2" class="text-center">Authorize Letter</th>

                                                <th colspan="2" class="text-center">Action</th>
                                            </tr>

                                        </thead>
                                        <tbody class="userstable-body">

                                            <tr>

                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><table><tr>
                                                <td><a href=""
                                                        class="btn btn-info btn-sm btn-block">Approved</a></td>
                                                <td><a href=""
                                                        class="btn btn-danger btn-sm btn-block">Reject</a>
                                                </td>
                                            </tr>
</tr></table></td>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade active show" id="regPhase2Content" role="tabpanel"
                        aria-labelledby="regPhase2Content-tab">

                        <div class="card border-primary">
                            <div class="card-header border-primary">
                                <div class="row">
                                    <div class="col-md-2 pt-1">
                                        <h5>Export Data:</h5>
                                    </div>
                                    <div class="col-md-2 ml-0">
                                        <a href="{{ route('admin.users.export') }}"
                                            class="btn btn-sm btn-block btn-success mb-1 mr-1">Download Excel</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover usersTable" id="tablePh2">
                                        <thead class="userstable-head">
                                            <tr class="table-info">
                                                <th rowspan="2" class="text-center">Sr No</th>
                                                <th rowspan="2" class="text-center">Organization Name</th>
                                                <th rowspan="2" class="text-center">Contact Person</th>
                                                <th rowspan="2" class="text-center">Email</th>
                                                <th rowspan="2" class="text-center">Mobile</th>
                                                <th rowspan="2" class="text-center">Active From</th>
                                                <th rowspan="2" class="text-center">Active Upto</th>

                                            </tr>

                                        </thead>
                                        <tbody class="userstable-body">

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>

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
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var t1 = $('#tablePh1').DataTable({
            "order": [
                [0, 'asc']
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
        });

        t1.on('order.dt search.dt', function () {
            t1.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        var t2 = $('#tablePh2').DataTable({
            "order": [
                [0, 'asc']
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
        });

        t2.on('order.dt search.dt', function () {
            t2.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();


    });

</script>
@endpush
