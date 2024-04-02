@extends('layouts.user.dashboard-master')

@section('content')
    {{-- @if ($errors->any())
        <h4 style="color:red;">{{ $errors->first() }}</h4>
    @endif --}}
    {{-- <div class="main-body"> --}}
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <!-- Main Card-->
                    <div class="card border-info shadow-lg">
                        <h5 class="card-header bg-info text-white">Grievance Form</h5>
                        <div class="card-body shadow-lg">
                            <!-- Main Form-->
                            <form action="{{ route('grievance.store') }}" id="compForm" role="form" method="POST" class='form-horizontal prevent_multiple_submit' enctype="multipart/form-data" accept-charset="utf-8">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">

                                <!-- Second Card Personal Details-->
                                {{-- <div class="card border-info shadow-lg">
                                    <h5 class="card-header bg-info text-white">Applicant Complaint Details</h5> --}}
                                    <div class="card-body shadow-lg">

                                        <div class="row">
                                            <div class="col-lg-9 col-12">
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12" for="name">Name: </label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12" for="designation">Designation:</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-user-minus"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12" for="email">Email:</label>
                                                    <div class="col-lg-9 col-12">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-envelope"></i>
                                                            </span>
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12" for="mobile">Mobile:</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </span>
                                                            <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12" for="password">Please Provide Any Details</label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-key"></i>
                                                            </span>
                                                            <textarea id="compliant_det" name="compliant_det" class="form-control form-control-sm" rows="2" placeholder="Details"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label text-lg-right text-left col-lg-3 col-12">Attachment: </label>
                                                    <div class="col-lg-9 col-12 ">
                                                        <div class="input-group input-group-prepend">
                                                            <span class="input-group-text text-info border-right-0 rounded-0">
                                                                <i class="fas fa-book"></i>
                                                            </span>
                                                            <input type="file" name="complaint_doc" id="complaint_doc" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 offset-md-5">
                                                <div class="form-group form-actions">
                                                    <div class="col-lg-2 col-12 ">
                                                        <button type="submit" id="submit" class="btn btn-primary"> Submit </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\User\GrievanceRequest', '#compForm') !!}
    @include('user.partials.js.prevent_multiple_submit')
    <script src="{{ asset('js/jsvalidation.min.js') }}"></script>
@endpush
