@extends('layouts.master')

@section('title')
    Registration - PLI Bulk Drugs Portal
@endsection

@push('styles')
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register/register.css') }}" rel="stylesheet">
@endpush

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
    <div class="main-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Main Card-->
                    <div class="card border-info shadow-lg">
                        <h5 class="card-header bg-info text-white">Applicant Registration</h5>
                        <div class="card-body shadow-lg">
                            <!-- Main Form-->
                            <form action="{{ route('register') }}" id="regForm" role="form" method="POST"
                                class='form-horizontal' accept-charset="utf-8">
                                {{ csrf_field() }}
                                <!-- First Card Org Details-->
                                <div class="card border-info shadow-lg">
                                    <h5 class="card-header">Applicant Details</h5>
                                    <div class="card-body shadow-lg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Name of the Applicant</label>
                                                    <div class="input-group input-group-prepend">
                                                        <span class="input-group-text text-info border-right-0 rounded-0">
                                                            <i class="fas fa-building"></i>
                                                        </span>
                                                        <input type="text" id="name" name="name"
                                                            class="form-control" placeholder="Applicant / Company Name"
                                                            value="{{ old('name') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Business Constitution</label>
                                                    <div class="input-group input-group-prepend">
                                                        <span class="input-group-text text-info border-right-0 rounded-0">
                                                            <i class="fas fa-building"></i>
                                                        </span>
                                                        <select class="custom-select" id="type" name="type">
                                                            <option value="" selected="selected">Please choose..
                                                            </option>
                                                            <option value="Proprietary Firm">Proprietary Firm
                                                            </option>
                                                            <option value="Partnership Firm">Partnership Firm</option>
                                                            <option value="Limited Liability Partnership">Limited Liability
                                                                Partnership</option>
                                                            <option value="Company">Company
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="pan">PAN</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text text-info border-right-0 rounded-0">
                                                        <i class="fas fa-registered"></i>
                                                    </span>
                                                    <input id="pan" type="text" class="form-control" name="pan"
                                                        value="{{ old('pan') }}" placeholder="PAN">
                                                </div>
                                                <span class="instr">Please note that the user
                                                    will login with the <b class="text-danger">PAN</b>
                                                    as username. </span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cin_llpin">
                                                    CIN / LLPIN
                                                    <span class="instr"> (Applicable for Company / LLP)</span>
                                                </label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text text-info border-right-0 rounded-0">
                                                        <i class="fas fa-registered"></i>
                                                    </span>
                                                    <input type="text" id="cin_llpin" name="cin_llpin"
                                                        class="form-control" placeholder="CIN"
                                                        value="{{ old('cin_llpin') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border rounded">
                                            <div class="form-group col-md-4">
                                                <label for="off_add" class="col-form-label col-form-label-sm">
                                                    Corporate Office Address</label>
                                                <textarea id="off_add" name="off_add" class="form-control form-control-sm" rows="2" placeholder="Address"></textarea>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="off_city" class="col-form-label col-form-label-sm">City</label>
                                                <input type="text" id="off_city" name="off_city"
                                                    class="form-control form-control-sm" placeholder="City">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="off_state"
                                                    class="col-form-label col-form-label-sm">State</label>
                                                <input type="text" id="off_state" name="off_state"
                                                    class="form-control form-control-sm" placeholder="State">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="off_pin"
                                                    class="col-form-label col-form-label-sm">Pincode</label>
                                                <input type="number" id="off_pin" name="off_pin"
                                                    class="form-control form-control-sm" placeholder="Pin Code">
                                            </div>
                                        </div>
                                        <div class="row border rounded">
                                            <div class="form-group col-md-4">
                                                <label for="existing_manufacturer">Are you an existing manufacturer in
                                                    Pharma Sector in India
                                                    or Outside India?</label>
                                                <select class="custom-select" id="existing_manufacturer"
                                                    name="existing_manufacturer">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="business_desc" class="col-form-label col-form-label-sm">
                                                    If Yes, give brief description about existing business
                                                    <span class="instr"> (Min 300 Characters)</span></label>
                                                <span class="instr"> (Special characters not allowed)</span>
                                                <textarea id="business_desc" name="business_desc" class="form-control form-control-sm" rows="2"
                                                    placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="row border rounded">
                                            <div class="form-group col-md-4">
                                                <label for="setup_project">Are you planning to set-up a Greenfield
                                                    project for manufacturing of KSMs / DIs / APIs covered under the
                                                    Scheme?</label>
                                                <select class="custom-select" id="setup_project" name="setup_project">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="applicant_desc" class="col-form-label col-form-label-sm">
                                                    If Yes, brief description of about Applicant
                                                    <span class="instr"> (Min 300 Characters)</span></label>
                                                <span class="instr"> (Special characters not allowed)</span>
                                                <textarea id="applicant_desc" name="applicant_desc" class="form-control form-control-sm" rows="2"
                                                    placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-info mt-5 shadow-lg">
                                    <div class="card-header">
                                        <h5>Eligible product for which application is being filed</h5>
                                        <ol type="circle" class="instr float-left">
                                            <li>In terms of clause 7.3 of the Scheme Guidelines, an applicant may apply for
                                                more
                                                than one eligible product.</li>
                                            <li>Applicant can select more than one product from the dropdown below.</li>
                                        </ol>
                                    </div>
                                    <div class="card-body shadow-lg">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="subSegment"
                                                        class="col-md-2 col-form-label col-form-label-sm">
                                                        Eligible Product
                                                    </label>
                                                    <div class="col-md-10">
                                                        {{-- <select id="eligible_product" name="eligible_product[]"
                                                        multiple="multiple" class="form-control form-control-sm">
                                                        @foreach ($prods as $prod)
                                                        <option value="{{ $prod->id }}">{{ $prod->product }}</option>
                                                        @endforeach
                                                    </select> --}}
                                                        <input type="hidden" name="eligible_product"
                                                            value="{{ $prods[0]->id }}">
                                                        <input type="text" name="prod_name"
                                                            value="{{ $prods[0]->product }}"
                                                            class="form-control form-control-sm" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <b>Target Segment</b>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <span id="tSeg">
                                                </span> --}}
                                                <span id="tSeg">
                                                    {{ $prods[0]->target_segment }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Second Card Personal Details-->
                                <div class="card border-info mt-5 shadow-lg">
                                    <h5 class="card-header">Authorized Person Details</h5>
                                    <div class="card-body shadow-lg">

                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="contact_person">Name: </label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                id="contact_person" name="contact_person"
                                                                placeholder="Name" autocomplete="contact_person"
                                                                autofocus>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="email">Email:</label>
                                                    <div class="col-lg-9 col-12">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-envelope"></i>
                                                            </span>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="Email" autocomplete="email">
                                                        </div>
                                                        <span class="instr">E-mail will be verified after
                                                            registration</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="contact_add">Address</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <textarea id="contact_add" name="contact_add" class="form-control form-control-sm" rows="2"
                                                                placeholder="Address"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="password-confirm">Confirm
                                                        Password:</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-key"></i>
                                                            </span>
                                                            <input type="password" class="form-control"
                                                                id="password-confirm" placeholder="Confirm Password"
                                                                name="password_confirmation">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="designation">Designation</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-user-minus"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="designation"
                                                                name="designation" placeholder="Designation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="mobile">Mobile:</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </span>
                                                            <input type="number" class="form-control" id="mobile"
                                                                name="mobile" placeholder="Mobile Number">
                                                        </div>
                                                        <span class="instr">Mobile will be verified after
                                                            registration</span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12"
                                                        for="password">Password:</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span
                                                                class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-key"></i>
                                                            </span>
                                                            <input type="password" class="form-control" id="password"
                                                                name="password" placeholder="Password">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-lg-12 col-12 ">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="1" class="square-blue"
                                                                id="checkbox" name="checkbox" required>
                                                            I have read the Scheme Notification and relevant Guidelines and
                                                            M/s <span id="cName" class="font-weight-bold"></span> is
                                                            eligible to apply under the Scheme.</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="form-group form-actions">
                                                    <div class="col-lg-9 col-12 ">
                                                        <button type="submit" id="submit"
                                                            class="btn btn-primary">Register
                                                        </button>
                                                        <button type="reset"
                                                            class="btn btn-effect-ripple btn-warning ml-5">
                                                            Reset
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @push('scripts')
        <script src="{{ asset('js/jquery.multiselect.js') }}"></script>
        <script src="{{ asset('js/jsvalidation.min.js') }}"></script>
        @include('user.partials.registration.reg-js')
        {!! JsValidator::formRequest('App\Http\Requests\Registration', '#regForm') !!}
    @endpush
