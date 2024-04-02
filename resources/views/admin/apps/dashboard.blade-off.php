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

<div class="row py-4">
    <div class="col-md-12">
        <div class="card border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 offset-md-4">
                        <span class="text-danger">Export: </span>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('admin.applications.export') }}"
                            class="btn btn-sm btn-block btn-primary text-white">Excel</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                        <thead class="appstable-head">
                            <tr class="table-info">
                                <th class="text-center">Sr No</th>
                                <th class="text-center">Organization Name</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Application No</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Submitted At</th>
                                 <th colspan="2" class="text-center">Action</th> 
                            </tr>
                            {{-- <tr class="table-info">
                                <th>View</th>
                                <th>Edit</th>
                                <th>Print</th>
                            </tr> --}}
                        </thead>
                        <tbody class="appstable-body">
                            @php $i = 1; @endphp
                            @foreach($apps as $app)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $app->user->name }}</td>
                                <td>@foreach($eligible_pro as $pro) @if($app->eligible_product==$pro->id)
                                    {{ $pro->product }} @endif @endforeach</td>
                                <td>{{ $app->app_no }}</td>
                                <td class="text-center">
                                    @if($app->status == 'S')
                                    <span class="text-success"><b>SUBMITTED</b></span>
                                    @elseif($app->status == 'D')
                                    <span class="text-primary"><b>DRAFT</b></span>
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($app->created_at)) }}</td>
                                <td>@if($app->status == 'S')
                                    {{ date('d/m/Y', strtotime($app->submitted_at)) }}
                                    @endif</td>
                                <td class="text-center">
                                    @if($app->status == 'S')
                                    <a href="{{ route('admin.applications.preview',['id' => $app->id]) }}" class="btn btn-info btn-sm
                                btn-block"><i class="right fas fa-eye"></i></a>
                                @elseif($app->status == 'D')
                                <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                        class="right fas fa-eye"></i></a>
                                @endif
                                </td>
                               
                                <td class="text-center">
                                    @if($app->status == 'S')
                                    <a href="{{ route('admin.applications.print',['id' => $app->id]) }}" class="btn btn-info btn-sm btn-block"
                                        target="_blank"><i class="fas fa-print"></i></a>
                                    @elseif($app->status == 'D')
                                    <a href="#" class="btn btn-info btn-sm btn-block disabled"><i
                                            class="fas fa-print"></i></a>
                                    @endif
                                </td> 
                            </tr>
                            @php $i++; @endphp
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
        $('#apps').DataTable({
            "order": [
                [0, "asc"]
            ],
            "columns": [
                null,
                null,
                null,
                null,
                null,
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
