@extends('layouts.admin.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush


@section('title')
Users - Dashboard
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

<div class="row py-4">
    <div class="col-md-12">
        <div class="card border-primary">
            <div class="card-header text-white bg-primary border-primary">
                <h5>Registered Applicants</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 offset-md-4">
                        <span class="text-danger">Export: </span>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.exportR1') }}"
                            class="btn btn-sm btn-block btn-primary text-white">Excel Round 1</a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.export') }}"
                            class="btn btn-sm btn-block btn-primary text-white">Excel Round 2</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users">
                        <thead class="userstable-head">
                            <tr class="table-info">
                                <th rowspan="2" class="text-center">Sr No</th>
                                <th rowspan="2" class="text-center">Organization Name</th>
                                <th rowspan="2" class="text-center">PAN</th>
                                <th rowspan="2" class="text-center">Contact Person</th>
                                <th rowspan="2" class="text-center">Mobile</th>
                                <th rowspan="2" class="text-center">Registered At</th>
                                <th colspan="2" class="text-center">Applicant Login</th>
                                <th colspan="2" class="text-center">Edit AuthorisedSignatory</th>
                            </tr>
                            <tr class="table-info">
                                <th>Status</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body">
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->rno }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->pan }}</td>
                                <td>{{ $user->contact_person }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td data-sort='YYYYMMDD'>{{ date('d-m-Y',strtotime($user->created_at)) }}</td>
                                <td class="text-center">
                                    @if($user->isapproved == 'Y' && $user->hasRole('Applicant'))
                                    <span class="text-success"><b>Activated</b></span>
                                    @elseif($user->isapproved == 'N')
                                    <span class="text-danger"><b>De-activated</b></span>
                                    @else
                                    <span><b>Pending</b></span>
                                    @endif
                                </td>
                                <td>
                                    {{--change by Ajaharuddin Ansari--}}
                                    @if (AUTH::user()->hasRole('Admin'))
                                        <a href="{{ route('admin.users.edit',$user->id) }}"
                                            class="btn btn-primary btn-sm btn-block"><i class="right fas fa-eye"></i></a>
                                    @else
                                    <a href="{{ route('admin.users.edit',$user->id) }}"
                                        class="btn btn-primary btn-sm btn-block"><i class="right fas fa-eye"></i></a>
                                    @endif
                                    {{--! Ajaharuddin Ansari--}}
                                </td>
                                <td><a href="{{ route('admin.users.edit_authorised_signatory',$user->id) }}" 
                                    class="btn btn-warning btn-sm btn-block"><i class="right fas fa-edit"></i></a>
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

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#users').DataTable({
            "order": [
                [0, "asc"]
            ],
            "columns": [
                null,
                null,
                null,
                null,
                null,
                {
                    "type": "date"
                },
                null,
                null,
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
