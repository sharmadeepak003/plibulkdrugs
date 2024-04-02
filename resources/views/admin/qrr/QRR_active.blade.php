@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
    Activation - Dashboard
@endsection

@section('content')
    <div class="container  py-4 px-2 col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('admin.qrr.qrractivation') }}" id="form-create" role="form" method="post"
                    class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Quarter Activation</b>
                        </div>
                        <div class="card-body py- px-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row m-2 ">
                                        <div class="col-md-2 py-2 ">
                                            <label for="month"></label>
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="month">Month</label>
                                            <select name="month" id="month" class="form-control form-control-sm">
                                                <option value="" selected disabled>Please select</option>
                                                <option value="Mar">March</option>
                                                <option value="June">June</option>
                                                <option value="Sep">September</option>
                                                <option value="Dec">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="year">Year</label>
                                            <select name="year" id="year" class="form-control form-control-sm">
                                                <option value="" selected disabled>Please select</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="status">Action</label>
                                            <select name="status" id="status" class="form-control form-control-sm">
                                                <option value="" selected disabled>Please select</option>
                                                <option value="1">Activate</option>
                                                <option value="0">Deactivate</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 py-2">
                                            <label></label>
                                            <button type="submit"
                                                class="btn btn-primary btn-sm form-control form-control-sm"><i class="fas fa-save"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-primary">
                        <div class="card-body py-0 px-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table style="width: 100%"
                                            class="table table-sm table-striped table-bordered table-hover" id="scodtable6">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" class="table-primary text-center bg-gradient-info">
                                                        Applicants
                                                    </th>
                                                </tr>
                                                <tr class="table-primary">
                                                    <th class="w-65 text-center">S.No</th>
                                                    <th class="w-65 text-center">Month</th>
                                                    <th class="w-65 text-center">Year</th>
                                                    <th class="w-65 text-center">Date</th>
                                                    <th class="w-65 text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $sno = 1;
                                                @endphp

                                                @foreach ($qtrMast as $qtr)
                                                    <tr>
                                                        <td class="w-65 text-center text-small">{{ $sno++ }}</td>
                                                        <td class="w-65 text-center">{{ $qtr->month }}</td>
                                                        <td class="w-65 text-center">{{ $qtr->year }}</td>
                                                        <td class="w-65 text-center">{{ $qtr->qtr_date }}</td>
                                                        @if ($qtr->status == '1')
                                                            <td class="w-65 text-center">Activate</td>
                                                        @else
                                                            <td class="w-65 text-center">De-Activate</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\admin\QrrActivate', '#form-create') !!}
@endpush
