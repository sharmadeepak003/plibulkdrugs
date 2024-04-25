@extends('layouts.user.dashboard-master')

@section('title')
    Claim Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
       .hh-grayBox {
  background-color: #f8f8f8;
  margin-bottom: 20px;
  padding: 35px;
  margin-top: 20px;
}
.pt45 {
  padding-top: 45px;
}
.order-tracking {
  text-align: center;
  width: 20%;
  position: relative;
  display: block;
}
.order-tracking .is-complete {
  display: block;
  position: relative;
  border-radius: 50%;
  height: 30px;
  width: 30px;
  border: 0px solid #afafaf;
  background-color: #f7be16;
  margin: 0 auto;
  transition: background 0.25s linear;
  -webkit-transition: background 0.25s linear;
  z-index: 2;
}
.order-tracking .is-complete:after {
  display: block;
  position: absolute;
  content: "";
  height: 14px;
  width: 7px;
  top: -2px;
  bottom: 0;
  left: 5px;
  margin: auto 0;
  border: 0px solid #afafaf;
  border-width: 0px 2px 2px 0;
  transform: rotate(45deg);
  opacity: 0;
}
.order-tracking.completed .is-complete {
  border-color: #27aa80;
  border-width: 0px;
  background-color: #27aa80;
}
.order-tracking.completed .is-complete:after {
  border-color: #fff;
  border-width: 0px 3px 3px 0;
  width: 7px;
  left: 11px;
  opacity: 1;
}
.order-tracking p {
  color: #a4a4a4;
  font-size: 16px;
  margin-top: 8px;
  margin-bottom: 0;
  line-height: 20px;
}
.order-tracking p span {
  font-size: 14px;
}
.order-tracking.completed p {
  color: #000;
}
.order-tracking::before {
  content: "";
  display: block;
  height: 3px;
  width: calc(100% - 40px);
  background-color: #f7be16;
  top: 13px;
  position: absolute;
  left: calc(-50% + 20px);
  z-index: 0;
}
.order-tracking:first-child:before {
  display: none;
}
.order-tracking.completed:before {
  background-color: #27aa80;
}

    </style>
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
            @foreach ($getClaimIncentiveData as $key => $data)
            <div class="col-12">
                <div class="bu">
                    @if($data->status == 'A')
                    <span class="badge badge-success">Approved</span>
                        @elseif($data->status == 'UP')
                        <span class="badge badge-warning">Under Process</span>
                        @else
                        <span class="badge badge-danger">Rejected</span>
                        @endif
                   
                </div>
                {{-- <div class="progress" style="height: 3.5rem !important;">
                    <div class="progress-bar {{($data->claim_filing !== null)?'bg-success':'bg-danger'}}" role="progressbar" style="width: 20%;font-size: 12px;line-height: 15px;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Date of Submission of claims by beneficiary<br>{{date('Y-m-d',strtotime($data->claim_filing))}}</div>
                    <div class="progress-bar {{($data->expsubdate_reportinfo !== null)?'bg-success':'bg-danger'}}" role="progressbar" style="width: 20%;font-size: 12px;line-height: 15px;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Complete Information by Applicant<br>{{$data->expsubdate_reportinfo}}</div>
                    <div class="progress-bar {{($data->expsubdate_reportmeitytopma !== null)?'bg-success':'bg-danger'}}" role="progressbar" style="width: 20%;font-size: 12px;line-height: 15px;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Report to Ministry by PMA<br>{{$data->expsubdate_reportmeitytopma}}</div>
                    <div class="progress-bar {{($data->appr_date !== null)?'bg-success':'bg-danger'}}" role="progressbar" style="width: 20%;font-size: 12px;line-height: 15px;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Date of approval of the <br>claim by competent authority<br>{{date('Y-m-d',strtotime($data->appr_date))}}</div>
                    <div class="progress-bar {{($data->date_of_disbursal_claim_pma !== null)?'bg-success':'bg-danger'}}" role="progressbar" style="width: 20%;font-size: 12px;line-height: 15px;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Date of disbursal of claim by PMA<br>{{$data->date_of_disbursal_claim_pma}}</div>
                  </div> --}}
                  <div class="row justify-content-between">
                    <div class="order-tracking {{($data->claim_filing !== null)?'completed':''}} ">
                        <span class="is-complete"></span>
                        <p>Date of Submission of claims by beneficiary<br><span>{{date('Y-m-d',strtotime($data->claim_filing))}}</span></p>
                    </div>
                    <div class="order-tracking {{($data->expsubdate_reportinfo !== null)?'completed':''}}">
                        <span class="is-complete"></span>
                        <p>Complete Information by Applicant<br><span>{{date('Y-m-d',strtotime($data->expsubdate_reportinfo))}}</span></p>
                    </div>
                    <div class="order-tracking {{($data->expsubdate_reportmeitytopma !== null)?'completed':''}}">
                        <span class="is-complete"></span>
                        <p>Report to Ministry by PMA<br><span>{{date('Y-m-d',strtotime($data->expsubdate_reportmeitytopma))}}</span></p>
                    </div>
                    <div class="order-tracking {{($data->appr_date !== null)?'completed':''}}">
                        <span class="is-complete"></span>
                        <p>Date of approval of the claim by competent authority<br><span>{{($data->appr_date !== null)?date('Y-m-d',strtotime($data->appr_date)):''}}</span></p>
                    </div>
                    <div class="order-tracking {{($data->date_of_disbursal_claim_pma !== null)?'completed':''}}">
                        <span class="is-complete"></span>
                        <p>Date of disbursal of claim by PMA<br><span>{{($data->date_of_disbursal_claim_pma !== null)?date('Y-m-d',strtotime($data->date_of_disbursal_claim_pma)):''}}</span></p>
                    </div>
                </div>
                  
                  
                  
            </div>
            @endforeach
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
