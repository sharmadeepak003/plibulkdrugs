@extends('layouts.user.dashboard-master')

@section('title')
Section 5 - Proposal Details
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
        <form action={{ route('proposal.store') }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
            <small class="text-danger">(All fields are mandatory)</small>


            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>5.1 Project Details</b>
                </div>
                <div class="card-body p-0">
                    <div class="row border rounded border-primary m-0 pb-2">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>Target Segment</th>
                                </tr>
                                @foreach($prods as $prod)
                                @if($prod->id == $appMast->eligible_product)
                                <tr>
                                    <td><b>{{ $prod->target_segment }}</b></td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>Eligible Product</th>
                                </tr>
                                @foreach($prods as $prod)
                                @if($prod->id == $appMast->eligible_product)
                                <tr>
                                    <td><b>{{ $prod->product }}</b></td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="w-50 p-1">
                                                Address of the proposed Manufacturing Facility of Eligible Product
                                                applied for</th>
                                            <td class="w-50">
                                                <textarea id="prop_man_add" name="prop_man_add"
                                                    class="form-control form-control-sm" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-50 p-1">
                                                Whether applicant is already manufacturing any pharmaceutical product at
                                                the proposed manufacturing facility (please give details)</th>
                                            <td class="w-50">
                                                <textarea id="prop_man_det" name="prop_man_det"
                                                    class="form-control form-control-sm" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-50 p-1">Address of the existing proposed Manufacturing Facility
                                                of
                                                KSMs/DIs, if any which are proposed to be utilised for the manufacturing
                                                of eligible product (Refer clause 7.5 of the scheme guidelines)</th>
                                            <td class="w-50">
                                                <textarea id="exst_man_add" name="exst_man_add"
                                                    class="form-control form-control-sm" rows="2"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-50 p-1">Scheduled Date of Commercial Production</th>
                                            <td class="w-50">
                                                <input type="date" class="form-control form-control-sm" id="prod_date"
                                                    name="prod_date">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>5.2 Detailed Project Report</b>
                </div>
                <div class="card-body p-0 m-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <b>Instructions :-</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger">
                                                <span class="help-text">
                                                <ol type="1">
                                                    <li>The applicant is required to submit a detailed project report of eligible product with techno-economic viability of the project. The report should contain the information on the following sections at minimum: (Refer Clause 3.3 of annexure I of the scheme guidelines)</li>
                                                    <li>For each item given in the table below (clause 3.3 of the Annexure I of the Guidelines), provide reference to the relevant section or page no. of the Project Report where the same is covered. (select status from Drop Down for information provided or not provided). Project Report may be annexed with the application.
                                                    </li>
                                                </ol></span>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-50 text-center">Key Information</th>
                                            <th class="w-10 text-center">Whether Information Provided</th>
                                            <th class="w-20 text-center">Reference to section or Page Number in DPR</th>
                                            <th class="w-20 text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proj_prt as $val)
                                        <tr>
                                            <td>{{ $val->name }}</td>
                                            <td>
                                                <select name="info_prov[{{ $val->id }}]"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="dpr_ref[{{ $val->id }}]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="remarks[{{ $val->id }}]"
                                                    class="form-control form-control-sm">
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




            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                {{-- <div class="col-md-2 offset-md-3">
                    <a href="{{ route('evaluations.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Evaluation </a>
                </div> --}}
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('projections.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Projections </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.proposal')
{!! JsValidator::formRequest('App\Http\Requests\ProposalStore','#form-create') !!}
@endpush
