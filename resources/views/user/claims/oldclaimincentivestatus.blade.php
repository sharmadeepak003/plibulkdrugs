@extends('layouts.user.dashboard-master')

@section('title')
    Claim Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row  justify-content-center">
        {{-- <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 offset-md-3">
                    <label>Financial Year</label>
                </div>
                <div class="col-md-2">
                    <select name="fy" id="fy" class="form-control form-control-sm">
                        <option selected disabled>Select FY</option>
                        @foreach ($fys as $fy)
                            <option value="{{ $fy }}" @if ($crr_fy_val == $fy) selected @endif>
                                {{ $fy }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="filterData" class="btn btn-sm btn-block btn-primary text-white">Filter</button>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal"
                        data-target="#ClaimCreateModal">Fill Claim Form
                    </button>
                    @include('user.claims.partials.modal.claimCreateModal')
                </div>
            </div>
        </div> --}}
        <div class="col-md-12 pt-2">
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <h5>Claim Incentive Application Status</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">Sr No</th>
                                            <th class="text-center" style="width: 20%">Date of Submission of claims by beneficiary</th>
                                            <th class="text-center">Complete Information by Applicant</th>
                                            <th class="text-center">Report to Ministry by PMA</th>
                                            <th class="text-center">Date of approval of the claim by competent authority</th>
                                            <th class="text-center">Date of disbursal of claim by PMA</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd(count($arr_claims))}} --}}
                                        @if (count($getClaimIncentiveData) > 0)
                                            @foreach ($getClaimIncentiveData as $key => $data)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td class="text-center"> {{date('Y-m-d',strtotime($data->claim_filing))}}</td>
                                                    <td class="text-center">{{$data->expsubdate_reportinfo}}</td>
                                                    <td class="text-center">{{$data->expsubdate_reportmeitytopma}}</td>
                                                    <td class="text-center">{{$data->appr_date}}</td>
                                                    <td class="text-center">{{$data->date_of_disbursal_claim_pma}}</td>
                                                   
                                                        @if($data->status == 'A')
                                                            <td class="text-center">Approved</td>
                                                        @elseif($data->status == 'UP')
                                                        <td class="text-center">Under Process</td>
                                                        @else
                                                        <td class="text-center">Rejected</td>
                                                        @endif
                                                    
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center" style="color: red">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="text-left">
                                    <a href="{{ url()->previous() }}" class="btn btn-success btn-sm form-control form-control-sm" style="width:10%;"><i class="fa fa-arrow-left"></i> Back</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#filterData").click(function(event) {
                var tarId = $('#fy').val();
                var link = '/claims/index/' + tarId;
                window.location.href = link;
            });
        });
    </script>
@endpush
