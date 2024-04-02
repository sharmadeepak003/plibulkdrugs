@extends(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry') ? 'layouts.admin.master' : 'layouts.user.dashboard-master')

@section('title')
    Claim Preview
@endsection
@push('styles')

    <style>
        .claim-text{
            text-align: right;
        }
        .claim-width{
            width: 10%;
        }
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        @if (AUTH::user()->hasRole('Admin'))
        <div class="row">
            <div class="col-md-12">
                <div style="float:right; padding:0;">
                    <a onclick="return confirm('Are you sure?')" href="{{ route('admin.claim.editmode',$claimMast->claim_id) }}"
                        class="btn btn-warning btn-sm btn-block " id="">Open Claim In Edit Mode</i></a>
                </div>
            </div>
        </div>
        @endif

      <div class="card card-info card-tabs">

        <div class="card-header pt-1 text-bold">
            <p class="text-center" id="FY">
                <b>Claim Form Financial Year : 2022-23</b>
            </p>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="appTab" data-toggle="pill" href="#applicantdetail" role="tab"
                    aria-controls="appTabContent" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#salesdetails" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Sales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#dvadetails" role="tab"
                    aria-controls="appTabContent" aria-selected="false">DVA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#investmentdetail" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Investment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#projectdetail" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Project Detail</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#rptdetails" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Related Party Transaction</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#uploadA" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Document-A</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#uploaddetails" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Document-B</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#optionSectionDoc" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Miscellaneous(Optional)</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link " id="appTab" data-toggle="pill" href="#clause" role="tab"
                    aria-controls="appTabContent" aria-selected="false">Clause 15.12</a>
            </li> --}}
        </ul>
        </div>

         <div class="card-body p-0">
            <div class="tab-content" >
               <div class="tab-pane fade active show" id="applicantdetail" role="tabpanel"
                  aria-labelledby="appTabContent-tab">
                     <div class="card border-primary mt-2" id="comp">
                        <div class="card border-primary">
                              <div class="card-header bg-gradient-info">
                                 <b>Applicant's Details</b>
                              </div>
                              <div class="card-body">
                                 <table class="table table-sm table-bordered table-hover">
                                    <tbody>
                                       <tr>
                                          <td class="text-center">1</td>
                                          <th>Name of Applicant:</th>
                                          <td colspan="2">{{$appMast->name}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">2</td>
                                          <th>Corporate Office Address</th>
                                          <td colspan="2">{{$users->off_add}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">3</td>
                                          <th>Target Segment</th>
                                          <td colspan="2">{{$appMast->target_segment}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">4</td>
                                          <th>Eligible Product on which incentive is being claimed:</th>
                                          <td colspan="2">{{$appMast->product}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">5</td>
                                          <th>Application No.:</th>
                                          <td colspan="2">{{$appMast->app_no}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">6</td>
                                          <th>HSN Code of above Eligible Product</th>
                                          <td colspan="2">{{$claimMast->hsn}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">7</td>
                                          <th>Committted Capacity(MT)</th>
                                          <td colspan="2">{{$claimMast->committed_capacity}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">8</td>
                                          <th>Quoted Sales Price (Rs./Kg)</th>
                                          <td colspan="2">{{$claimMast->quoted_sales}}</td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">9</td>
                                          <th>Approval Letter issued on (Date)</th>
                                          <td colspan="2"></td>
                                       </tr>
                                       <tr>
                                          <td class="text-center">10</td>
                                          <th>Approval Letter No.</th>
                                          <td colspan="2"></td>
                                       </tr>

                                       <tr>
                                          <td class="text-center">11</td>
                                          <th>Period for which Incentive is being claimed</th>
                                          <td colspan="2">
                                             <table class="sub-table text-center " style="width: 100%">
                                                <thead>
                                                      <tr class="table-primary">
                                                         <th class="text-center ">Claim Filling Period</th>
                                                         <th class="text-center">Quarter</th>
                                                      </tr>
                                                </thead>
                                                <tr>
                                                      <td style="width: 50%">
                                                         @if($claimMast->claim_fill_period==1) Quarterly @endif
                                                         @if($claimMast->claim_fill_period==2) Half-Yearly @endif
                                                         @if($claimMast->claim_fill_period==3) Nine Months @endif
                                                         @if($claimMast->claim_fill_period==4) Annual @endif
                                                      </td>
                                                      <td>
                                                         <div id="quarterly_claim_empty" @if($claimMast->claim_fill_period=='' || $claimMast->claim_fill_period==1 || $claimMast->claim_fill_period==2 || $claimMast->claim_fill_period==3 || $claimMast->claim_fill_period==4) style="display:none" @endif>
                                                         </div>

                                                         <div id="quarterly_claim" @if($claimMast->claim_fill_period=='' || $claimMast->claim_fill_period==2 || $claimMast->claim_fill_period==3 || $claimMast->claim_fill_period==4) style="display:none" @endif >
                                                            @foreach($arr_qtr as $qtr_val)
                                                            @if($qtr_val->qtr_id.'@_@'.$qtr_val->qtr_id==$claimMast->incentive_from_date.'@_@'.$claimMast->incentive_to_date) {{$qtr_val->start_month}} - {{$qtr_val->month}} @endif
                                                            @endforeach
                                                         </div>
                                                         <div id="half_hearly_claim" @if($claimMast->claim_fill_period=='' || $claimMast->claim_fill_period==1 || $claimMast->claim_fill_period==3 || $claimMast->claim_fill_period==4) style="display:none" @endif >
                                                                  @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr_id) &&  isset($arr_qtr->where('month','Sep')->first()->qtr_id))
                                                                     @if($arr_qtr->where('start_month','Apr')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Sep')->first()->qtr_id==$claimMast->incentive_from_date.'@_@'.$claimMast->incentive_to_date) April - September @endif
                                                                  @endif

                                                                  @if(isset($arr_qtr->where('start_month','Oct')->first()->qtr_id) &&  isset($arr_qtr->where('month','Mar')->first()->qtr_id))
                                                                      @if($arr_qtr->where('start_month','Oct')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Mar')->first()->qtr_id==$claimMast->incentive_from_date.'@_@'.$claimMast->incentive_to_date) October - March @endif
                                                                  @endif
                                                         </div>

                                                         <div id="nine_months_claim" @if($claimMast->claim_fill_period=='' || $claimMast->claim_fill_period==1 || $claimMast->claim_fill_period==2 || $claimMast->claim_fill_period==4) style="display:none" @endif>
                                                                @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr_id) &&  isset($arr_qtr->where('month','Dec')->first()->qtr_id))
                                                                April - December
                                                                @endif
                                                         </div>

                                                         <div id="annual_claim" @if($claimMast->claim_fill_period=='' || $claimMast->claim_fill_period==1 || $claimMast->claim_fill_period==2 || $claimMast->claim_fill_period==3) style="display:none" @endif>

                                                                  @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr_id) &&  isset($arr_qtr->where('month','Mar')->first()->qtr_id))
                                                                    April - September
                                                                  @endif
                                                            </select>
                                                         </div>
                                                      </td>
                                                </tr>
                                             </table>
                                          </td>
                                    </tr>
                                       {{-- <tr>
                                          <td class="text-center">12</td>
                                          <th>Greenfield Manufacturing location/s where Eligible Product<br> on which incentive is being
                                             claimed.
                                          </th>
                                          <td>
                                             <table class="table table-bordered" id="dynamic_field">
                                                <tr>
                                                   <th class="text-center" colspan="3">Address</th>
                                                </tr>

                                                @foreach($manuf_loc as $key => $location)
                                                <tr>
                                                   <td style="" colspan="3">
                                                      {{ $location->address }}
                                                   </td>
                                                </tr>
                                                @endforeach
                                                </tr>
                                                   <th class="text-center ">State</th>
                                                   <th class="text-center">City</th>
                                                   <th class="text-center">Pincode</th>

                                                </tr>
                                                <tr>
                                                   @foreach($manuf_loc as $key => $location)
                                                   <tr>
                                                      <td style="width: 780px">
                                                            {{ $location->state }}
                                                      </td>
                                                      <td style="width: 780px">
                                                            {{ $location->city }}
                                                      </td>
                                                      <td style="width: 780px">
                                                            {{ $location->pincode }}
                                                      </td>
                                                   </tr>
                                                   @endforeach
                                                </tr>
                                             </table>
                                          </td>
                                       </tr> --}}
                                    </tbody>
                                 </table>
                              </div>
                        </div>
                           {{-- Equity Shareholding of the Applican --}}
                        <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                              <b>B. Equity Shareholding pattern of the Applicant (to be pre-filled from as on date of application filing/ edit module)
                              </b>
                        </div>
                        <div class="card-body">
                              <table class="table table-sm table-bordered table-hover">
                                 <thead>
                                    <tr class="table-primary">
                                    <th class="text-center">S.N</th>
                                    <th class="text-center">Name of Shareholder</th>
                                    <th class="text-center">No. of equity shares</th>
                                    <th class="text-center">Percentage (%)</th>
                                    </tr>
                                 </thead>
                                 @foreach($old_shareholder as $key=> $sholder)
                                 <tbody>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center">{{$sholder->name}}</td>
                                    <td class="text-center">{{$sholder->shares}}</td>
                                    <td class="text-center">{{$sholder->per}}</td>
                                 </tbody>
                                 @endforeach
                              </table>
                        </div>

                        <div class="card-body mt-4">
                              <table class="table table-sm table-bordered table-hover">
                                 <thead>
                                    @foreach($claimUserResponse as $q)
                                    @if($q->ques_id == 1)
                                    <tr>
                                    <th colspan="3" class="text-left">Whether there is any change in shareholding pattern at the time of filing claim from application date?</th>
                                    <td class="text-center" class="claim-width">
                                          @if($q->response == 'Y')
                                             Yes
                                          @else
                                             No
                                          @endif
                                    </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                 </thead>
                              </table>
                        </div>
                        @foreach($claimUserResponse as $q)
                        @if($q->ques_id == 1)
                        <div class="card border-primary display m-2 py-10" style=" @if ($q->response == 'Y') display  @else display:none; @endif">
                              <div class="card-header bg-gradient-info">
                                 <b>New Shareholding</b>
                              </div>
                              <div class="card-body">
                                 <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                    <tr>
                                          <th>Reason for change in shareholding pattern</th>
                                          <td >@if(!empty($shareholding_change->reason_for_change))  {{$shareholding_change->reason_for_change}}
                                             @endif </td>


                                          <th>Date of change in Shareholding Pattern</th>
                                          <td>@if(!empty($shareholding_change->date_of_change)) {{$shareholding_change->date_of_change}}  @endif  </td>
                                    </tr>
                                    </thead>
                                 </table>
                                 <table class="table table-sm table-bordered table-hover" id="dynamic_field1">
                                    <thead>
                                    <tr>
                                          <th colspan="4" class="text-center">New Shareholding Pattern</th>
                                    </tr>
                                    <tr>
                                          <th class="text-center">S.N</th>
                                          <th class="text-center">Name of Shareholder</th>
                                          <th class="text-center">No. of equity shares</th>
                                          <th class="text-center">Percentage (%)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shareholder as $key=>$new_sholder)
                                    <tr>

                                          <td class="text-center">{{ $key + 1 }}</td>
                                          <td class="text-center">{{$new_sholder->new_shareholder_name}}</td>
                                          <td class="claim-text">{{$new_sholder->new_equity_share}}</td>
                                          <td class="claim-text">{{$new_sholder->new_percentage}}</td>

                                    </tr>
                                    @endforeach
                                    </tbody>
                                 </table>
                              </div>
                        </div>
                        @endif
                        @endforeach
                        <div class="card-body mt-2">
                                 <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                    @foreach($claimUserResponse as $q)
                                          @if($q->ques_id == 2)
                                          <tr>
                                             <th colspan="3" class="text-left">Whether there is any 'successor in interest'
                                             as per clause 2.30 of the scheme guidelines due to change in shareholding
                                             pattern or any other reason.</th>
                                             <td class="text-center"  class="claim-width">
                                             @if($q->response == 'Y')
                                             Yes
                                             @else
                                             No
                                             @endif
                                             </td>
                                          </tr>
                                          @endif
                                          @endforeach
                                    </thead>
                                 </table>
                              </div>
                              @foreach($claimUserResponse as $q)
                              @if($q->ques_id == 2)
                              <div class="card-body mt-2">
                                 <table class="table table-sm display1 table-bordered table-hover" style=" @if ($q->response == 'Y') display  @else display:none; @endif">
                                    <thead>
                                          <tr>
                                          <th>Applicant needs to upload copies of all the relevant documents in respect of the transaction resulting in successor in interest alongwith request to get  approval from EC as per clause 17.2 of the scheme guidelines.</th>
                                          @foreach ($sh_docs as $key => $sh_doc)
                                             @if($sh_doc->upload_id)
                                                <td class="text-center p-2"  class="claim-width"><a class="mt-2 btn btn-success btn-sm" href="{{ route('doc.download', encrypt($sh_doc->upload_id)) }}">View</a>
                                             </td>
                                             @endif
                                          @endforeach
                                          </tr>
                                    </thead>
                                 </table>
                              </div>
                              @endif
                              @endforeach
                        </div>
                        <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                              <b>C. Detail of Statutory Auditors</b>
                        </div>
                        <div class="card-body">
                              <table class="table table-sm table-bordered table-hover" id="dynamic_field2">

                                 <tbody>
                                    <tr class="table-primary">
                                    <th class="text-center" colspan="2">Name of the firm</th>
                                    <th class="text-center" colspan="2">Date of appointment as statutory audit</th>
                                    <th class="text-center" colspan="2">Appointment valid up to</th>
                                    </tr>
                                    <tr>

                                    <td colspan="2" class="text-center">{{trim($claimMast->firm_name)}}</td>
                                    <td colspan="2" class="text-center">{{$claimMast->date_of_appointment}}</td>
                                    <td class="text-center" colspan="2">{{$claimMast->appointment_valid_upto}}</td>
                                    </tr>
                                    <tr>
                                    <th colspan="6">Details of Certificate</th>
                                    </tr>
                                    <tr>
                                    <th>Date</th>
                                    <th>UDIN</th>
                                    <th>Name Of Partner</th>
                                    <th>Email ID</th>
                                    <th>Contact Number of Signing Partner</th>
                                    </tr>
                                    <tr>
                                    <td>{{$claimMast->date_of_certificate}}</td>
                                    <td>{{trim($claimMast->udin)}}</td>
                                    <td>{{trim($claimMast->partner_name)}}</td>
                                    <td>{{$claimMast->email}}</td>
                                    <td>{{$claimMast->mobile_signing_partner}}</td>
                                    </tr>
                                 </tbody>
                              </table>
                        </div>
                        </div>
                     </div>
               </div>

               <div class="tab-pane fade" id="salesdetails" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                    <div class="card-header bg-gradient-info">
                        <b>Sales Details</b>
                     </div>
                     <div class="card border-info">
                        <div class="card-header bg-gradient-info">
                           <div class="row">
                              <div class="col-md-12 text-bold">
                                 2.1 Sales of eligible products as per approval letter on which incentive is being claimed
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="table-responsive">
                                       <table id="exmple" class="table table-sm table-striped table-bordered table-hover">
                                          <thead>
                                             <tr>
                                                   <th class="text-center">Name of Eligible Product</th>
                                                   <td class="text-center">{{$product->product}}</td>
                                                   <th rowspan="3" class="text-center">Quantity(in MT)</th>
                                                   <th  rowspan="3" class="text-center">Actual Sales Amount(₹)</th>
                                                   <th  rowspan="3" class="text-center">Sales considered for Incentive (Lower of Actual selling price and Quoted Sales Price) (₹)
                                                   </th>
                                             </tr>
                                             <tr>
                                                   <th>Quoted Sales Price(₹)</th>
                                                   <td class="claim-text">{{$claimApproval->quoted_sales_price}} </td>
                                             </tr>
                                             <tr>
                                                   <th>HSN Code</th>
                                                   <td class="claim-text">{{$claimApproval->hsn}}</td>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                   <td colspan="2">Domestic Sales</td>
                                                   <td class="claim-text">{{$claimApproval->dom_qty}}</td>
                                                   <td class="claim-text">{{$claimApproval->dom_sales}}</td>
                                                   <td class="claim-text">{{$claimApproval->dom_incentive}}</td>
                                             </tr>
                                             <tr>
                                                   <td colspan="2">Export Sales</td>
                                                   <td class="claim-text">{{$claimApproval->exp_qty}}</td>
                                                   <td class="claim-text">{{$claimApproval->exp_sales}}</td>
                                                   <td class="claim-text">{{$claimApproval->exp_incentive}}</td>
                                             </tr>
                                             <tr>
                                                   <td colspan="2">In-House Consumption</td>
                                                   <td class="claim-text">{{$claimApproval->cons_qnty}}</td>
                                                   <td class="claim-text">{{$claimApproval->cons_sales}}</td>
                                                   <td class="claim-text">{{$claimApproval->cons_incentive}}</td>
                                             </tr>
                                             <tr>
                                                   <th colspan="2">Total(A)</th>
                                                   <td class="claim-text">{{$claimApproval->ts_total_qnty}}</td>
                                                   <td class="claim-text">{{$claimApproval->ts_total_sales}}</td>
                                                   <td class="claim-text">{{$claimApproval->ts_total_incentv}}</td>
                                             </tr>
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card border-info">
                         <div class="card-header bg-gradient-info">
                             <div class="row">
                                 <div class="col-md-12 text-bold">
                                     2.2 Sales of Eligible products as per QRR and as per incentive claim.
                                 </div>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="table-responsive">
                                         <table id="dynamic_field12" class="table table-sm table-striped table-bordered table-hover">
                                             <thead>
                                                 <tr  class="table-primary">

                                                     <th rowspan="2" class="text-center">Name of ELigible Product</th>
                                                     <th rowspan="1" colspan="2">Sales as per QRR </th>
                                                     <th rowspan="1" colspan="2">Sales for Incentive Claim
                                                     </th>
                                                     <th rowspan="1" colspan="2">Difference
                                                     </th>
                                                     <th rowspan="2">Reasons for difference(Note: If difference is zero then fill NA.) </th>
                                                 </tr>
                                                 <tr>
                                                     <th >Quantity(MT)</th>
                                                     <th >Amount(₹)</th>
                                                     <th >Quantity(MT)</th>
                                                     <th >Amount(₹)</th>
                                                     <th >Difference Quantity(MT)</th>
                                                     <th >Difference Amount(₹)</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <tr>
                                                     <td>Domestic Sales</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_dom_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_dom_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_dom_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_dom_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_dom_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_dom_sales}}</td>
                                                     <td class="text-center">{{$claimAsQrr->dom_reason_diff}}</td>
                                                 </tr>
                                                 <tr>

                                                     <td>Export Sales</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_exp_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_exp_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_exp_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_exp_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_exp_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_exp_sales}}</td>
                                                     <td class="text-center">{{$claimAsQrr->exp_reason_diff}}</td>
                                                 </tr>
                                                 <tr>

                                                     <td>In-house Consumption</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_cons_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->old_qrr_cons_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_cons_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->new_qrr_cons_sales}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_cons_qnty}}</td>
                                                     <td class="claim-text">{{$claimAsQrr->diff_cons_sales}}</td>
                                                     <td class="text-center">{{$claimAsQrr->cons_reason_diff}}</td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="card border-primary">
                         @foreach ($claimUserResponse as $q)

                         @if ($q->ques_id == 3)
                             <div class="card-body">
                                 <div class="card-body mt-4">
                                     <table class="table table-sm table-bordered table-hover">
                                         <thead>
                                             <tr style="background:white;">
                                                 <th col="9" class="text-left">2.3 Whether there is any sales of
                                                     manufactured aligible product to related party as defined under clause 2.29 of scheme guidelines</th>

                                                 <td col="3" class="text-center">
                                                     @if ($q->response == 'Y')
                                                         Yes
                                                     @else
                                                         No
                                                     @endif
                                                 </td>
                                             </tr>
                                         </thead>
                                     </table>
                                 </div>

                                 <div class="card border-primary display m-2 py-10"
                                     style=" @if ($q->response == 'Y') display  @else display:none; @endif">
                                         <div class="card-body">
                                             <table class="table table-sm table-bordered table-hover">
                                                 <thead class="">
                                                     <tr>
                                                         <th>
                                                             @if(count($claimSalesManufTsGoods)>0)
                                                                 {{$claimSalesManufTsGoods[0]->product_name}}
                                                             @endif
                                                         </th>
                                                     </tr>
                                                 </thead>
                                             </table>
                                             <table class="table table-sm table-bordered table-hover" id="dynamic_field">
                                                 <thead class="bg-gradient-info">
                                                     <tr>
                                                         <th class="text-center">S.N</th>
                                                         <th class="text-center">Name of Related Party</th>
                                                         <th class="text-center">Relationship</th>
                                                         <th class="text-center">Quantity(in MT)</th>
                                                         <th class="text-center">Sales of EP(₹)</th>
                                                         <th class="text-center" style="text-decoration:none"><button
                                                                 type="button" name="add" id="add"
                                                                 class="btn btn-success">Add
                                                                 More</button>
                                                         </th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>

                                                     @foreach ($claimSalesManufTsGoods as $key => $manufact_data)
                                                     <tr>
                                                         <td class="text-center">{{$key+1}}</td>
                                                         <td class="text-center">{{ $manufact_data->related_party_name }}
                                                         </td>
                                                         <td class="text-center">{{$manufact_data->relationship }}</td>
                                                         <td class="claim-text">{{$manufact_data->quantity }}
                                                         </td>

                                                     </td>
                                                         <td class="claim-text">{{ $manufact_data->sales_ep }}
                                                         </td>
                                                         <td></td>
                                                     </tr>
                                                     @endforeach
                                                 </tbody>

                                                 <tfoot>
                                                     <td class="text-center" colspan="3">
                                                         Total
                                                     </td>

                                                     <td class="claim-text">{{$claimSalesManufTsGoods->sum('quantity')}}
                                                     </td>
                                                     <td class="claim-text">{{$claimSalesManufTsGoods->sum('sales_ep')}}
                                                     </td>
                                                     <td style=""></td>
                                                 </tfoot>
                                             </table>
                                         </div>
                                 </div>
                             </div>
                         @endif
                         @endforeach
                     </div>
                     <div class="card border-info">
                         <div class="card-header bg-gradient-info">
                             <div class="row">
                                 <div class="col-md-12 text-bold">
                                     2.4 Reconciliation of Total Sales from Greenfield Project of Eligible Product
                                 </div>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="table-responsive">
                                         <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                             <thead>
                                                 <tr class="table-primary">
                                                     <th>Particulars</th>
                                                     <th colspan="2">Amount</th>
                                                 </tr>
                                             </thead>

                                             <tbody>
                                                 @foreach ($claimRecSales as $recSales)

                                                     <tr>
                                                         @if ($recSales->part_id == 1)
                                                             <td>Total Income as per Financial Statements (A)</td>

                                                             <td colspan="2" class="claim-text">
                                                                 {{ $recSales->amount }}
                                                             </td>
                                                         @endif
                                                     </tr>
                                                     <tr>
                                                         @if ($recSales->part_id == 2)
                                                             <td>Sales of Eligible Product on which incentive has been claimed
                                                                 (B)
                                                             </td>

                                                             <td colspan="2" class="claim-text">
                                                                {{ $recSales->amount }}
                                                             </td>
                                                         @endif
                                                     </tr>
                                                     <tr>
                                                         @if ($recSales->part_id == 3)
                                                             <td>Income not pertaining to Greenfield Project(A-B)</td>

                                                             <td colspan="2" class="claim-text">
                                                                 {{ $recSales->amount }}
                                                             </td>
                                                         @endif
                                                     </tr>
                                                 @endforeach
                                             </tbody>
                                         </table>
                                         <table id="dynamic_field2"
                                             class="table table-sm table-striped table-bordered table-hover">
                                             <div class="font-weight-bold">Please provide break-up of income not pertaining
                                                 Greenfield Project</div>
                                             <thead>
                                                 <tr class="table-primary">
                                                     <th>Particulars</th>
                                                     <th colspan="2">Amount</th>
                                                 </tr>
                                             </thead>
                                             <tbody>

                                                 @foreach ($claimRecSales as $key => $recSales)
                                                     @if ($recSales->part_id != 1 && $recSales->part_id != 2 && $recSales->part_id != 3)
                                                         <tr>
                                                             <td>

                                                                 @if($recSales->part_id == 9)
                                                                 Miscellaneous other income (please specify nature)
                                                                 {{$recSales->particular_name}}

                                                                 @elseif($recSales->part_id == 4 || $recSales->part_id == 5 || $recSales->part_id == 6 || $recSales->part_id == 7|| $recSales->part_id == 8)
                                                                     {{ $recSales->particular_name }}

                                                                 @else
                                                                 {{$recSales->particular_name}}
                                                                 @endif
                                                             </td>

                                                             <td colspan="2" class="claim-text">
                                                                {{ $recSales->amount }}
                                                             </td>

                                                         </tr>
                                                     @endif
                                                 @endforeach
                                             </tbody>
                                             <tfoot>
                                                 <tr>
                                                     <th colspan="1" class="text-center">Grand
                                                         Total</th>
                                                     <td class="claim-text">{{$claimRecSales[1]->ts_goods_total}}</td>
                                                 </tr>
                                             </tfoot>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                     <div class="card border-info">
                         <div class="card-header bg-gradient-info">
                             <div class="row">
                                 <div class="col-md-12 text-bold">
                                     2.5 Baseline Sales Declaration
                                 </div>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div>
                                         <table>
                                             <tbody>
                                                 <tr>
                                                     <td><input type="checkbox" id="baseline_tick" name="baseline_tick" value="Y" @if($claimBaselineSales->response == 'Y') checked @else @endif disabled></td>
                                                     <td>We hereby confirm that the approved project is Greenfiled  project as per clause 2.18 of the Scheme Guidelines, Accordingly Baseline Sales for FY 2019-20 is Nil.
                                                     </td>
                                                     <td>(₹)<input type="number" id='baseline_zero' name="baseline_amount" value="{{$claimBaselineSales->amount}}" class="form-control form-control-sm add_zero" readonly></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="card border-primary">
                         @foreach ($claimUserResponse as $q)
                         @if ($q->ques_id == 4)
                             <div class="card-body">
                                 <table class="table table-sm table-bordered table-hover ">
                                     <thead>
                                         <tr style="background:white;">
                                             <th colspan="3" class="text-left">2.6 Please confirm whether there is any in house consumption, claimed for incentive as per clause 14.4 (d) of the Scheme Guidelines.
                                             </th>
                                             <td colspan="2" class="text-center">
                                                @if ($q->response == 'Y') Yes   @else No
                                                @endif
                                             </td>
                                         </tr>
                                     </thead>
                                 </table>
                             </div>

                             <div class="card border-primary display17 m-2 py-10" style="@if ($q->response == 'Y') display  @else display:none; @endif">
                                 <div class="card-body">
                                     <table class="table table-sm table-bordered table-hover" id="dynamic_field17">
                                         <thead class="bg-gradient-info">
                                             <tr>
                                                 <th class="text-center">Details of the product in which same were utilised</th>
                                                 <th class="text-center">Quantity of Eligible Product Utilised (kg) </th>
                                                 <th class="text-center">Cost of Production(Rs.)</th>
                                                 <th>File</th>
                                             </tr>
                                         </thead>

                                         <tbody>

                                             <td>@if($claimSalesConsumption){{$claimSalesConsumption->product_name_utilised}}
                                                @endif
                                             </td>
                                             <td class="claim-text">
                                                 @if($claimSalesConsumption){{$claimSalesConsumption->quantity_of_ep}}
                                                 @endif
                                            </td>
                                             <td class="claim-text">@if($claimSalesConsumption){{$claimSalesConsumption->cost_production}}@endif
                                            </td>
                                             @foreach ($claimSalesDoc as $saleDoc)
                                             @if ($saleDoc->doc_id == 1032)
                                                 <td class="text-center p-2 ">
                                                 <a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', encrypt($saleDoc->upload_id)) }}">View</a> </td>
                                             @endif
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         @endif

                         @if ($q->ques_id == 5)

                             <div class="card-body mt-4">
                                 <table class="table table-sm table-bordered table-hover ">
                                     <thead>
                                         <tr style="background:white;">
                                             <th colspan="3" class="text-left">2.7 Please confirm whether there is  any
                                                 unsettled claim, discount, rebate, etc. which has not been adjusted from
                                                 sales.</th>

                                             <td colspan="2" class="text-center">
                                                         @if ($q->response == 'Y') Yes  @else No @endif
                                             </td>
                                         </tr>
                                     </thead>
                                 </table>
                             </div>
                             <div class="card border-primary display3 m-2 py-10"
                                 style="@if ($q->response == 'Y') display  @else display:none; @endif">
                                 <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover" id="dynamic_field3">
                                    <tbody>
                                    <tr>
                                        <td class="text-center">File</td>
                                        @foreach ($claimSalesDoc as $saleDoc)
                                        @if ($saleDoc->doc_id == 201)
                                            <th class="text-center p-2 "><a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', encrypt($saleDoc->upload_id)) }}">View</a>
                                            </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </tbody>
                                    </table>
                                 </div>
                             </div>

                         @endif
                         @if ($q->ques_id == 6)

                             <div class="card-body mt-4">
                                 <table class="table table-sm table-bordered table-hover ">
                                     <thead>
                                         <tr style="background:white;">
                                                 <th colspan="3" class="text-left">2.8 Please confirm whether sales is net of credit notes (raised for any purpose), discounts (including but not limited to cash, volume, turnover,<br>target or any other purpose) and taxes applicable.</th>
                                                 <td colspan="2" class="text-center">
                                                     @if ($q->response == 'Y') Yes   @else No @endif
                                                 </td>
                                             </tr>

                                     </thead>
                                 </table>
                             </div>
                             <div class="card border-primary display4 m-2 py-10"
                                 style="@if ($q->response == 'N') display  @else display:none; @endif">
                                 <div class="card-body">
                                     <table class="table table-sm table-bordered table-hover" id="dynamic_field4">
                                         <tbody>
                                             <tr>
                                                <td class="text-center">File</td>
                                                @foreach ($claimSalesDoc as $saleDoc)
                                                    @if ($saleDoc->doc_id == 202)
                                                        <td class="text-center p-2 "><a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', encrypt($saleDoc->upload_id)) }}">View</a>
                                                        </td>
                                                    @endif
                                                @endforeach
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>

                         @endif
                         @if ($q->ques_id == 7)
                             <div class="card-body mt-4">
                                 <table class="table table-sm table-bordered table-hover ">
                                     <thead>
                                         <tr style="background:white;">
                                             <th colspan="3" class="text-left">2.9 All adjustments related to sales
                                                 consideration have been adjusted from the sales and no such item has
                                                 been
                                                 accounted
                                                 for as expense.</th>
                                             <td colspan="2" class="text-center">
                                                    @if ($q->response == 'Y') Yes
                                                    @else No
                                                    @endif
                                             </td>
                                         </tr>
                                     </thead>
                                 </table>
                             </div>

                             <div class="card border-primary display5 m-2 py-10"
                                 style="@if ($q->response == 'N') display  @else display:none; @endif">
                                 <div class="card-body">
                                     <table class="table table-sm table-bordered table-hover" id="dynamic_field5">
                                         <tbody>
                                            <tr>
                                                <td class="text-center">File</td>
                                                @foreach ($claimSalesDoc as $key=>$saleDoc)
                                                    @if ($saleDoc->doc_id == 203)
                                                    <td class="text-center p-2 "><a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', encrypt($saleDoc->upload_id)) }}">View</a>
                                                    </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                         </thead>

                                     </table>
                                 </div>
                             </div>
                         @endif

                         @if ($q->ques_id == 8)
                             <div class="card-body mt-4">
                                 <table class="table table-sm table-bordered table-hover ">
                                     <thead>
                                         <tr style="background:white;">
                                             <th colspan="3" class="text-left">2.10 Please confirm if the company has entered into any contract agreement for manufacturing Eligible Products.If yes provide copy of agreement</th>

                                             <td colspan="2" class="text-center">

                                                 @if ($q->response == 'Y') Yes   @else No @endif

                                             </td>
                                         </tr>

                                     </thead>
                                 </table>
                             </div>

                             <div class="card border-primary display6 m-2 py-10"
                                 style="@if ($q->response == 'Y') display  @else display:none; @endif">
                                 <div class="card-body">
                                     <table class="table table-sm table-bordered table-hover" id="dynamic_field6">
                                         <tbody>
                                             @if ($q->response == 'Y')
                                             @foreach ($claimSalesContractAgreement as $key=> $contractAgreement)
                                             <tr>
                                                <td class="text-center">File</td>
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', encrypt($contractAgreement->upload_id) ) }}">View</a></td>
                                             </tr>
                                             @endforeach
                                             @endif
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                           @endif
                           @endforeach
                        </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="dvadetails" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                    <div class="card-header bg-gradient-info">
                        <b>Domestic Value Addition</b>
                     </div>
                     <div class="card-body py-1 px-1">
                        <div class="row">
                            <div class="table-responsive rounded col-md-12">
                                <table class="table table-bordered table-hover table-sm" id="dynamic_field">
                                    <thead class="bg-gradient-info">
                                        <th>Key Raw Material & Services </th>
                                        <th>Country of Origin </th>
                                        <th>Name of the Suppliers </th>
                                        <th>Quantity (MT)
                                        </th>
                                        <th>Amount (₹)
                                        </th>
                                        <th>Amount against per kg of finished<br> goods produced / goods sold</th>
                                    </thead>
                                    <tbody>

                                        @php $index_raw_material=0 @endphp
                                        @foreach ($raw_material as $Key => $material)

                                            @if($material->raw_material != 'Service Obtained')
                                            <tr>
                                                <td>{{$material->raw_material}}</td>
                                                <td>@if($material->country_origin == 'India')India @endif @if($material->country_origin == 'Outside India')Outside India @endif</td>
                                                <td>{{$material->supplier_name}}</td>
                                                <td class="claim-text">{{$material->quantity}}</td>
                                                <td class="claim-text">{{$material->amount}}</td>
                                                <td class="claim-text">{{$material->goods_amt}}</td>
                                            </tr>
                                            @php $index_raw_material++; @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 1)
                                        <tr>
                                            <td colspan="4">Other Consumables</td>

                                            <td class="claim-text">{{$data->amount}}</td>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 2)
                                        <tr>
                                            <td colspan="4">Salary Expenses</td>
                                            <td class="claim-text">{{$data->amount}}</td>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 3)
                                        <tr>
                                            <td colspan="4">Other Expenses</td>
                                            <td class="claim-text">{{$data->amount}}</td>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @foreach ($raw_material as $Key => $material)
                                            @if($material->raw_material == 'Service Obtained')
                                            <tr>
                                                <td>Services Obtained </td>
                                                <td>@if($material->country_origin == 'India')India @endif @if($material->country_origin == 'Outside India')Outside India @endif</td>
                                                <td colspan="2">{{$material->supplier_name}}</td>
                                                <td class="claim-text">{{$material->amount}}</td>
                                                <td class="claim-text">{{$material->goods_amt}}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 4)
                                        <tr>
                                            <th colspan="3">Total Quantity of Finished Goods Produced (kg) and Cost of Production
                                            </th>
                                            <td class="claim-text">{{$data->quantity}}</td>
                                            <td class="claim-text">{{$data->amount}}</td>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="6">Out of Total Cost above</th>
                                        </tr>
                                        @foreach($other_data as $key=>$data)
                                        @if($data->prt_id == 5)
                                        <tr>
                                            <th colspan="5">(i) Non-Originating Raw Material per kg of unit produced(As per clause 2.6 of the Scheme Guidelines) - B
                                            </th>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 6)
                                        <tr>
                                            <th colspan="5">(ii) Non-Originating Services and Other Expenses per kg of unit produced (As per clause 2.6 of the Scheme Guidelines) -B </th>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 7)
                                        <tr>
                                            <th colspan="5">(A) Cost of non-originating RM, Services and other expenses per kg of unit produced
                                            </th>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 8)
                                        <tr>
                                            <td colspan="3">(B) Net Sales of Eligbile Product (per kg) (Actual Selling Price)
                                            </td>
                                            <td class="claim-text">{{$data->quantity}}</td>
                                            <td class="claim-text">{{$data->amount}}</td>
                                            <td class="claim-text">{{$data->goods_amt}}</td>
                                        </tr>
                                        @endif
                                        @if($data->prt_id == 9)
                                        <tr>
                                            <td colspan="5">Domestic Value Addition (%) (B-A)/(B)
                                            </td>
                                            <td class="claim-text">{{round($data->goods_amt, 2)}}%</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                     </div>
               </div>

               <div class="tab-pane fade" id="investmentdetail" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                    <div class="card-header bg-gradient-info">
                        <b>Investment Detail</b>
                    </div>

                    <div class="card border-primary">
                        <div class="card-body">
                        <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center" >Cumulative Committed Investment up to claim Period F.Y(₹)</th>
                                        <th class="text-center" >Investment as per QRR(₹ in crore)</th>
                                        <th class="text-center" >Actual Investment up to Claim Period (₹ in crore)</th>
                                        <th class="text-center" >Difference (₹ in crore)</th>
                                        <th class="text-center" >Reason(Note:If difference is zero then fill NA.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claim_period as $key=>$period)
                                    <tr>

                                        <td class="claim-text">{{$period['claim_period']}}</td>
                                        <td class="claim-text">{{$period['inv_as_qrr']}}</td>
                                        <td class="claim-text">{{$period['actual_inv']}}</td>
                                        <td class="claim-text">{{$period['diff']}}</td>
                                        <td class="text-center">{{$period['reason_change']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card border-primary mt-4">
                        <div class="card-header bg-gradient-info">
                            <b>4.1 Minimum Annual Production Capacity	</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.N</th>
                                        <th class="text-center" >Name Of Product</th>
                                        <th class="text-center" >Minimum Annual Production Capacity proposed (MT)
                                        </th>
                                        <th class="text-center" >Minimum Annual Production Capacity Achieved (MT)
                                        </th>
                                        <th class="text-center" >Date of commissioning(Clause 2.8 of Scheme Guidelines)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($capacity as $key => $product)
                                    <tr>
                                       <td>{{$key+1}}</td>
                                       <td>{{$product->product_name}}</td>
                                       <td class="claim-text">{{$product->capacity_proposed}}</td>
                                       <td class="claim-text">{{$product->capacity_achieved}}</td>
                                       <td>{{$product->date_of_commission}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.2 Break-up of Investment</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" style="width: 100%" id="dynamic_field13">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center" rowspan="2">S.No.</th>
                                        <th class="text-center" rowspan="2">Assets Type</th>
                                        <th class="text-center" colspan="2">Imported </th>
                                        <th class="text-center" colspan="2">Indigenous</th>
                                        <th class="text-center" colspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>
                                        <th class="text-center">Related Party</th>
                                        <th class="text-center">Not-Related Party</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($claim_brkp_inv as $key=>$breakup_inv)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>

                                        <th class="text-center">{{$breakup_inv->asset_type}}</th>
                                        <td class="claim-text">{{$breakup_inv->imp_party}}</td>
                                        <td class="claim-text">{{$breakup_inv->imp_not_party}}</td>
                                        <td class="claim-text">{{$breakup_inv->ind_party}}</td>
                                        <td class="claim-text">{{$breakup_inv->ind_not_party}}</td>
                                        <td class="claim-text">{{$breakup_inv->tot_party}}</td>
                                        <td class="claim-text">{{$breakup_inv->tot_not_party}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.3 Break up of Investment as per Balance Sheet</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Opening balance (₹ in Crore)</th>
                                        <th class="text-center">Additions (₹ in Crore)</th>
                                        <th class="text-center">Deletions (₹ in Crore)</th>
                                        <th class="text-center">Closing balance (₹ in Crore)</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp

                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $key1 => $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_balsheet as $key => $balancesheet)
                                                    @if ($inv->id == $balancesheet['inv_prt_id'])
                                        <tr>
                                            <td class="text-center">{{ $sno++ }}</td>
                                            <th>{{ $inv->particular }}
                                                @if ($inv->particular=='Others (Specify nature)')
                                               {{$balancesheet['other_part']}}
                                                @endif
                                            </th>
                                            <td class="claim-text">{{ $balancesheet['opening_bal'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['additions'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['deletions'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['closing_bal'] }}</td>
                                            </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach

                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_balsheet as $key => $balancesheet)
                                                    @if ($inv->id == $balancesheet['inv_prt_id'])
                                        <tr>

                                            <td class="text-center">{{ $sno++ }}</td>
                                            <th>{{ $inv->particular }}
                                                @if ($inv->particular=='Others (Specify nature)')
                                                {{$balancesheet['other_part']}}
                                                @endif
                                            </th>
                                            <td class="claim-text">{{ $balancesheet['opening_bal'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['additions'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['deletions'] }}</td>
                                            <td class="claim-text">{{ $balancesheet['closing_bal'] }}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_balsheet,'opening_bal'))}}</td>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_balsheet,'additions'))}}</td>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_balsheet,'deletions'))}}</td>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_balsheet,'closing_bal'))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.4 Break up of total additions into eligible and non-eleigible investment</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Total addition as per Balance Sheet (₹ in crore)</th>
                                        <th class="text-center">Considered for PLI Scheme (₹ in crore)</th>
                                        <th class="text-center">Not considered for PLI Scheme (₹ in crore)</th>
                                        <th class="text-center">Reason for not considering(Note:If difference is zero then fill NA.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_totAdd as $key => $brkptot)
                                                    @if ($inv->id == $brkptot['inv_prt_id'])
                                    <tr>

                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular=='Others (Specify nature)')
                                            {{$brkptot['other_part']}}
                                            @endif
                                        </th>
                                        <td class="claim-text">{{ $brkptot['total_add_bal'] }}</td>
                                        <td class="claim-text">{{ $brkptot['consi_for_pli'] }}
                                        </td>
                                        <td class="claim-text">{{ $brkptot['not_consi_for_pli'] }}</td>
                                        <td class="text-center">{{ $brkptot['reason'] }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_totAdd as $key => $brkptot)
                                                    @if ($inv->id == $brkptot['inv_prt_id'])
                                    <tr>

                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular=='Others (Specify nature)')
                                            {{$brkptot['other_part']}}
                                            @endif
                                        </th>
                                        <td class="claim-text">{{ $brkptot['total_add_bal'] }}</td>
                                        <td class="claim-text">{{ $brkptot['consi_for_pli'] }}
                                        </td>
                                        <td class="claim-text">{{ $brkptot['not_consi_for_pli'] }}</td>
                                        <td class="text-center">{{ $brkptot['reason'] }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_totAdd,'total_add_bal'))}}</td>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_totAdd,'consi_for_pli'))}}</td>
                                        <td class="claim-text">{{array_sum(array_column($claim_brkp_totAdd,'not_consi_for_pli'))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.5 Break up of assets discarded during the year</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th class="text-center">Heads of Investment</th>
                                        <th class="text-center">Total deletion/ discarded/ sold (₹ in crore)	</th>
                                        <th class="text-center">Considered for PLI Scheme in current year or previous year (₹ in crore)</th>
                                        <th class="text-center">Not considered (₹ in crore)</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    <tr>
                                        <th colspan="6">(A) Property, Plant and Equipment</th>
                                        @foreach ($inv_part as $key1 => $inv)
                                            @if ($inv->realated_to_part_name_id == 1)
                                                @foreach ($claim_brkp_assest as $key => $brkpasset)
                                                    @if ($inv->id == $brkpasset['inv_prt_id'])
                                    <tr>
                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular=='Others (Specify nature)')
                                            {{$brkpasset['other_part']}}

                                            @endif
                                        </th>
                                        <td class="claim-text">{{ $brkpasset['total_del_dis_sol'] }}</td>
                                        <td class="claim-text">{{ $brkpasset['consi_for_pli'] }}</td>
                                        <td class="claim-text">{{ $brkpasset['not_consi_for_pli'] }}</td>

                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="6">(B) Intangible Assets</th>
                                        @foreach ($inv_part as $inv)
                                            @if ($inv->realated_to_part_name_id == 2)
                                                @foreach ($claim_brkp_assest as $key => $brkpasset)
                                                    @if ($inv->id == $brkpasset['inv_prt_id'])
                                    <tr>

                                        <td class="text-center">{{ $sno++ }}</td>
                                        <th>{{ $inv->particular }}
                                            @if ($inv->particular=='Others (Specify nature)')
                                           {{$brkpasset['other_part']}}

                                            @endif
                                        </th>
                                        <td class="claim-text">{{ $brkpasset['total_del_dis_sol'] }}</td>
                                        <td class="claim-text">{{ $brkpasset['consi_for_pli'] }}</td>
                                        <td class="claim-text">{{ $brkpasset['not_consi_for_pli'] }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="claim-text">{{$claim_brkp_assest[0]['dd_sold_total']}}</td>
                                        <td class="claim-text">{{$claim_brkp_assest[0]['pli_curr_tot']}}</td>
                                        <td class="claim-text">{{$claim_brkp_assest[0]['pli_not_curr_tot']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>4.6 Employment as on date for Greenfield Project (in absolute numbers)</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th colspan="">Heads of Investment</th>
                                        <th>Nos. as per QRR</th>
                                        <th colspan="">Actual Nos</th>
                                        <th colspan="">Difference</th>
                                        <th colspan="">Reason If any(If difference is zero then fill NA.)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>

                                        <td colspan="">On-roll labor</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->qrr_labor}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->on_roll_labor}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->diff_labor}}</td>
                                        <td colspan="" class="text-center">{{$claim_emp->difference_labor}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="">On-roll employees</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->qrr_emp}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->no_of_emp}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->diff_emp}}</td>
                                        <td colspan="" class="text-center">{{$claim_emp->difference_emp}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Contrctual</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->qrr_contr}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->on_roll_contr}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->diff_cont}}</td>
                                        <td colspan="" class="text-center">{{$claim_emp->difference_con}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Apprentice</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->qrr_apprentice}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->apprentice}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->diff_app}}</td>
                                        <td colspan="" class="text-center">{{$claim_emp->difference_app}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Total</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->qrr_total_emp}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->total_emp}}</td>
                                        <td colspan="" class="claim-text">{{$claim_emp->diff_total_emp}}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="projectdetail" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Project Details</b>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="4" >5.1 Whether Investment claimed as eligible under PLI Scheme includes any asset taken on lease.</th>
                                        <td class="text-center">
                                        @if(isset($response_question->where('ques_id',9)->first()->response)) @if($response_question->where('ques_id',9)->first()->response=='Y') Yes @endif @endif
                                        @if(isset($response_question->where('ques_id',9)->first()->response)) @if($response_question->where('ques_id',9)->first()->response=='N') NO @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display m-2 py-10" @if(isset($response_question->where('ques_id',9)->first()->response)) @if($response_question->where('ques_id',9)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name of lease</th>
                                            <th class="text-center">Asset Description</th>
                                            <th class="text-center">Amount(₹)</th>
                                            <th>@if(in_array('1033', $docids))
                                                <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1033)->first()->upload_id)) }}"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sn = 1;
                                        @endphp
                                        @if(count($projectDetRes1)>0)
                                            @foreach($projectDetRes1 as $key=>$res1)
                                                <tr>
                                                    <td class="">{{ $sn++ }}</td>
                                                    <td class="">{{$res1->name_of_lease}}</td>
                                                    <td class="">{{$res1->asset_description}}</td>
                                                    <td class="claim-text">{{$res1->amnout}}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.2 Whether Investment claimed as eligible under PLI Scheme includes any expenses on R&D and technical know how.</th>
                                        <td class="text-center">
                                           @if(isset($response_question->where('ques_id',10)->first()->response)) @if($response_question->where('ques_id',10)->first()->response=='Y') Yes @endif @endif
                                           @if(isset($response_question->where('ques_id',10)->first()->response)) @if($response_question->where('ques_id',10)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display2 m-2 py-10" @if(isset($response_question->where('ques_id',10)->first()->response)) @if($response_question->where('ques_id',10)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related2">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Particular</th>
                                            <th class="text-center">Amount(₹)</th>
                                            <th class="text-center"> @if(in_array('1034', $docids))
                                                <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1034)->first()->upload_id)) }}"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>


                                            @endif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @php
                                            $sn = 1;
                                        @endphp

                                        @if(count($projectDetRes2)>0)
                                            @foreach($projectDetRes2 as $key=>$res2)
                                            <tr>
                                                <td class="">{{ $sn++ }}</td>
                                                <th>{{$res2['quest_particular']}}</th>
                                                <td class="claim-text">{{$res2['amnout']}}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <th colspan="2" class="">Total</th>
                                        @if(count($projectDetRes2)>0)
                                            <td class="claim-text">{{array_sum(array_column($projectDetRes2,'amnout'))}}</td>
                                        @endif
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.3 Whether P&M include any used or refurbished plant & machinery. </th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',12)->first()->response)) @if($response_question->where('ques_id',12)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',12)->first()->response)) @if($response_question->where('ques_id',12)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display4 m-2 py-10" @if(isset($response_question->where('ques_id',12)->first()->response)) @if($response_question->where('ques_id',12)->first()->response=='N') style="display:none;" @endif @endif>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related4">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Type of P & M</th>
                                            <th class="text-center">Imported/Demostic</th>
                                            <th class="text-center">Residual Life</th>
                                            <th class="text-center">Capitalized Value(₹)</th>
                                            <th class="text-center">Value by CE(₹)</th>
                                            <th class="text-center">Value as per custom rules(₹)</th>
                                            <th class="text-center">Considered in eligibility criteria(₹)</th>
                                            <th class="text-center">@if(in_array('1036', $docids))
                                                <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1036)->first()->upload_id)) }}"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>

                                            @endif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp

                                        @if(count($projectDetRes4)>0)
                                            @foreach($projectDetRes4 as $key=>$res4)

                                            <tr>
                                                <td class="">{{ $sn++ }}</td>
                                                <td class="">{{$res4->type_pm}}</td>
                                                <td class="">{{$res4->impot_dom}}</td>
                                                <td class="claim-text">{{$res4->residual_life}}</td>
                                                <td class="claim-text">{{$res4->capitalized_value}}</td>
                                                <td class="claim-text">{{$res4->value_by_ce}}</td>
                                                <td class="claim-text">{{$res4->value_custom_rule}}</td>
                                                <td class="claim-text">{{$res4->eligibilty_criteria}}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.4 Is there is any Associated Utility as defined under clause 2.21.1 of Scheme Guidelines. </th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',13)->first()->response)) @if($response_question->where('ques_id',13)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',13)->first()->response)) @if($response_question->where('ques_id',13)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display5 m-2 py-10" @if(isset($response_question->where('ques_id',13)->first()->response)) @if($response_question->where('ques_id',13)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related5">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Utility</th>
                                            <th class="text-center">Intended Use</th>
                                            <th class="text-center">Amount Considered for Scheme(₹)</th>
                                            <th class="text-center"> @if(in_array('1037', $docids))
                                                <a href="{{ route('doc.download',encrypt($contents->where('doc_id',1037)->first()->upload_id)) }}"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>

                                            @endif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp

                                        @if(count($projectDetRes5)>0)
                                            @foreach($projectDetRes5 as $key=>$res5)
                                            <tr>
                                                <td class="">{{ $sn++ }}</td>
                                                <td class="">{{$res5->nature_of_utility}}</td>
                                                <td class="claim-text">{{$res5->intended_use}}</td>
                                                <td class="claim-text">{{$res5->amt}}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.5 Whether investment considered under this PLI scheme has been considered for eligibility under any other PLI Scheme.</th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',14)->first()->response)) @if($response_question->where('ques_id',14)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',14)->first()->response)) @if($response_question->where('ques_id',14)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display6 m-2 py-10" @if(isset($response_question->where('ques_id',14)->first()->response)) @if($response_question->where('ques_id',14)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related6">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name of PLI Scheme</th>
                                            <th class="text-center">Amount Considered(₹)</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($projectDetRes6)>0)
                                            <tr>

                                                <td class="">1.</td>
                                                <td class="">{{$projectDetRes6[0]->name_of_pli_scheme}}</td>
                                                <td class="claim-text">{{$projectDetRes6[0]->amt}}</td>
                                                <td> @if(in_array('1038', $docids))
                                                    <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1038)->first()->upload_id)) }}"
                                                        class="btn btn-success btn-sm float-centre">
                                                        View</a>
                                                @endif</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.6 Whether any Assets discarded during the year include any Assets considered for eligibility in current financial year or any previous year.</th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',15)->first()->response)) @if($response_question->where('ques_id',15)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',15)->first()->response)) @if($response_question->where('ques_id',15)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display7 m-2 py-10" @if(isset($response_question->where('ques_id',15)->first()->response)) @if($response_question->where('ques_id',15)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related7">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Assets</th>
                                            <th class="text-center">Amount Gross Value(₹)</th>
                                            <th class="text-center">Year When considered for eligibilty</th>
                                            <th class="text-center">Reason of discard</th>
                                            <th>File</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($projectDetRes7)>0)
                                            <tr>

                                                <td class="">1.</td>
                                                <td class="">{{$projectDetRes7[0]->nature_of_asset}}</td>
                                                <td class="">{{$projectDetRes7[0]->amt}}</td>
                                                <td class="">{{$projectDetRes7[0]->year_dt}}</td>
                                                <td class="">{{$projectDetRes7[0]->reason_of_discard}}</td>
                                                <td>@if(in_array('1039', $docids))
                                                    <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1039)->first()->upload_id)) }}"
                                                        class="btn btn-success btn-sm float-centre">
                                                        View</a>
                                                @endif</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.7 Please confirm that all Assets capitalized and claimed as eligible are being used/shall be used in the process of design, manufcaturing, <br>assembly, testing, packaging or processing of any of the eligible products covered under Target Segment.</th>
                                        <td class="text-center">
                                           @if(isset($response_question->where('ques_id',16)->first()->response)) @if($response_question->where('ques_id',16)->first()->response=='Y') Yes @endif @endif
                                           @if(isset($response_question->where('ques_id',16)->first()->response)) @if($response_question->where('ques_id',16)->first()->response=='N') No @endif @endif
                                        </td>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display8 m-2 py-10" @if(isset($response_question->where('ques_id',16)->first()->response)) @if($response_question->where('ques_id',16)->first()->response=='Y') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related8">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Assets</th>
                                            <th class="text-center">Amount Gross Value(₹)</th>
                                            <th class="text-center">Nature of Use</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($projectDetRes8)>0)
                                            <tr>
                                                <input type="hidden" name="pendingdispute_ques8[0][id]"  value="{{$projectDetRes8[0]->id}}">
                                                <td class="">1.</td>
                                                <td class="">{{ $projectDetRes8[0]->nature_of_asset }}</td>
                                                <td class="claim-text">{{ $projectDetRes8[0]->amt }}</td>
                                                <td class="claim-text">{{ $projectDetRes8[0]->nature_of_use }}</td>
                                                <td>@if(in_array('1040', $docids))
                                                    <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1040)->first()->upload_id)) }}"
                                                        class="btn btn-success btn-sm float-centre">
                                                        View</a>

                                                @endif</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.8 Please confirm whether assets capitalized and claimed during the year include any amount for which invoice date is prior to <br> 01/04/2020. If yes, provide details.</th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',17)->first()->response)) @if($response_question->where('ques_id',17)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',17)->first()->response)) @if($response_question->where('ques_id',17)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display9 m-2 py-10" @if(isset($response_question->where('ques_id',17)->first()->response)) @if($response_question->where('ques_id',17)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related9">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>File</th>
                                        <th>@if(in_array('1041', $docids))
                                            <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1041)->first()->upload_id)) }}"
                                                class="btn btn-success btn-sm float-centre">
                                                View</a>

                                        @endif</th>

                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.9 Whether amount capitalized and claimed eligible under PLI Scheme include expenses other than purchase price, non-creditable <br>duties & taxes, expense on freight/transport, packaging, insurance and expenditure on erection and commissioning of plant, machinery.</th>
                                        <td class="text-center">
                                           @if(isset($response_question->where('ques_id',18)->first()->response)) @if($response_question->where('ques_id',18)->first()->response=='Y') Yes @endif @endif
                                           @if(isset($response_question->where('ques_id',18)->first()->response)) @if($response_question->where('ques_id',18)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display10 m-2 py-10" @if(isset($response_question->where('ques_id',18)->first()->response)) @if($response_question->where('ques_id',18)->first()->response=='N') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related10">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>File</th>
                                        <th> @if(in_array('1042', $docids))
                                            <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1042)->first()->upload_id)) }}"
                                                class="btn btn-success btn-sm float-centre">
                                                View</a>

                                        @endif</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" >5.10 Whether all approvals required to set-up Greenfield Project for manufacutring of eligible products has been received.<br>If no please provide details</th>
                                        <td class="text-center">
                                            @if(isset($response_question->where('ques_id',19)->first()->response)) @if($response_question->where('ques_id',19)->first()->response=='Y') Yes @endif @endif
                                            @if(isset($response_question->where('ques_id',19)->first()->response)) @if($response_question->where('ques_id',19)->first()->response=='N') No @endif @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display11 m-2 py-10" @if(isset($response_question->where('ques_id',19)->first()->response)) @if($response_question->where('ques_id',19)->first()->response=='Y') style="display:none;" @endif @endif>

                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related11">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>File</th>
                                        <th> @if(in_array('1043', $docids))
                                            <a href="{{ route('doc.download', encrypt($contents->where('doc_id',1043)->first()->upload_id)) }}"
                                                class="btn btn-success btn-sm float-centre">
                                                View</a>

                                        @endif</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="rptdetails" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                     <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Related Party Transactions</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" id="related3">
                                <thead class="table-primary">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Nature of Transaction</th>
                                        <th>Disclosed in Financial Statement</th>
                                        <th colspan="2">Reported in Form 3CEB(Transfer Pricing)</th>
                                        <th colspan="2">Reported in Form 3CD</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sn=1;
                                    @endphp
                                    @foreach ($related_party as $key=>$prt )
                                        <tr>
                                        <th class="text-center">{{$sn++}}</th>
                                        <th>
                                            @if($prt['related_prt_id'] == 8)
                                             {{$prt['nature_name']}}
                                            @else
                                            {{$prt['nature_name']}}
                                            @endif
                                        </th>
                                        <td class="claim-text">{{$prt['fy_statement']}}</td>

                                        <td colspan="1">
                                            @if($prt['3CEB'] == 'NA') Not Applicable @endif
                                            @if($prt['3CEB'] == '0') Not Yet Filed @endif
                                            @if($prt['3CEB'] == 'Y')Applicable @endif
                                        </td>
                                        <td colspan="1"  class="claim-text">@if($prt['3CEB'] == 'Y' && $prt['ceb_amount'])
                                             {{$prt['ceb_amount']}}
                                            @endif</td>
                                        <td class="claim-text" colspan="1">
                                            @if($prt['cd_type'] == 'NA') Not Applicable @endif
                                            @if($prt['cd_type'] == '0') Not Yet Filed @endif
                                            @if($prt['cd_type'] == 'Y')Applicable @endif</td>
                                        <td class="claim-text" colspan="1">@if($prt['cd_type'] == 'Y' && $prt['3CD']){{$prt['3CD']}}@endif</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="width: 434px" class="text-center">Grand Total</th>
                                        <td class="claim-text">{{array_sum(array_column($related_party,'fy_statement'))}}</td>
                                        <td class="claim-text" colspan="2">{{array_sum(array_column($related_party,'ceb_amount'))}}</td>
                                        <td class="claim-text" colspan="2">{{array_sum(array_column($related_party,'3CD'))}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        @foreach($user_response as $key=>$response)
                                            @if($response['ques_id'] == 20)
                                            <th colspan="3" class="text-left table-primary">6.2 Whether there is any pending dispute in connection with related party transactions of current year or any previous year at any forum.?</th>
                                            <input type="hidden" name="ques[20]" value="{{$response['ques_id']}}">
                                            <td class="text-center" style="width: 10%">
                                                @if ($response['response'] == 'Y') Yes  @endif
                                                @if ($response['response'] == 'N') No  @endif
                                            </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @foreach($user_response as $key=>$response)
                        @if($response['ques_id'] == 20)
                        <div class="card border-primary display m-2 py-10" style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Year</th>
                                            <th class="text-center">Name of Forum</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Nature of dispute</th>
                                            <th class="text-center">Upload a brief</th>
                                            <th class="text-center">View File</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        @foreach ($pending as $key=>$pen )
                                        <tr>
                                            <td class="text-center">{{ $sn++ }}</td>
                                            <td class="text-center">{{$pen->year}}</td>
                                            <td class="text-center">{{$pen->forum_name}}</td>
                                            <td class="claim-text">{{$pen->amt}}</td>
                                            <td class="text-center">{{$pen->dispute}}</td>
                                            <td class="text-center">{{$pen->que_id}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($pen->upload_id)) }}">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left table-primary">6.3 Whether transactions with related party are required to be approved by Board/Audit Committee/Shareholders under Companies Act.</th>
                                        @foreach($user_response as $key=>$response)
                                        @if($response['ques_id'] == 21)
                                        <input type="hidden" name="ques[21]" value="{{$response['ques_id']}}">
                                        <td class="text-center" style="width: 10%">
                                          @if ($response['response'] == 'Y') Yes  @endif
                                          @if ($response['response'] == 'N') No  @endif
                                        </td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @foreach($user_response as $key=>$response)
                        @if($response['ques_id'] == 21)
                        <div class="card border-primary display1 m-2 py-10" style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related1">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Approving Authority</th>
                                            <th class="text-center">Date of approval</th>
                                            <th class="text-center">Pricing mechanism</th>
                                            <th class="text-center">Nature of transaction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        @foreach ($com_act as $key=>$act )

                                        <tr>
                                            <td class="text-center">{{ $sn++ }}</td>
                                            <td class="text-center">{{$act->authority}}</td>
                                            <td class="text-center">{{$act->approval_dt}}</td>
                                            <td class="text-center">{{$act->pricing}}</td>
                                            <td class="text-center">{{$act->tran_nature}}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left table-primary">6.4 Whether applicant is required to file form 3CEB for the year under consideration.</th>
                                        @foreach($user_response as $key=>$response)
                                        @if($response['ques_id'] == 22)

                                        <td class="text-center" style="width: 10%">
                                            @if ($response['response'] == 'Y') Yes  @endif
                                            @if ($response['response'] == 'N') NO  @endif
                                        </td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @foreach($user_response as $key=>$response)
                        @if($response['ques_id'] == 22)
                        <div class="card border-primary display2 m-2 py-10" style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related2">

                                    <tbody>

                                        @if($consi != null)

                                        <tr>
                                            <th class="">Upload a copy of Form 3CEB</th>
                                            <td class="">
                                                @if($consi['cd_upload_id']!=null)
                                                    <a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($consi['cd_upload_id'])) }}">View</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="">Transfer pricing study as per Income Tax Act.</th>
                                            <td class="">
                                            @if($consi['ceb_upload_id']!=null)
                                                <a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($consi['ceb_upload_id'])) }}">View</a>
                                            @endif
                                        </td>
                                        </tr>
                                        <tr>
                                            <th>Whether Pricing mechanismis same as applied under form 3CEB.</th>
                                            <td class="" >
                                               @if($consi['sub_response'] == 'Y')Yes @endif
                                               @if($consi['sub_response'] == 'N')No @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="">Transfer pricing study as per Income Tax Act.</th>
                                            <td class="">
                                                @if($consi['tax_upload_id']!=null)
                                                    <a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($consi['tax_upload_id'])) }}">View</a>
                                                @endif
                                            </td>
                                        </tr>

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="uploadA" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                     <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>General</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">S.No.</th>
                                                        <th class="text-center">Document/ Certificate to be Uploaded</th>
                                                        <th class="text-center" colspan="2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>@foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1001)
                                                        <td>1</td>
                                                        <td>List of manufacturing locations with details of products manufactured at each facility.</td>
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @if($doc->doc_id == 1056)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr> @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1002)
                                                        <td>2</td>
                                                        <td>Financial Statements and ledger grouping of Financial Staement (in excel format).</td>
                                                        @endif
                                                        @if($doc->doc_id == 1000)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @if($doc->doc_id == 1002)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Whether applicant is required to have an internal audit system u/s 138 of Companies Act. If yes, then upload Audit Report for claim period on sales and fixed assets function.</td>
                                                        <td colspan="2" style="width: 10%">
                                                        @if (count($genral_doc)>0 ) Yes @else
                                                        No @endif</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if(count($genral_doc)>0)
                                            <div class="card border-primary display m-2 py-10" style="@if ($response == 'N') display:none;  @else  @endif">
                                            <div class="card-body">

                                                <table class="table table-sm table-bordered table-hover" id="related">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th class="text-center"></th>
                                                            <th class="text-center">Period</th>
                                                            <th class="text-center">From Date</th>
                                                            <th class="text-center">To Date</th>
                                                            <th class="text-center" colspan=""> File</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($genral_doc as $key=>$data)
                                                            <tr>
                                                            @php
                                                                $sn = 1;
                                                            @endphp

                                                            <td class="text-center">{{$key+1}}</td>

                                                            <td class="text-center">{{$data->period}}"</td>
                                                            <td class="text-center">{{$data->from_dt}}</td>
                                                            <td class="text-center">{{$data->to_dt}}</td>

                                                            <td class="text-center"><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                            </div>
                                            @endif
                                            <table class="table table-sm table-bordered table-hover" style=>
                                                <thead>
                                                    <tr>
                                                        <td>4</td>
                                                        <td colspan="8">Bank details for remmittance of Incentive </td>
                                                    </tr>
                                                    <tr>

                                                        <th>Bank Name</th>
                                                        <th>Account Name</th>
                                                        <th>Account Type</th>
                                                        <th>Account Number</th>
                                                        <th>Branch Name</th>
                                                        <th>IFSC Code</th>
                                                        <th colspan="2">File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td>{{$bank_info->bank_name}}</td>
                                                    <td>{{$bank_info->account_holder_name}}</td>
                                                    <td>{{$bank_info->acc_type}}</td>
                                                    <td>{{$bank_info->acc_no}}</td>
                                                    <td>{{$bank_info->bank_name}}</td>
                                                    <td>{{$bank_info->ifsc_code}}</td>
                                                    @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1004)
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Sales</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <tbody>
                                                    <tr>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1005)
                                                        <td>1</td>
                                                        <td>Policy on sale recognition and discount & rebates given post sales of article.</td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>@foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1006)
                                                        <td>2</td>
                                                        <input type="hidden" name="upload_doc[{{$key}}][id]" id="greenfield" value="{{$doc->upload_id}}">
                                                        <td>Reconciliation of sales from Greenfield Project on which incentive is claimed with ledger codes/Financial Statement	</td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @if($doc->doc_id == 1057)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>@foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1007)
                                                        <td>3</td>
                                                        <input type="hidden" name="upload_doc[{{$key}}][id]" id="purchase" value="{{$doc->upload_id}}">
                                                        <td>Purchase agreements in respect of the cost of technology, Intellectual Property Rights (IPRs), patents and copyrights.</td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Regulatory Fillings</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <tbody>
                                                    <tr>@foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1008)
                                                        <td>1</td>
                                                        <td>Income Tax Return</td>

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>

                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr> @foreach($doc_data as $key=>$doc)
                                                            @if($doc->doc_id == 1009)
                                                        <td>2</td>
                                                        <td>Annual return filed under Companies Act</td>

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>

                                                            @endif
                                                            @if($doc->doc_id == 1058)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr> @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1010)

                                                        <td>3</td>
                                                        <td>GST Return</td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @if($doc->doc_id == 1059)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr> @foreach($doc_data as $key=>$doc)
                                                            @if($doc->doc_id == 1011)

                                                        <td>4</td>
                                                        <td>Working of GST reconciliation given in  Statutory Auditor's Certificate	</td>

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                            @endif
                                                            @if($doc->doc_id == 1060)
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="uploaddetails" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                     <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Certificates</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <thead>
                                                    <th>S.No</th>
                                                    <th>Certificates</th>
                                                    <th colspan="">PDF File</th>
                                                    <th colspan="">Excel File</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Statutory Auditor's Certificate (with Annexure 1 to 4)</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1012)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1017)

                                                          <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Annexure 5 of Statutory Auditor's Certificate (Sales Register)</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1013)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach

                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1018)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Annexure 6 of SA certifcate (Capex Register)</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1014)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1019)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>CE Certificate</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1015)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1020)


                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Certificate from Statutory Auditor for Intellectual Property Rights (IPRs), patents and copyrights.</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1016)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1021)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Certificate from Statutory Auditor or Independent Chartered Accountant for Intellectual Property Rights (IPRs), patents and copyrights.</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1028)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1029)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Certificate from Cost Accountant.</td>
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1030)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1031)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Undertakings / Declarations from applicant</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Declaration for usage of machinery as per Clause 6.2.3 of the Scheme Guidelines	</td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1022)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>No Deviation in Eligible Product(s) as per Point 9 (Annexure 4) of the Scheme Guidelines</td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1023)


                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Integrity compliance as per Annexure 11 Part A & Part B refer Point 13.1 (Annexure 4A) of the Scheme Guidelines</td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1024)


                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Certificate from Company Secretary of the company refer Point 10 (Annexure 4) of the Scheme Guidelines </td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1025)


                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Undertaking from the applicant for refund of incentive as per format given in Appendix 4A of the Scheme Guidelines refer Point 13.2 (Annexure 4) of the Scheme Guidelines	 </td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}
                                                        @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1026)

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                      @foreach($doc_data as $key=>$doc)
                                                        @if($doc->doc_id == 1021)
                                                        <td>6</td>

                                                        <td>Board Resolution to effect that applicant agrees by the applicant agrees by the terms and condition as laid download in PLI Scheme refer point 13.3 (Annexure 4) of the Scheme Guidelines	                                                    </td>
                                                        {{-- <td><a href="#">Format downloadload</a></td> --}}

                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.download',encrypt($doc->upload_id)) }}">View</a></td>
                                                        @endif
                                                      @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div>Note: One Management Representation Letter shall be taken post verification of claim but before submission of report to DoP.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
               </div>

               <!-- <div class="tab-pane fade active show" id="optionSectionDoc" role="tabpanel"
                  aria-labelledby="appTabContent-tab">
                     <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Miscellaneous(Optional)</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card border-primary p-0 m-10">
                                    <div class="card-header bg-gradient-info">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover"
                                                id="appExist">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">S.N</th>
                                                        <th class="text-center">Miscellaneous Certificates Name</th>
                                                        <th class="text-center">View Pdf</th>
                                                        <th class="text-center">View Excel</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($doc_data1)>0)
                                                    @foreach($doc_data1 as $k => $data)
                                                        <tr>
                                                            <td class="text-center">{{$k+1}}</td>
                                                            <td>{{$data->file_name}}</td>
                                                            <td class="text-center p-2 ">
                                                                @if($data->upload_id)
                                                                <a class=" mt-2 btn-sm btn-success"
                                                                href="{{ route('doc.down',encrypt($data->upload_id)) }}">
                                                                View</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center p-2 ">
                                                                @if($data->upload_id_excel)
                                                                <a class=" mt-2 btn-sm btn-success"
                                                                href="{{ route('doc.down',encrypt($data->upload_id_excel)) }}">
                                                                View</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>Not Data Found</tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div> -->

               <div class="tab-pane fade" id="optionSectionDoc" role="tabpanel" aria-labelledby="docTabContent-tab">
                  <div class="card border-primary mt-2" id="comp">
                     <div class="card border-primary p-0 m-10">
                        <div class="card-header bg-gradient-info">
                            <strong>Miscellaneous Documents</strong>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover"
                                        id="appExist">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">S.N</th>
                                                <th class="text-center">Miscellaneous Certificates Name</th>
                                                <th class="text-center">View Pdf</th>
                                                <th class="text-center">View Excel</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($doc_data1)>0)
                                            @foreach($doc_data1 as $k => $data)
                                                <tr>
                                                    <td class="text-center">{{$k+1}}</td>
                                                    <td>{{$data->file_name}}</td>
                                                    <td class="text-center p-2 ">
                                                        @if($data->upload_id)
                                                        <a class=" mt-2 btn-sm btn-success"
                                                        href="{{ route('doc.download',encrypt($data->upload_id)) }}">
                                                        View</a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center p-2 ">
                                                        @if($data->upload_id_excel)
                                                        <a class=" mt-2 btn-sm btn-success"
                                                        href="{{ route('doc.download',encrypt($data->upload_id_excel)) }}">
                                                        View</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>Not Data Found</tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                  </div>
               </div>

               <div class="tab-pane fade" id="clause" role="tabpanel" aria-labelledby="docTabContent-tab">
                <div class="card border-primary mt-2" id="comp">
                   <div class="card border-primary p-0 m-10">
                      <div class="card-header bg-gradient-info">
                          <strong>Claim Form Clause 15.12</strong>
                      </div>
                          <div class="card-body">
                              <div class="table-responsive">
                              <table class="table table-sm table-bordered table-hover"
                                      id="appExist">
                                      <thead class="table-primary">
                                          <tr>
                                              <th class="text-center">S.N</th>
                                              <th class="text-center">Document as per</th>
                                              <th class="text-center">View Pdf</th>
                                              <th class="text-center">View Excel</th>

                                          </tr>
                                      </thead>
                                      <tbody>

                                          @if(count($incetive_doc_map)>0)
                                          @foreach($incetive_doc_map as $k => $data)
                                              <tr>
                                                  <td class="text-center">{{$k+1}}</td>
                                                  <td>{{$data->doc_name}}</td>
                                                  <td class="text-center p-2 ">
                                                      @if($data->pdf_upload_id)
                                                      <a class=" mt-2 btn-sm btn-success"
                                                      href="{{ route('doc.download',encrypt($data->pdf_upload_id)) }}">
                                                      View</a>
                                                      @endif
                                                  </td>
                                                  <td class="text-center p-2 ">
                                                      @if($data->excel_upload_id)
                                                      <a class=" mt-2 btn-sm btn-success"
                                                      href="{{ route('doc.download',encrypt($data->excel_upload_id)) }}">
                                                      View</a>
                                                      @endif
                                                  </td>
                                              </tr>
                                          @endforeach
                                          @else
                                          <tr>Not Data Found</tr>
                                          @endif
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                  </div>
                </div>
             </div>
            </div>
            {{-- <div id="">
                <span style="float: right;" id="tx">{{Carbon\Carbon::now()}} &nbsp;@if($claimMast->status == 'D') Draft @else Submitted @endif</span>
            </div> --}}
         </div>

        </div>
    </div>
</div>

<div class="row pb-2">

   <div class="col-md-2 offset-md-5">
       <div onclick="printPage();"
         class="btn btn-info text-white btn-sm form-control form-control-sm">
         Print <i class="fas fa-print"></i>
      </div>
   </div>
</div>
@endsection
@push('scripts')
@include('user.partials.js.claimPrint')
@endpush