@extends('layouts.user.dashboard-master')

@section('title')
Section 7 - Projections- Eligible Product
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
{{-- Error Messages --}}
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

{{-- ContentStarts --}}
<div class="row">
    <div class="col-lg-12">
        <form action={{ route('projections.store') }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
            <small class="text-danger">(All fields are mandatory)</small>


            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>7.1 Revenue (₹ in INR)</b>
                </div>
                <div class="card-body py-0 px-0">
                    <div class="table-responsive p-0 m-0">
                        <table class="table table-sm table-bordered table-hover uploadTable">
                            <thead>
                                <tr>
                                    <th colspan="10">
                                        <b>Instructions :-</b>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="10" class="text-danger p-0">
                                        <span class="help-text">
                                            <ol type="1">
                                            <li>Provide revenue projection only for the eligible product applied for.
                                                Sales figure should be given without any reference to qty. or price
                                                assumption.</li>
                                            <li>Provide revenue projection starting from the financial year in which
                                                project is expected to achieve Commercial Operation based on Scheduled
                                                Commercial Operations Date.</li>
                                        </ol>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center w-10">Particulars <br>(₹ in INR)</th>
                                    <th class="text-center">FY 2020-21</th>
                                    <th class="text-center">FY 2021-22</th>
                                    <th class="text-center">FY 2022-23</th>
                                    <th class="text-center">FY 2023-24</th>
                                    <th class="text-center">FY 2024-25</th>
                                    <th class="text-center">FY 2025-26</th>
                                    <th class="text-center">FY 2026-27</th>
                                    <th class="text-center">FY 2027-28</th>
                                    <th class="text-center">FY 2028-29</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Export Sales</th>
                                    <td><input type="number" name="expfy20" id="expfy20" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy21" id="expfy21" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy22" id="expfy22" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy23" id="expfy23" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy24" id="expfy24" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy25" id="expfy25" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy26" id="expfy26" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy27" id="expfy27" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="expfy28" id="expfy28" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th>Domestic Sale</th>
                                    <td><input type="number" name="domfy20" id="domfy20" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy21" id="domfy21" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy22" id="domfy22" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy23" id="domfy23" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy24" id="domfy24" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy25" id="domfy25" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy26" id="domfy26" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy27" id="domfy27" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="domfy28" id="domfy28" class="form-control form-control-sm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>7.2 Employment Generation (Nos.)</b>
                </div>
                <div class="card-body py-0 px-0">
                    <div class="table-responsive p-0 m-0">
                        <table class="table table-sm table-bordered table-hover uploadTable">
                            <thead>
                                <tr>
                                    <th colspan="10">
                                        <b>Instructions :-</b>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="10" class="text-danger p-0">
                                        <span class="help-text">
                                            <ol type="1">
                                            <li>Provide cumulative employment generation related to the Greenfield Project proposed to be set-up under the Scheme. E.g. in FY 2020-21, applicant expects to engage 50 employee which shall increased by another 50 employee in FY 2021-22 making cumulative employee base of 100 persons, mention 50 for FY 2020-21 and 100 for FY 2021-22.</li>
                                        </ol>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center w-10">Particulars <br>(Nos.)</th>
                                    <th class="text-center">FY 2020-21</th>
                                    <th class="text-center">FY 2021-22</th>
                                    <th class="text-center">FY 2022-23</th>
                                    <th class="text-center">FY 2023-24</th>
                                    <th class="text-center">FY 2024-25</th>
                                    <th class="text-center">FY 2025-26</th>
                                    <th class="text-center">FY 2026-27</th>
                                    <th class="text-center">FY 2027-28</th>
                                    <th class="text-center">FY 2028-29</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Cumulative Employee Base</th>
                                    <td><input type="number" name="fy20" id="fy20" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy21" id="fy21" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy22" id="fy22" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy23" id="fy23" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy24" id="fy24" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy25" id="fy25" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy26" id="fy26" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy27" id="fy27" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="fy28" id="fy28" class="form-control form-control-sm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('dva.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> DVA </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ProjectionStore','#form-create') !!}
@endpush
