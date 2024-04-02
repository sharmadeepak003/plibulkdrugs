@extends('layouts.admin.master')

@section('title')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')
    <div class="row">
        <form action="{{ route('admin.bgtracker.update', $bgview->app_id) }}" id="form-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="col-lg-12">
                <div class="row py-4">
                    <div class="col-md-12">
                        <div class="card border-info">

                            <input type="hidden" name="app_id" value="{{ $bgview->app_id }}">
                            <input type="hidden" name="bg_id" value="{{ $bgview->id }}">
                            <div class="card-header bg-info">
                                <b>
                                    <div class="text-center" style="font-size: 20px;">BG Tracker</div>
                                </b>
                            </div>
                            <div class="card-body">
                                <div class="card-body py- px-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row m-2 ">
                                                <div class="col-md-5 py-2 text-center">
                                                    <label>Applicant's Name</label>
                                                    <input type="text" value="{{ $bgview->name }}"
                                                        class="form-control form-control-sm" readonly>
                                                </div>
                                                <div class="col-md-2 py-2 text-center">
                                                    <label>Eligible Product Name</label>
                                                    <input type="text" value="{{ $bgview->product }}"
                                                        class="form-control form-control-sm" readonly>
                                                </div>
                                                <div class="col-md-5 py-2 text-center">
                                                    <label>Target Segment</label>
                                                    <input type="text" value="{{ $bgview->target_segment }}"
                                                        class="form-control form-control-sm" readonly>
                                                </div>
                                                <div class="col-md-4 py-2 ">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="bank_name" value="{{ $bgview->bank_name }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-4 py-2 ">
                                                    <label>Branch Address</label>
                                                    <input type="text" name="branch_address"
                                                        value="{{ $bgview->branch_address }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label>BG No.</label>
                                                    <input type="text" name="bg_no" value="{{ $bgview->bg_no }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-3 py-2">
                                                    <label>BG Amount</label>
                                                    <input type="number" name="bg_amount" value="{{ $bgview->bg_amount }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-3 py-2 ">
                                                    <label>Issued Date</label>
                                                    <input type="date" name="issued_dt" value="{{ $bgview->issued_dt }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-3 py-2">
                                                    <label>Expiry Date</label>
                                                    <input type="date" name="expiry_dt" value="{{ $bgview->expiry_dt }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-3 py-2 ">
                                                    <label>Claim Date</label>
                                                    <input type="date" name="claim_dt" value="{{ $bgview->claim_dt }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-4 py-2 ">
                                                    <label>BG Status</label>

                                                    <select name="bg_status" id="bg_status"
                                                        class="form-control form-control-sm" required>
                                                        <option value="" selected disabled>
                                                            @if ($bgview->bg_status == 'RO')
                                                                Roll Over
                                                            @elseif ($bgview->bg_status == 'EX')
                                                                Existing
                                                            @elseif ($bgview->bg_status == 'RE')
                                                                Release
                                                            @elseif ($bgview->bg_status == 'IN')
                                                                Invoke
                                                            @endif
                                                        </option>
                                                        <option value="EX">Existing</option>
                                                        <option value="RO">Roll Over</option>
                                                        <option value="RE">Release</option>
                                                        <option value="IN">Invoke</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 py-2 ">
                                                    <label>BG Status Remark</label>
                                                    <input type="text" name="remark" value="{{ $bgview->remark }}"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label for="bgDoc">BG Document</label>
                                                    <input type="file" name="bgDoc" id="bgDoc"
                                                        class="form-control form-control-sm" style="padding:0.1rem">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-md-5">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                class="fas fa-save"></i> Update</button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('admin.bgtracker.index') }}"
                            class="btn btn-success btn-sm form-control form-control-sm">
                            <i class="fas fa-backword right fas fa-home"></i> Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    {{-- {!! JsValidator::formRequest('App\Http\Requests\admin\BgTrackerRequest', '#form-create') !!} --}}
@endpush
