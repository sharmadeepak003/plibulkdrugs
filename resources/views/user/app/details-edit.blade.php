@extends('layouts.user.dashboard-master')

@section('title')
Section 1 - Applicant / Company Details
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
        <form action={{ route('companydetails.update',$appMast->id) }} id="comp-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf

            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <p class="text-center text-bold p-0 m-0">Application Form for Production Linked Incentive Scheme of
                        Promotion of Domestic Manufacturing of Critical Key Starting Materials (KSMs)/Drug
                        Intermediates (DIs)/Active Pharmaceutical Ingredients (APIs) in India</p>
                </div>
            </div>
            <small class="text-danger">(All fields are mandatory)</small>

            {{-- Company Overview --}}
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>1.1 Applicant / Company Details</b>
                </div>
                <div class="card-body p-1">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="col-form-label col-form-label-sm">Name of the Applicant</label>
                            <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>
                    </div>
                    <div class="card border-primary p-0 m-0">
                        <div class="card-header">
                            <b>Details of Authorised Signatory</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label col-form-label-sm">Name</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ Auth::user()->contact_person }}" disabled>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="col-form-label col-form-label-sm">Designation</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ Auth::user()->designation }}" disabled>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="col-form-label col-form-label-sm">E-Mail</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ Auth::user()->email }}" disabled>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm">Mobile</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ Auth::user()->mobile }}" disabled>
                                </div>
                            </div>
                            <span class="help-text">Provide 'Letter of Authorisation' as per format attached in the section 'Undertakings & Certificates'.
                            </span>
                        </div>
                    </div>
                    <div class="card border-primary p-0 mt-1">
                        <div class="card-header">
                            <b>Eligible Product Applied For</b>
                        </div>
                        <div class="card-body">
                            <span class="help-text">Refer Clause 7.3 of Scheme Guidelines, separate application along with the application fee is required to be submitted for each eligible product.</span>
                            <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>1.2 Constitution of Business</b>
                </div>
                <div class="card-body p-1">
                    <div class="row pb-2">
                        <div class="col-md-12">
                            <span class=" help-text">Provide copy of MOA and AOA in case of Company. LLPs may provide copy of LLP Deed and MOA. In case of Partnership Firm, provide copy of  partnership agreement and registration deed if the Firm is registered.</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="comp_class">Constitution of Business</label>
                                <div class="input-group input-group-prepend">
                                    <span class="input-group-text text-info border-right-0 rounded-0">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <input type="text" id="comp_const" name="comp_const" class="form-control form-control-sm"
                                    value="{{ Auth::user()->type }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary p-0 mb-1">
                        <div class="card-header">
                            <b>Ownership Pattern as on the date of application</b>
                        </div>
                        <div class="card-body p-0">
                            <span class="help-text">
                                <ol type="1">
                                    <li>Provide shareholding pattern of the Company with detail of shareholders having more than 1% shareholding giving clear break-up between shareholding of 'Promoter & Promoter Group' and 'Others'. Companies listed in India may provide latest 'Shareholding Pattern' submitted to Stock Exchange, which should not be older than 3 months from the date of application.
                                        Applicant may also submit latest MGT 7 or MGT 9 filed with ROC.</li>
                                    <li>In case of Partnership Firm & Limited Liability Partnership provide detail for each partner, irrespective of their percentage of share.</li>
                                    <li>Proprietorship Firm shall give name of proprietor, capital with share mentioned as 100% under the head 'Promoter & Promoter Group'.</li>
                                </ol>
                            </span>
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" id="promTable">
                                    <thead>
                                        <tr>
                                            <th class="w-35">Name of the Shareholder/ Partner</th>
                                            <th class="w-20">No. of Shares</th>
                                            <th class="w-20">% Shareholding</th>
                                            <th class="w-20">Capital</th>
                                            <th class="w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <b>Promoter & Promoter Group</b>
                                                <button type="button" id="addProm" name="addProm"
                                                    class="btn btn-success btn-sm float-right"><i
                                                        class="fas fa-plus"></i> Add</button>
                                            </td>
                                        </tr>
                                        @foreach($promoters as $key => $value)
                                        <tr>
                                            <input name="prom[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                            <td>
                                                <input type="text" name="prom[{{ $key }}][name]"
                                                    class="form-control form-control-sm" value="{{ $value->name }}">
                                            </td>
                                            <td>
                                                <input type="text" name="prom[{{ $key }}][shares]"
                                                    class="form-control form-control-sm" value="{{ $value->shares }}">
                                            </td>
                                            <td>
                                                <input type="text" name="prom[{{ $key }}][per]"
                                                    class="form-control form-control-sm totalshares" value="{{ $value->per }}">
                                            </td>
                                            <td>
                                                <input type="text" name="prom[{{ $key }}][capital]"
                                                    class="form-control form-control-sm" value="{{ $value->capital }}">
                                            </td>
                                            <td class="pr-1">
                                                <a href="{{ route('promoter.delete',$value->id) }}"
                                                    class="btn btn-danger btn-sm float-right remove-prom"
                                                    onclick="return confirm('Confirm Delete?')">Remove</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="table-responsive rounded m-0 p-0">
                                    <table class="table table-bordered table-hover table-sm p-0 m-0" id="otherTable">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="p-0">
                                                    <b>Other than Promoter & Promoter Group</b>
                                                    <button type="button" id="addOther" name="addOther"
                                                        class="btn btn-success btn-sm float-right"><i
                                                            class="fas fa-plus"></i> Add</button>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($others as $key => $value)
                                            <tr>
                                                <input name="other[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                                <td class="w-35">
                                                    <input type="text" name="other[{{ $key }}][name]"
                                                        class="form-control form-control-sm" value="{{ $value->name }}">
                                                </td>
                                                <td class="w-20">
                                                    <input type="text" name="other[{{ $key }}][shares]"
                                                        class="form-control form-control-sm" value="{{ $value->shares }}">
                                                </td>
                                                <td class="w-20">
                                                    <input type="text" name="other[{{ $key }}][per]"
                                                        class="form-control form-control-sm othershareper" value="{{ $value->per }}">
                                                </td>
                                                <td class="w-20">
                                                    <input type="text" name="other[{{ $key }}][capital]"
                                                        class="form-control form-control-sm" value="{{ $value->capital }}">
                                                </td>
                                                <td class="w-5 pr-1">
                                                    <a href="{{ route('other.delete',$value->id) }}"
                                                        class="btn btn-danger btn-sm float-right remove-other"
                                                        onclick="return confirm('Confirm Delete?')">Remove</a>
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
            </div>

            {{-- Company Details --}}
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>1.3 Company Details</b>
                </div>
                <div class="card-body p-0">
                    <span class="help-text">
                        Company/ LLP provide date as per ROC record. Partnership Firm may provide date of partnership coming into existence. Proprietorship concern may give date of starting the business.
                    </span>
                    <small class="text-danger">
                    </small>
                    <div class="row p-1">
                        <div class="form-group col-md-7">
                            <label for="bus_profile" class="col-form-label col-form-label-sm">Brief
                                Profile of Business
                                <small class="help-text">(Give brief in the box and attach detailed profile)</small>
                            </label>
                            <textarea id="bus_profile" name="bus_profile" class="form-control form-control-sm" rows="2"
                                placeholder="Brief Business Profile">{{ $comp->bus_profile }}</textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">Date of Incorporation </label><small class="help-text">(Please attach copy)</small>
                            <input type="date" id="doi" name="doi" class="form-control form-control-sm" value="{{ $comp->doi }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-form-label col-form-label-sm">Website</label>
                            <input type="text" name="website" class="form-control form-control-sm"
                                placeholder="https://www.example.com" value="{{ $comp->website }}">
                        </div>
                    </div>
                    <div class="row border rounded border-primary p-0 m-0 mb-1">
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">PAN</label>
                            <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->pan }}"
                                disabled readonly>
                                <span class="help-text">(Please attach copy)</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">CIN / LLPIN</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ Auth::user()->cin_llpin }}" disabled readonly>
                                <span class="help-text">(Please attach copy)</span>
                        </div>
                    </div>
                    <div class="row border rounded border-primary m-0 mb-1">
                        <div class="form-group col-md-4">
                            <label for="listed" class="col-form-label col-form-label-sm">
                                Listed Company
                            </label>
                            <select id="listed" name="listed" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" @if($comp->listed == 'Y') selected @endif>Yes</option>
                                <option value="N" @if($comp->listed == 'N') selected @endif>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="stock_exchange" class="col-form-label col-form-label-sm">
                                Name of Stock Exchange
                            </label>
                            <input type="text" id="stock_exchange" name="stock_exchange"
                                class="form-control form-control-sm" disabled value="{{ $comp->stock_exchange }}">
                        </div>
                    </div>
                    <div class="card border-primary p-0 mb-1">
                        <div class="card-header">
                            <b>GST Registration</b>
                            <button type="button" id="addGSTIN" name="addGSTIN"
                                class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add
                                GSTIN</button>
                        </div>
                        <div class="card-body p-0">
                            <span class="help-text">
                                (Give detail of  all GST registrations and attach copy)
                            </span>
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm p-0 m-0" id="gstinTable">
                                    <thead>
                                        <tr>
                                            <th>GSTIN</th>
                                            <th>Registered Address</th>
                                            <th class="w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gstins as $key => $value)
                                        <tr>
                                            <input name="gstin[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                            <td class="w-25">
                                                <input type="text" name="gstin[{{ $key }}][gstin]" placeholder="GSTIN"
                                                    class="form-control form-control-sm" value="{{ $value->gstin }}">
                                            </td>
                                            <td class="w-45">
                                                <input type="text" name="gstin[{{ $key }}][add]"
                                                    class="form-control form-control-sm" value="{{ $value->add }}">
                                            </td>
                                            <td class="pr-1">
                                                <a href="{{ route('gstin.delete',$value->id) }}"
                                                    class="btn btn-danger btn-sm float-right remove-gstin"
                                                    onclick="return confirm('Confirm Delete?')">Remove</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    {{-- Registered Office --}}
                    <div class="row border border-primary rounded m-0 mb-1">
                        <div class="form-group col-md-4">
                            <label for="corp_add" class="col-form-label col-form-label-sm">
                                Registered Office Address</label>
                            <textarea id="corp_add" name="corp_add" class="form-control form-control-sm" rows="2"
                                placeholder="Address">{{ $comp->corp_add }}</textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="corp_state" class="col-form-label col-form-label-sm">State</label>
                            <select id="corp_state" name="corp_state" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                @foreach($states as $key => $value)
                                <option value="{{ $key }}" @if($key == $comp->corp_state) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="corp_city" class="col-form-label col-form-label-sm">City</label>
                            <select id="corp_city" name="corp_city" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                @foreach($cities as $key => $value)
                                <option value="{{ $key }}" @if($key == $comp->corp_city) selected @endif>{{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="corp_pin" class="col-form-label col-form-label-sm">Pincode</label>
                            <input type="number" id="corp_pin" name="corp_pin" class="form-control form-control-sm" value="{{ $comp->corp_pin }}">
                        </div>
                    </div>
                    {{-- Corporate Office --}}
                    <div class="row border rounded border-primary m-0 mb-1">
                        <div class="form-group col-md-4">
                            <label class="col-form-label col-form-label-sm">
                                Corporate Office Address</label>
                            <textarea class="form-control form-control-sm" rows="2"
                                disabled>{{ Auth::user()->off_add }}</textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">City</label>
                            <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->off_city }}"
                                disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">State</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ Auth::user()->off_state }}" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-form-label col-form-label-sm">Pincode</label>
                            <input type="number" class="form-control form-control-sm"
                                value="{{ Auth::user()->off_pin }}" disabled>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Statutory Auditors --}}
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    1.4 Statutory Auditor Details
                    <button type="button" id="addAuditor" name="addAuditor"
                        class="btn btn-success btn-sm border-white float-right"><i class="fas fa-plus"></i> Add
                        Auditor</button>
                </div>
                <div class="card-body p-0">
                    <span class="help-text">
                        Company and LLPs may give detail of Auditors appointed under respective Act. Partnership Firm and Proprietorship Firm may give detail of Independent Chartered Accountant appointed.
                    </span>
                    <div class="table-responsive rounded m-0 p-0">
                        <table class="table table-bordered table-hover table-sm" id="auditorTable">
                            <thead>
                                <tr>
                                    <th class="w-20">Name of the Firm</th>
                                    <th class="w-20">Firm Registration No.</th>
                                    <th class="w-15">Financial Year Employed (20XX-XX)</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditors as $key => $value)
                                <tr>
                                    <input name="aud[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                    <td>
                                        <input type="text" name="aud[{{ $key }}][name]" placeholder="Name"
                                            class="form-control form-control-sm" value="{{ $value->name }}">
                                    </td>
                                    <td>
                                        <input type="text" name="aud[{{ $key }}][frn]" placeholder="FRN"
                                            class="form-control form-control-sm" value="{{ $value->frn }}">
                                    </td>
                                    <td>
                                        <input type="text" name="aud[{{ $key }}][fy]" placeholder="2019-20"
                                            class="form-control form-control-sm" value="{{ $value->fy }}">
                                    </td>
                                    <td class="pr-1">
                                        <a href="{{ route('auditor.delete',$value->id) }}"
                                            class="btn btn-danger btn-sm float-right remove-auditor"
                                            onclick="return confirm('Confirm Delete?')">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>1.5 Credit History</b>
                </div>
                <div class="card-body p-0">
                    <div class="row border rounded border-primary m-0 mb-1">
                        <span class="help-text">
                            <ol type="1">
                                <li>Provide 'Undertaking' as per format attached in the section 'Undertakings & Certificates'.
                                </li>
                                <li>Please mention CIBIL score and attach a copy of latest report downloaded from CIBIL. In case, the score is not available in CIBIL report, attach copy of report and mention as 'not available' in the box.
                                </li>
                            </ol>
                        </span>
                        <div class="form-group col-md-2">
                            <label for="bankruptcy" class="col-form-label col-form-label-sm">Bankruptcy
                            </label>
                            <select id="bankruptcy" name="bankruptcy" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" {{ $comp->bankruptcy == "Y" ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $comp->bankruptcy == "N" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="rbi_default" class="col-form-label col-form-label-sm">RBI Defaulter
                                List</label>
                            <select id="rbi_default" name="rbi_default" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" {{ $comp->rbi_default == "Y" ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $comp->rbi_default == "N" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="wilful_default" class="col-form-label col-form-label-sm">Wilful Defaulter
                                List</label>
                            <select id="wilful_default" name="wilful_default" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" {{ $comp->wilful_default == "Y" ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $comp->wilful_default == "N" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sebi_barred" class="col-form-label col-form-label-sm">
                                SEBI Barred List
                            </label>
                            <select id="sebi_barred" name="sebi_barred" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" {{ $comp->sebi_barred == "Y" ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $comp->sebi_barred == "N" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cibil_score" class="col-form-label col-form-label-sm">
                                CIBIL Score
                            </label>
                            <input type="text" id="cibil_score" name="cibil_score"
                                class="form-control form-control-sm" value="{{ $comp->cibil_score }}">
                        </div>
                    </div>
                    <div class="row border rounded border-primary m-0 mb-1 p-1">
                        <div class="form-group col-md-4">
                            <label for="case_pend" class="col-form-label col-form-label-sm">
                                Any Legal case pending against Applicant/Promoters.
                            </label>
                            <select id="case_pend" name="case_pend" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option value="Y" {{ $comp->case_pend == "Y" ? 'selected' : '' }}>Yes</option>
                                <option value="N" {{ $comp->case_pend == "N" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <span class="help-text">
                                Please provide details of legal  cases pending against the applicant/promoters as per format provided under section Undertaking and Certificates.
                            </span>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header">
                            <b>External Credit Rating </b>
                            <button type="button" id="addRating" name="addRating"
                                class="btn btn-success border-white btn-sm float-right"><i class="fas fa-plus"></i> Add
                                More</button>
                        </div>

						<div class='row' style="margin-top: 15px;">
                        <div class="col-md-6">
                            <label for="case_pend" class="col-form-label col-form-label-sm">
                                Whether Applicant has External Credit Rating if 'yes' please provide details
                            </label>
                        </div>

                        <div class="col-md-2">
                            <select id="externalcreditrating" name="externalcreditrating" class="form-control form-control-sm">
                                <option value="" selected="selected">Please select..</option>
                                <option {{ $comp->externalcreditrating == "Y" ? 'selected' : '' }}  value="Y">Yes</option>
                                <option {{ $comp->externalcreditrating == "N" ? 'selected' : '' }}  value="N">No</option>
                            </select>
                        </div>
                    </div>

                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" id="ratingTable">
                                    <thead>
                                        <tr>
                                            <th class="w-20">Credit Rating </th>
                                            <th class="w-15">Name of Rating Agency </th>
                                            <th class="w-15">Date of Rating </th>
                                            <th class="w-15">Valid Up to </th>
                                            <th class="w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ratings as $key => $value)
                                        <tr>
                                            <input name="rat[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                            <td>
                                                <input type="text" name="rat[{{ $key }}][rating]"
                                                    class="form-control form-control-sm rating" value="{{ $value->rating }}">
                                            </td>
                                            <td>
                                                <input type="text" name="rat[{{ $key }}][name]"
                                                    class="form-control form-control-sm ratingname" value="{{ $value->name }}">
                                            </td>
                                            <td>
                                                <input type="date" name="rat[{{ $key }}][date]"
                                                    class="form-control form-control-sm ratingdate" value="{{ $value->date }}">
                                            </td>
                                            <td>
                                                <input type="date" name="rat[{{ $key }}][validity]"
                                                    class="form-control form-control-sm ratingvalidity" value="{{ $value->validity }}">
                                            </td>
                                            <td class="pr-1">
                                                <a href="{{ route('rating.delete',$value->id) }}"
                                                    class="btn btn-danger btn-sm float-right remove-rating"
                                                    onclick="return confirm('Confirm Delete?')">Remove</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header">
                            <b>Profile of Chairman, CEO, Managing Director </b>
                            <button type="button" id="addManagement" name="addManagement"
                                class="btn btn-success border-white btn-sm float-right"><i class="fas fa-plus"></i> Add
                                More</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm" id="topManTable">
                                    <thead>
                                        <tr>
                                            <td colspan="6">
                                                <span class="help-text">
                                                    <ol type="1">
                                                        <li>Provide detail of Directors having executive positions. LLPs to provide detail of 'Designated Partner'. Partnership Firm to provide detail of Managing Partner and other active partners. Proprietor firm may provide detail of proprietor
                                                        </li>
                                                        <li>Attach a brief profile of the Chairman/ CEO/ Promoter/ Partner/ Proprietor
                                                        </li>
                                                    </ol>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-20">Name</th>
                                            <th class="w-15">E-Mail</th>
                                            <th class="w-15">Mobile</th>
                                            <th class="w-15">DIN</th>
                                            <th class="w-25">Address</th>
                                            <th class="w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profiles as $key => $value)
                                        <tr>
                                            <input name="topMan[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                            <td>
                                                <input type="text" name="topMan[{{ $key }}][name]" placeholder="Name"
                                                    class="form-control form-control-sm" value="{{ $value->name }}">
                                            </td>
                                            <td>
                                                <input type="email" name="topMan[{{ $key }}][email]" placeholder="E-Mail"
                                                    class="form-control form-control-sm" value="{{ $value->email }}">
                                            </td>
                                            <td>
                                                <input type="number" name="topMan[{{ $key }}][phone]" placeholder="Phone"
                                                    class="form-control form-control-sm" value="{{ $value->phone }}">
                                            </td>
                                            <td>
                                                <input type="number" name="topMan[{{ $key }}][din]" placeholder="DIN"
                                                    class="form-control form-control-sm" value="{{ $value->din }}">
                                            </td>
                                            <td>
                                                <input type="text" name="topMan[{{ $key }}][add]" placeholder="Name"
                                                    class="form-control form-control-sm" value="{{ $value->add }}">
                                            </td>
                                            <td class="pr-1">
                                                <a href="{{ route('profile.delete',$value->id) }}"
                                                    class="btn btn-danger btn-sm float-right remove-topman"
                                                    onclick="return confirm('Confirm Delete?')">Remove</a>
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

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>1.6 Key Managerial Personnel Details</b>
                    <button type="button" id="addKMP" name="addKMP"
                        class="btn btn-success border-primary btn-sm float-right"><i class="fas fa-plus"></i> Add
                        More</button>
                </div>
                <div class="card-body p-0">
                    <span class="help-text">
                        Provide detail of 'Key Managerial Personnel' like CEO, CFO, Company Secretary, Plant Head not covered above
                    </span>
                    <div class="table-responsive rounded m-0 p-0">
                        <table class="table table-bordered table-hover table-sm" id="kmpTable">
                            <thead>
                                <tr>
                                    <th class="w-20">Name</th>
                                    <th class="w-20">E-Mail</th>
                                    <th class="w-15">Mobile</th>
                                    <th class="w-25">Designation</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kmps as $key => $value)
                                <tr>
                                    <input name="kmp[{{ $key }}][id]" type="hidden" value="{{ $value->id }}">
                                    <td>
                                        <input type="text" name="kmp[{{ $key }}][name]" placeholder="Name"
                                            class="form-control form-control-sm" value="{{ $value->name }}">
                                    </td>
                                    <td>
                                        <input type="email" name="kmp[{{ $key }}][email]" placeholder="E-Mail"
                                            class="form-control form-control-sm" value="{{ $value->email }}">
                                    </td>
                                    <td>
                                        <input type="number" name="kmp[{{ $key }}][phone]" placeholder="Phone"
                                            class="form-control form-control-sm" value="{{ $value->phone }}">
                                    </td>
                                    <td>
                                        <input type="text" name="kmp[{{ $key }}][pan_din]" placeholder="Designation"
                                            class="form-control form-control-sm" value="{{ $value->pan_din }}">
                                    </td>
                                    <td class="pr-1">
                                        <a href="{{ route('kmp.delete',$value->id) }}"
                                            class="btn btn-danger btn-sm float-right remove-kmp"
                                            onclick="return confirm('Confirm Delete?')">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" id="submitshareper"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('eligibility.create',$appMast->id) }}" class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Eligibility Criteria </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.company-details')
{!! JsValidator::formRequest('App\Http\Requests\CompanyDetStore','#comp-create') !!}
@endpush
