@extends('layouts.admin.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
BG TRACKER - Dashboard
@endsection

@section('content')
<div class="container  py-4 px-2 col-lg-12">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('admin.bgtracker.store') }}" id="form-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <input type="hidden" name="app_id" value="{{$appMast->id}}">
                    {{-- Bg Applicant Name & Targest Segment--}}
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Applicant Details</b>
                        </div>
                        <div class="card-body py-0 px-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row p-1 m-1 p-2">
                                            <div class="col-md-6 py-2">
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <label for="applicant_name">Applicant Name</label>
                                                    <input type="text" name="applicant_name" id="applicant_name" value="{{ $user->name }}" class="form-control form-control-sm" disabled>
                                            </div>
                                            <div class="col-md-3 py-2">
                                                <label for="target_segment">Target Segment</label>
                                                        @foreach($eligible_pro as $pro)
                                                            @if($appMast->eligible_product==$pro->id)
                                                                <input type="text" name="target_segment" id="target_segment" value="{{ $pro->target_segment }}" class="form-control form-control-sm" disabled>
                                                            @endif
                                                        @endforeach
                                            </div>
                                            <div class="col-md-3 py-2">
                                                <label for="products">Product Name</label>
                                                        @foreach($eligible_pro as $pro)
                                                            @if($appMast->eligible_product==$pro->id)
                                                                <input type="text" name="products" id="products" value="{{ $pro->product }}" class="form-control form-control-sm" disabled>
                                                            @endif
                                                        @endforeach
                                             </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--BG Detail Form--}}
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Bank Guarantee Details</b>
                        </div>
                        <div class="card-body py- px-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row m-2 ">
                                        <div class="col-md-3 py-2 ">
                                            <label for="bank_name">Bank Name</label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3 py-2 ">
                                            <label for="branch_address">Branch Address</label>
                                            <input type="text" name="branch_address" id="branch_address" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2">
                                            <label for="bg_no">BG No.</label>
                                            <input type="text" name="bg_no" id="bg_no" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2">
                                            <label for="bg_amount">BG Amount</label>
                                            <input type="text" name="bg_amount" id="bg_amount" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="issued_dt">Issued Date</label>
                                            <input type="date" name="issued_dt" id="issued_dt" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2">
                                            <label for="expiry_dt">Expiry Date</label>
                                            <input type="date" name="expiry_dt" id="expiry_dt" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="claim_dt">Claim Date</label>
                                            <input type="date" name="claim_dt" id="claim_dt" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 py-2 ">
                                            <label for="bg_status">BG Status</label>
                                            <select name="bg_status" id="bg_status" class="form-control form-control-sm">
                                                <option value="" selected disabled>Please select</option>
                                                <option value="EX">Existing</option>
                                                <option value="RO">Roll Over</option>
                                                <option value="RE">Release</option>
                                                <option value="IN">Invoke</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 py-2 ">
                                            <label for="remark">BG Status Remark</label>
                                            <input type="text" name="remark" id="remark" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3 py-2">
                                            <label for="bgDoc">BG Document</label>
                                            <input type="file" name="bgDoc" id="bgDoc" class="form-control form-control-sm" style="padding:0.1rem">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Save Button--}}
                    <div class="row">
                        <div class="col-md-2 offset-md-5">
                           <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" ><i class="fas fa-save"></i> Save</button>
                        </div>
                    </div>
             </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\admin\BgTrackerRequest', '#form-create') !!}
@endpush

