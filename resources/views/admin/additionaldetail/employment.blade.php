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
    <form action="{{ route('admin.additionaldetail.update', $apps->id) }}" id="form-create" role="form" method="post"
        class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
        {!! method_field('patch') !!}
        @csrf
        <div class="card border-primary m-4 ">
            <input type="hidden" name="app_id" value="{{ $apps->id }}">
            <input type="hidden" name="task_id" value="{{ $task_id }}">
            <div class="card-header text-white bg-primary border-primary">
                <h5>Employment</h5>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                        <thead class="userstable-head">
                            <tr>
                                <th colspan="10" class="text-center">Old Data</th>
                            </tr>
                            <tr class="table-info">
                                <th class="w-40 text-center">Particulars (Nos.)</th>
                                <th class="w-20 text-center">FY 2020-21</th>
                                <th class="w-20 text-center">FY 2021-22</th>
                                <th class="w-20 text-center">FY 2022-23</th>
                                <th class="w-20 text-center">FY 2023-24</th>
                                <th class="w-20 text-center">FY 2024-25</th>
                                <th class="w-20 text-center">FY 2025-26</th>
                                <th class="w-20 text-center">FY 2026-27</th>
                                <th class="w-20 text-center">FY 2027-28</th>
                                <th class="w-20 text-center">FY 2028-29</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body" style="font-size:12px">
                            <tr>
                                <th>Cumulative Employee Base</th>
                                @foreach ($employment as $emp)
                                    <td class="text-center">{{ $emp->fy20 }}</td>
                                    <td class="text-center">{{ $emp->fy21 }}</td>
                                    <td class="text-center">{{ $emp->fy22 }}</td>
                                    <td class="text-center">{{ $emp->fy23 }}</td>
                                    <td class="text-center">{{ $emp->fy24 }}</td>
                                    <td class="text-center">{{ $emp->fy25 }}</td>
                                    <td class="text-center">{{ $emp->fy26 }}</td>
                                    <td class="text-center">{{ $emp->fy27 }}</td>
                                    <td class="text-center">{{ $emp->fy28 }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                        <thead class="userstable-head">
                            <tr>
                                <th colspan="10" class="text-center">New Data</th>
                            </tr>
                            <tr class="table-info">
                                <th class="w-40 text-center">Particulars (Nos.)</th>
                                <th class="w-20 text-center">FY 2020-21</th>
                                <th class="w-20 text-center">FY 2021-22</th>
                                <th class="w-20 text-center">FY 2022-23</th>
                                <th class="w-20 text-center">FY 2023-24</th>
                                <th class="w-20 text-center">FY 2024-25</th>
                                <th class="w-20 text-center">FY 2025-26</th>
                                <th class="w-20 text-center">FY 2026-27</th>
                                <th class="w-20 text-center">FY 2027-28</th>
                                <th class="w-20 text-center">FY 2028-29</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body" style="font-size:12px">
                            <tr>
                                <th>Cumulative Employee Base</th>
                                @foreach ($employment as $emp)
                                <td><input type="number" name="empfy20" id="empfy20" value="{{ $emp->fy20 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy21" id="empfy21" value="{{ $emp->fy21 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy22" id="empfy22" value="{{ $emp->fy22 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy23" id="empfy23" value="{{ $emp->fy23 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy24" id="empfy24" value="{{ $emp->fy24 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy25" id="empfy25" value="{{ $emp->fy25 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy26" id="empfy26" value="{{ $emp->fy26 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy27" id="empfy27" value="{{ $emp->fy27 }}" class="form-control form-control-sm">
                                </td>
                                <td><input type="number" name="empfy28" id="empfy28" value="{{ $emp->fy28 }}" class="form-control form-control-sm">
                                </td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Remark</th>
                                <td colspan="9"><input type="text" name="empremark" id="empremark"
                                        class="form-control form-control-sm"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 offset-md-5">
                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                        class="fas fa-save"></i> Save</button>
            </div>
            <div class="col-md-1 offset-md-3.5">
                <a href="{{ route('admin.additionaldetail.create', $apps->id) }}"
                    class="btn btn-success btn-sm form-control form-control-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\admin\AdditionalsdetailRequest', '#form-create') !!}
@endpush
