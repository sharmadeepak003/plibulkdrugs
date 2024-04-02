@extends('layouts.user.dashboard-master')

@section('title')
Section 8 - Domestic Value Addition (DVA)
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
        <form action={{ route('dva.store') }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}"> 
			<input type="hidden" id="prop_dva" name="prop_dva" value="{{ $elgb->dva }}">
            <small class="text-danger">(All fields are mandatory)</small>


            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    8.1 Domestic Value Addition (DVA)
                </div>
                <div class="card-body p-0">
                    <span class="help-text">
                        <ol type="i">
                            <li>For definition of DVA and non-originating material and services, refer clause 2.10 and
                                2.26 of the Guidelines</li>
                            <li>Provide estimated DVA, based on the proposed production process, route of synthesis etc.
                                considered in the Detailed Project Report. Applicant may consider the size of batch for
                                input/ output ratio, as may be deemed appropriate.</li>
                            <li>Provide the <b>name of the each Raw Material with country of origin</b> being within
                                India or Outside India. For Raw Material proposed to be consumed and originating within
                                India, provide name of major Indian Manufacturers.</li>
                            <li>In case a material is procured from local dealer, who has imported the material from
                                outside India, the country of origin of such material will be outside India. Therefore
                                country of origin should be determined based on the country where raw material was
                                manufactured.</li>
                            <li>The estimated cost of Raw Material and Expected Sales of Eligible Product may be given
                                without any reference to Qty. to keep the confidentiality of pricing.</li>
                            <li>To be signed by Managing Director or Equivalent of the Company/ Designated Partner of
                                Limited Liability Partnership Firm/ Managing Partner or any Active Partner, where there
                                is no managing partner, in case of Partnership Firm/ Proprietor of the Proprietor Firm.
                            </li>
                        </ol>
                    </span>
                    <div class="table-responsive rounded m-0 p-0">
                        <table class="table table-bordered table-hover table-sm" id="kraTable">
                            <thead>
                                <tr>
                                    <th class="w-20">Key Parameters</th>
                                    <th class="w-20">Country of Origin</th>
                                    <th class="w-15">Manufacturers in India</th>
                                    <th class="w-15">Amount ₹</th>
                                    <th class="w-5 p-0 m-0">
                                        <button type="button" id="addKRA" name="addKRA"
                                            class="btn btn-success btn-sm border-white float-right"><i
                                                class="fas fa-plus"></i>
                                            Add</button></th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="p-1">Key Raw Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" name="krm[0][name]" placeholder="Key Raw Material"
                                            class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm" name="krm[0][coo]">
                                            <option value="" selected="selected">Please choose..</option>
                                            <option value="India">India</option>
                                            <option value="Outside India">Outside India</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="krm[0][man]" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="krm[0][amt]" class="form-control form-control-sm">
                                    </td>
                                    <td class="pr-1">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive rounded m-0 p-0">
                        <table class="table table-bordered table-hover table-sm" id="auditorTable">
                            <tbody>
                                <tr>
                                    <th class="w-30 p-1">Salary Expenses</th>
                                    <td class="w-20">
                                        <input type="number" name="sal_exp" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="p-1">Other Expenses</th>
                                    <td><input type="number" name="oth_exp" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th class="p-1">Services non-originating in India</th>
                                    <td><input type="number" name="non_orig" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th class="p-1">Total Cost</th>
                                    <td><input type="number" name="tot_cost" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th class="p-1" colspan="2">Out of Total cost above</th>
                                </tr>
                                <tr>
                                    <th class="p-1">
                                        Non-Originating Raw Material <br>
                                        <span class="help-text">Total value of all Non-Originating Raw Material included
                                            in Total Cost should be specified</span>
                                    </th>
                                    <td><input type="number" name="non_orig_raw" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="p-1">Non-Originating Services <br>
                                        <span class="help-text">Total value of all Non-Originating Services included in
                                            Total Cost should be specified</span>
                                    </th>
                                    <td><input type="number" name="non_orig_srv" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="p-1">Total (A)</th>
                                    <td><input type="number" name="tot_a" id="total_a" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th colspan="5"></th>
                                </tr>
                                <tr>
                                    <th class="p-1">Estimated Sales Revenue (B) <br>
                                        <span class="help-text">Consider estimated sales value the product manufactured from total cost given above</span>
                                    </th>
                                    <td><input type="number" name="sales_rev" id="total_b" class="form-control form-control-sm"></td>
                                </tr>
                                <tr>
                                    <th colspan="5"></th>
                                </tr>
                                <tr>
                                    <th class="p-1">Domestic Value Addition % (B-A)/(B)</th>
                                    <td><input type="number" name="dva" id="dvatotal" readonly class="form-control form-control-sm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span><b>Managing Director/ Designated Partner/ Managing Partner/ Proprietor</b></span>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-2">
                            <label>Name</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="man_dir">
                        </div>
                    </div>
                    <div class="row py-2">
                        <div class="col-md-2">
                            <label>Designation</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="man_desig">
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
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('evaluations.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Evaluation </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.dva')
{!! JsValidator::formRequest('App\Http\Requests\DvaStore','#form-create') !!}
@endpush
