@extends('layouts.admin.master')

@section('title')
Development Logs
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">Logs</div>
            <div class="card-body">
                <table class="table table-striped" id="logTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Level</th>
                            <th>Date/Time</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allLogErrors as $key => $error)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $error['errorType'] }}</td>
                            <td>{{ $error['timestamp'] }}</td>
                            <td>{{ $error['message'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
    

@push('scripts')
<script>
    $('#logTable').DataTable({
        'order' : [[0 ,'desc']]
    });
</script>
@endpush