@extends('layouts.user.dashboard-master')

@section('title')
Section 2 - Eligibility Criteria
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
        <form action={{ route('eligibility.store') }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
            <small class="text-danger">(All fields are mandatory)</small>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>2.1 Eligibility Criteria</b>
                    <small>(Refer para 4.1 of the Scheme Guidelines)</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="greenfield">Whether Project Proposed by Applicant is Greenfield Project as
                                per clause 2.18 of the Guidelines
                            </label>
                            <select class="form-control form-control-sm" id="greenfield" name="greenfield">
                                <option value="" selected="selected">Please choose..</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="bankrupt">Whether Applicant has been declared as bankrupt,wilful defaulter
                                or reported as fraud by any Bank or Financial Institution - clause 4.1.4 of the
                                Guidelines</label>
                            <select class="form-control form-control-sm" id="bankrupt" name="bankrupt">
                                <option value="" selected="selected">Please choose..</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="networth">Net Worth for Eligibility Criteria (Including Group Companies/
                                Enterprise, if considered ) in INR (Refer Clause 2.25)
                            </label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="number" id="networth" name="networth" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="card border-primary p-0 mb-1">
                        <div class="card-header">
                            <b>Details of Group Companies/ Enterprise whose Net Worth is being considered (Refer clause 2.19)</b>
                        </div>
                        <div class="card-body p-0">
                            <span class="help-text">
                                <ol type="1">
                                    <li>Provide the name of the Group companies/ Business Enterprise whose net-worth has been considered for arriving at the Net Worth for the purpose of the Eligibility Criteria. Also basis for considering the Group Company as per clause 2.19 of the Guidelines may be given under the head 'Relationship with Applicant' </li>
                                    <li>Provide Statutory Auditors' Certificate for Net-Worth as on the Date of Application. If applicant is an existing business, Statutory Auditors' Certificate for Net-Worth should also be supported by latest audited Balance Sheet  as per format attached in the section 'Undertaking & Certificates' of the form.
                                    </li>
                                    <li>Only the Net-worth of business enterprises should be considered except in case of ‘Sole Proprietorship’ applicant.  Sole proprietorship concern may furnish the Net-worth of proprietor.
                                    </li>
                                    <li>Partnership Firm may provide net-worth of the Firm only. In case of LLPs, the net-worth of business enterprises falling within the definition of Group Company may be considered for eligibility criteria.
                                    </li>
                                </ol>
                            </span>
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" id="groupTable">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Name of the Company/ Enterprise</th>
                                            <th class="w-25">Registered at (Location)</th>
                                            <th class="w-20">Registration No.</th>
                                            <th class="w-15">Relationship with Applicant</th>
                                            <th class="w-10">Net-Worth (in INR)</th>
                                            <th class="w-5 p-0 m-0">
                                                <button type="button" id="addGroup" name="addGroup"
                                                class="btn btn-success border-white btn-sm"><i class="fas fa-plus"></i> Add</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="group[0][name]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="group[0][location]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="group[0][regno]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="group[0][relation]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number" name="group[0][networth]"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="pr-1">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Company Details --}}
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>2.2 Proposed Domestic Value Addition</b>
                </div>
                <div class="card-body p-0">
                    <span class="help-text">Refer clause 4.1.3. of the Scheme Guidelines. Please provide the proposed DVA % of the eligible product applied for  based on the production process. Calculations of DVA  should be done as per clause 2.10 of the Scheme Guidelines
                    </span>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="dva">Proposed Domestic Value Addition [DVA] (%)</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="number" id="dva" name="dva" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="help-text">(Provide mandatory undertaking as per format attached in the section
                                'Undertaking & Certificates' and attach original copy with the application)

                            </span>
                            <div class="table-responsive rounded p-0 m-0">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="w-75 p-1">
                                                Whether mandatory undertakings referred to in clause 7.6 of the scheme
                                                guidelines is being submitted. <br>
                                                (Undertaking for Consenting of Audit )
                                            </th>
                                            <td class="w-25">
                                                <select id="ut_audit" name="ut_audit"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        {{--
                                        <tr>
                                            <th class="p-1">
                                                Whether madatory undertakings referred to in clause 7.6.2 of the scheme
                                                guidelines is being submitted. <br>
                                                (Undertaking for Domestic Sales)</th>
                                            <td>
                                                <select id="ut_sales" name="ut_sales"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                         --}}
                                        <tr>
                                            <th class="p-1">
                                                Whether madatory undertakings referred to in clause 17.6 of the scheme
                                                guidelines is being submitted. <br>
                                                (Integrity Pact)</th>
                                            <td>
                                                <select id="ut_integrity" name="ut_integrity"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Application Fee --}}
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>2.3 Application Fee Details</b>
                </div>
                <div class="card-body">
                    <div class="row pb-2">
                        <div class="col-md-12">
                            <span class="help-text">Applicant is required to pay fee as per Appendix C of the Scheme
                                Guidelines for every application. The account details for fee payment is given below

                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive p-0 m-0">
                                <table class="table table-sm table-bordered table-hover uploadTable">
                                    <tbody>
                                        <tr>
                                            <th>ACCOUNT NAME</th>
                                            <td>IFCI PLI BULK DRUGS</td>
                                        </tr>
                                        <tr>
                                            <th>ACCOUNT NO.</th>
                                            <td>3859475896</td>
                                        </tr>
                                        <tr>
                                            <th>Name of the Bank</th>
                                            <td>Central Bank of India</td>
                                        </tr>
                                        <tr>
                                            <th>BRANCH CODE</th>
                                            <td>1410</td>
                                        </tr>
                                        <tr>
                                            <th>BRANCH IFSC CODE</th>
                                            <td>CBIN0281410</td>
                                        </tr>
                                        <tr>
                                            <th>BRANCH NAME</th>
                                            <td>Central Bank Of India, Nehru Place</td>
                                        </tr>
                                        <tr>
                                            <th>ADDRESS</th>
                                            <td>59, Shakuntala Building, Nehru Place , New Delhi-110019</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="payment">Whether fee has been paid ?</label>
                            <select class="form-control form-control-sm" id="payment" name="payment">
                                <option value="" selected="selected">Please choose..</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date" class="col-form-label col-form-label-sm">Payment
                                    Date</label>
                                <input type="date" class="form-control form-control-sm" id="date" name="date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="urn" class="col-form-label col-form-label-sm">Unique Reference
                                    Number</label>
                                <input type="text" class="form-control form-control-sm" id="urn" name="urn"
                                    placeholder="UR No">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bank_name" class="col-form-label col-form-label-sm">Bank Name</label>
                                <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name"
                                    placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="amount" class="col-form-label col-form-label-sm">Amount</label>
                                <input type="number" class="form-control form-control-sm" id="amount" name="amount">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" id="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('financials.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Financial Details </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.eligibility')
{!! JsValidator::formRequest('App\Http\Requests\EligibilityStore','#form-create') !!}
@endpush
