@extends('layouts.user.dashboard-master')

@section('title')
    Claim : Applicant Details
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"]{
            padding:1px;
        }
    </style>
@endpush

@section('content')
    <div class="container  py-4 px-2 col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('claimsapplicantdetail.store') }}" id="application-create" role="form" method="post"
                    class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>A. Applicant's Details </b>
                        </div>
                        <div class="card-body">
                           <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
                           <input type="hidden" id="fy_id" name="fy_id" value="{{ $fyId }}">
                            {{--<input type="hidden" id="created_by" name="created_by" value="{{ $appMast->user_id}}">--}}
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <th>Name of Applicant:</th>
                                        <td colspan="2"><input type="text" name="app_name" id="app_name" value="{{$appMast->name}}"
                                                 class="form-control form-control-sm" style="font-size: 15px;"
                                                disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <th>Corporate Office Address</th>
                                        <td colspan="2"><input type="text" name="app_addr" id="app_addr"
                                                value="{{$users->off_add}}" class="form-control form-control-sm" style="font-size: 15px;"
                                                disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <th>Target Segment</th>
                                        <td colspan="2"><input type="text" name="tar_seg" id="tar_seg"
                                                value="{{$appMast->target_segment}}" class="form-control form-control-sm" style="font-size: 15px;"
                                                disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <th>Eligible Product on which incentive is being claimed:</th>
                                        <td colspan="2"><input type="text" name="tar_seg" id="tar_seg"
                                                value="{{$appMast->product}}" class="form-control form-control-sm" style="font-size: 15px;"
                                                disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <th>Application No.:</th>
                                        <td colspan="2"><input type="text" name="app_no" id="app_no"
                                                value="{{$appMast->app_no}}" class="form-control form-control-sm" style="font-size: 15px;"
                                                disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <th>HSN Code of above Eligible Product</th>
                                        <td colspan="2"><input type="text" name="applicant_data[1][hsn]" id="hsn"
                                           value="" class="form-control form-control-sm" style="font-size: 15px;"
                                           ></td>
                                     </tr>
                                     <tr>
                                        <td class="text-center">7</td>
                                        <th>Committed Capacity(MT)</th>
                                        <td colspan="2"><input type="number" name="applicant_data[1][committted_capacity]" id="committted_capacity"
                                           value="" class="form-control form-control-sm" style="font-size: 15px;" ></td>
                                     </tr>
                                     <tr>
                                        <td class="text-center">8</td>
                                        <th>Quoted Sales Price (Rs./Kg)</th>
                                        <td colspan="2"><input type="number" name="applicant_data[1][quoted_sales]" id="quoted_sales"
                                           value="" class="form-control form-control-sm" style="font-size: 15px;" ></td>
                                     </tr>
                                    <tr>
                                        <td class="text-center">9</td>
                                        <th>Approval Letter issued on (Date)</th>
                                        <td colspan="2"><input type="text" name="appr_issue_dt" id="appr_ltr_date"
                                                value="" class="form-control form-control-sm" style="font-size: 15px;"
                                                readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">10</td>
                                        <th>Approval Letter No.</th>
                                        <td colspan="2"><input type="text" name="appr_ltr_no" id="appr_ltr_no"
                                                value="" class="form-control form-control-sm" style="font-size: 15px;"
                                                readonly></td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="text-center">11</td>
                                        <th>Period for which Incentive is being claimed</th>
                                        <td colspan="2">
                                            <table class="sub-table text-center " style="width: 100%">
                                                <tr>
                                                    <th class="text-center ">From date</th>
                                                    <th class="text-center">To date</th>
                                                </tr>
                                              
                                                <tr>
                                                    <td>
                                                        <select name="applicant_data[1][inc_from_date]" id="inc_from_date" class="form-control form-control-sm">
                                                            
                                                            <option selected disabled>Choose QTR</option>
                                                            <option value="{{$fy->year.'01'}}">Apr - June</option>
                                                            <option value="{{$fy->year.'02'}}">July - Sep</option>
                                                            <option value="{{$fy->year.'03'}}">Oct - Dec</option>
                                                            <option value="{{$fy->year.'04'}}">Jan - Mar</option>
                                                    </td>
                                                   

                                                    <td>
                                                        <select  name="applicant_data[1][inc_to_date]" id="inc_to_date" class="form-control form-control-sm">
                                                            <option selected disabled>Choose QTR</option>
                                                            <option value="{{$fy->year.'01'}}">Apr - June</option>
                                                            <option value="{{$fy->year.'02'}}">July - Sep</option>
                                                            <option value="{{$fy->year.'03'}}">Oct - Dec</option>
                                                            <option value="{{$fy->year.'04'}}">Jan - Mar</option>
                                                    </td>
                                                    

                                                </tr>
                                            </table>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td class="text-center">11</td>
                                        <th>Period for which Incentive is being claimed</th>
                                        <td colspan="2">
                                            <table class="sub-table text-center " style="width: 100%">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center ">Claim Filling Period ({{$fy->year}})</th>
                                                        <th class="text-center">Quarter</th>
                                                    </tr>
                                                </thead>    
                                                <tr>
                                                    <td style="width: 50%">
                                                        <select name="claim_period" id="claim_period"
                                                            class="form-control form-control-sm" style="font-size: 15px;" onchange="show_claim_period(this.value)">
                                                            <option value="" disabled selected>Select</option>
                                                            <option value="1">Quarterly</option>
                                                            <option value="2">Half-Yearly</option>
                                                            <option value="3">Nine Months</option>
                                                            <option value="4">Annual</option>
                                                        </select>
                                                    </td>
                                                    {{-- {{dd($arr_qtr)}} --}}
                                                    <td>
                                                        <div id="quarterly_claim_empty" >
                                                            <select name="quarterly_claim_empty" class="form-control form-control-sm">
                                                                <option value=""  selected disabled>Select</option>   
                                                            </select>  
                                                        </div> 
                                                        
                                                        <div id="quarterly_claim" style="display:none">
                                                            <select name="quarterly_claim"class="form-control form-control-sm">
                                                                <option value="" disabled selected>Select</option>
                                                                @foreach($arr_qtr as $qtr_val)
                                                                    <option value="{{$qtr_val->qtr_id.'@_@'.$qtr_val->qtr_id}}">{{$qtr_val->start_month}} - {{$qtr_val->month}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>    

                                                        <div id="half_hearly_claim" style="display:none">
                                                            <select name="half_hearly_claim" class="form-control form-control-sm"  >
                                                                <option value="" disabled selected>Select</option>
                                                                @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr) &&  isset($arr_qtr->where('month','Sep')->first()->qtr))
                                                                    <option value="{{$arr_qtr->where('start_month','Apr')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Sep')->first()->qtr_id}}">April - September</option>
                                                                @endif

                                                                @if(isset($arr_qtr->where('start_month','Oct')->first()->qtr) &&  isset($arr_qtr->where('month','Mar')->first()->qtr))
                                                                    <option value="{{$arr_qtr->where('start_month','Oct')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Mar')->first()->qtr_id}}">October - March</option>
                                                                @endif
                                                            </select>
                                                        </div>    

                                                        <div id="nine_months_claim" style="display:none">
                                                            <select name="nine_months_claim" class="form-control form-control-sm">
                                                                <option value="" disabled selected>Select</option>
                                                                @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr) &&  isset($arr_qtr->where('month','Dec')->first()->qtr))
                                                                    <option value="{{$arr_qtr->where('start_month','Apr')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Dec')->first()->qtr_id}}">April - December</option>
                                                                @endif

                                                                @if(isset($arr_qtr->where('start_month','July')->first()->qtr) &&  isset($arr_qtr->where('month','Mar')->first()->qtr))
                                                                    <option value="{{$arr_qtr->where('start_month','July')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Mar')->first()->qtr_id}}">July - March</option>
                                                                @endif
                                                            </select>
                                                        </div>    

                                                        <div id="annual_claim" style="display:none">
                                                            <select name="annual_claim" class="form-control form-control-sm">
                                                                @if(isset($arr_qtr->where('start_month','Apr')->first()->qtr) &&  isset($arr_qtr->where('month','Mar')->first()->qtr))
                                                                    <option value="{{$arr_qtr->where('start_month','Apr')->first()->qtr_id.'@_@'.$arr_qtr->where('month','Mar')->first()->qtr_id}}">April - March</option>
                                                                @endif
                                                            </select> 
                                                        </div>    
                                                    </td> 
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">12</td>
                                        <th>Greenfield Manufacturing location/s where Eligible Product<br> on which incentive is being
                                            claimed.</th>
                                        <td>
                                            <table class="table table-bordered" id="dynamic_field">
                                              
                                                    <tr>
                                                        <th class="text-center" colspan="3">Address</th>
                                                    </tr>
                                                    <tr>
                                                    
                                                        <td style="" colspan="3">
                                                            <input type="text" name="loc[0][addr]" value="{{$manufac->address}}" class="form-control name_list"  readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">State</th>
                                                        <th class="text-center">City</th>
                                                        <th class="text-center">Pincode</th>
                                                        {{-- <th class="text-center"><button type="button" name="add" id="add"
                                                            class="btn btn-success">Add More</button></th> --}}
                                                    </tr>
                                                    <tr>                                                        <td style="width: 780px">
                                                            <select id="corpAddState_0" required name="loc[0][state]" required
                                                                class="form-control form-control-sm" onchange="GetCityByStateName(this.value)">
                                                                <option value="" selected="selected">Please select..
                                                                </option>
                                                                @foreach ($states as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('state')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                        <td style="width: 780px">
                                                            <select id="corpAddCity_0" name="loc[0][city]" class="form-control form-control-sm" required>
                                                            </select>
                                                            @error('city')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                        <td style="width: 780px">
                                                            <input type="number" name="loc[0][pincode]" id="corpAddPin_0" class="form-control name_list"  onkeyup="chekPinCode(this.value)"/>
                                                        </td>
                                                        
                                                    </tr>
                                            </table>
                                        </td>
                                    </tr>
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
                                @foreach($shareholder as $key=>$sholder)
                                <tbody>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center"><input type="text" name="sh_name" id="sh_name"
                                            value="{{$sholder->name}}" class="form-control form-control-sm"  disabled></td>
                                    <td class="text-center"><input type="text" name="sh_eq_share" id="sh_eq_share"
                                            value="{{$sholder->shares}}" class="form-control form-control-sm"  disabled></td>
                                    <td class="text-center"><input type="text" name="sh_per" id="sh_per"
                                            value="{{$sholder->per}}" class="form-control form-control-sm"  disabled></td>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left">Whether there is any change in shareholding pattern at the time of filing claim from application date?</th>
                                        <input type="hidden" name="ques[0]" value="1">
                                        <td class="text-center">
                                            <select id="problem" name="value[0]"
                                                class="form-control form-control-sm text-center">
                                                <option selected disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display m-2 py-10" style="display:none;">
                            <div class="card-header bg-gradient-info">
                                <b>New Shareholding</b>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Reason for change in shareholding pattern</th>
                                            <td><input type="text" name="reason_shareholding"   class="form-control form-control-sm name_list1"></td>
                                            <th>Date of change in Shareholding Pattern</th>
                                            <td><input type="date" name="reason_date"   class="form-control form-control-sm name_list1"></td>
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
                                            <th class="text-center"><button type="button" name="add1" id="add1"
                                                    class="btn btn-success">Add More</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        <td class="text-center">{{ $sn }}</td>
                                        <td class="text-center"><input type="text" name="shareholding[0][new_sh_name]" id="new_sh_name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="shareholding[0][new_sh_eq_share]" id="new_sh_eq_share_0"
                                                class="form-control form-control-sm name_list1 tot_share"></td>
                                        <td class="text-center"><input type="number" name="shareholding[0][new_sh_per]" id="new_sh_per0"
                                                class="form-control form-control-sm name_list1" readonly></td>
                                        @php
                                            $sn++;
                                        @endphp
                                        <td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="card-body mt-2">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left">Whether there is any 'successor in interest'
                                            as per clause 2.21 of the scheme guidelines due to change in shareholding
                                            pattern or any other reason.</th>
                                        <input type="hidden" name="ques[1]" value="2">
                                        <td class="text-center">
                                            <select id="problem12"  name="value[1]"
                                                class="form-control form-control-sm text-center">
                                                <option selected disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div> --}}
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left">Whether there is any 'successor in interest'
                                            as per clause 2.30 of the scheme guidelines due to change in shareholding
                                            pattern or any other reason.</th>
                                        <input type="hidden" name="ques[2]" value="2">
                                        <td class="text-center">
                                            <select id="problem1"  name="value[2]"
                                                class="form-control form-control-sm text-center">
                                                <option selected disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-body mt-2">
                            <table class="table table-sm display1 table-bordered table-hover" style="display:none">
                                <thead>
                                    <tr><th>Applicant needs to upload copies of all the relevant documents in respect of the transaction resulting in successor in interest alongwith request to get  approval from EC as per clause 17.2 of the scheme guidelines.</th>
                                        <td class="text-center">
                                            <input type="file" name="shareHoldingPattern[0][doc]" value="" id="">
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                                            <th class="text-center"colspan="2">Appointment valid up to</th>
                                       </tr>
                                       <tr>
                                            <td class="text-center" colspan="2"><input type="text" name="firm_name" id="firm_name" class="form-control form-control-sm name_list2"></td>
                                            <td class="text-center" colspan="2"><input type="date" name="appt_date" id="appt_date" class="form-control form-control-sm name_list2"></td>
                                            <td class="text-center" colspan="2"><input type="date" name="appt_valid" id="appt_valid" class="form-control form-control-sm name_list2"></td>
                                       </tr>
                                       <tr>
                                        <th colspan="6">Detail of Certificate</th>
                                       </tr>
                                       <tr>
                                        <th>Date</th>
                                        <th>UDIN</th>
                                        <th>Name of Partner</th>
                                        <th>Email</th>
                                        <th>Contact number of signing partner</th>
                                       </tr>
                                       <tr>
                                        <td><input type="date" name="sa_date" id="sa_date" class="form-control form-control-sm name_list2" placeholder="Detail of Certificate"></td>
                                        <td><input type="text" name="udin" id="udin" class="form-control form-control-sm name_list2" placeholder="UDIN"></td>
                                        <td><input type="text" name="partner_name" id="partner_name" class="form-control form-control-sm name_list2" placeholder="Name of Partner"></td>
                                        <td><input type="text" name="sa_email" id="sa_email" class="form-control form-control-sm name_list2" placeholder="Enter email"></td>
                                        <td><input type="number" name="partner_cont_no" id="partner_cont_no" class="form-control form-control-sm name_list2" placeholder="Contact number of signing partner"></td>
                                       </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="row py-2">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{ route('claims.index', 1) }}"
                                class="btn btn-success btn-sm form-control form-control-sm font-weight-bold"><i class="fa  fa-home"></i> Home</a>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" id="applicant_det"><i class="fas fa-save"></i> Save as Draft</button>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <a href=""
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold" style="pointer-events: none;"> Sales <i class="fa  fa-forward"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
       

        $(document).ready(function() {
            var i = 1;
            var j = 0;
            var sn = 2;
            $('#add1').click(function() {
                i++;
                j++;
                $('#dynamic_field1').append('<tr id="row' + i + '"><td class="text-center">' + sn +
                    '</td><td><input type="text" name="shareholding['+ j +'][new_sh_name]"  class="form-control name_list1" /></td><td><input type="number" name="shareholding['+ j +'][new_sh_eq_share]"  id="new_sh_eq_share_'+ j +'" class="form-control name_list1 tot_share" /></td><td><input type="text" name="shareholding['+ j +'][new_sh_per]" id="new_sh_per'+ j +'"  class="form-control name_list1" readonly/></td><td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove1">Remove</button></td></tr>');
                    sn++
            });
            $(document).on('click', '.btn_remove1', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        
        $(document).ready(function() {
            var i = 1;
            var j = 0;
            var sn = 2;
            $('#add2').click(function() {
                i++;
                j++;
                $('#dynamic_field2').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                    '</td><td><input type="text" name="shareholding['+ j +'][doc_name]"  class="form-control name_list2" /></td><td><input type="file" name="shareholding['+ j +'][doc_upload]"  class="form-control name_list2" /></td><td class="text-center"><button type="button" name="remove" id="' +
                        i + '" class="btn btn-danger btn_remove2">Remove</button></td></tr>');
                    });
                    $(document).on('click', '.btn_remove2', function() {
                        var button_id = $(this).attr("id");
                        $('#row' + button_id + '').remove();
                    });
                });
                
                $(document).ready(function() {
                    var i = 1;
                    var sn = 2;
                    var j=0;
                        $('#add3').click(function() {
                            i++;
                            j++;
                            $('#dynamic_field3').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                                '</td><td><input type="text" name="name3[]"  class="form-control name_list3" value="" disabled /></td><td><input type="text" name="incentive['+ i +']product_name"  class="form-control name_list3" /></td><td class="text-center"><button type="button" name="remove" id="' +
                                    i + '" class="btn btn-danger btn_remove2">Remove</button></td></tr>');
                        });
                        $(document).on('click', '.btn_remove2', function() {
                            var button_id = $(this).attr("id");
                            $('#row' + button_id + '').remove();
                        });
                });
              

        $(document).ready(function() {
            $('#problem').on('change', function() {
                $('.display').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem12').on('change', function() {
                $('.display12').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display12').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem1').on('change', function() {
                $('.display1').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display1').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });
        $(document).on("keyup", ".tot_share", function() {
            var sum = 0;
            $(".tot_share").each(function() {
                sum += +$(this).val();
            });
        
            for(i=0; i<50; i++){
               
                var dom_qnty = parseInt(document.getElementById('new_sh_eq_share_'+i).value);
                var tot_per = (dom_qnty/sum)* 100;
                // alert(tot_per.toFixed(2));
                $('#new_sh_per'+i).val(tot_per.toFixed(2));
            }
        });
        function GetCityByStateName(state_name)
        {
            jQuery.ajax({
                type: "GET",
                url: "/cities/"+state_name,
                dataType: "json",    
                success: function(data) {
                        jQuery('#corpAddCity_0').empty();
                        $('#corpAddCity_0').append('<option value="">Please Choose...</option>');
                        jQuery.each(data, function(key, value) {
                            $('#corpAddCity_0').append( '<option value="' +key+ '">' +value+ '</option>');
                        });
                    }
            });  
        }

        function chekPinCode(pincode)
        {
        
        if (pincode.length == 6 && $.isNumeric(pincode)) {
                var city = $('#corpAddCity_0').val();
                var req = '/pincodes/' + city;
                $.getJSON(req, null, function(data) {
                if (jQuery.inArray(pincode.toString(), data.map(String)) != -1) {
                    console.log(pincode);
                } else {
                    alert('Pincode Incorrect!');
                    $('#corpAddPin_0').val('');
                }
                });
        };
        }

        function show_claim_period(val)
        {
            //alert(val);
            if(val==1)
            {
                document.getElementById('quarterly_claim').style.display='';
                document.getElementById('half_hearly_claim').style.display='none';
                document.getElementById('quarterly_claim_empty').style.display='none';
                document.getElementById('nine_months_claim').style.display='none';
                document.getElementById('annual_claim').style.display='none';

                document.getElementById('half_hearly_claim').value='';
                document.getElementById('quarterly_claim_empty').value='';
                document.getElementById('nine_months_claim').value='';
                document.getElementById('annual_claim').value='';
            }

            if(val==2)
            {
                document.getElementById('half_hearly_claim').style.display='';
                document.getElementById('quarterly_claim').style.display='none';
                document.getElementById('quarterly_claim_empty').style.display='none';
                document.getElementById('nine_months_claim').style.display='none';
                document.getElementById('annual_claim').style.display='none';

                document.getElementById('quarterly_claim').value='';
                document.getElementById('quarterly_claim_empty').value='';
                document.getElementById('nine_months_claim').value='';
                document.getElementById('annual_claim').value='';
            }

            if(val==3)
            {
                document.getElementById('half_hearly_claim').style.display='none';
                document.getElementById('quarterly_claim').style.display='none';
                document.getElementById('quarterly_claim_empty').style.display='none';
                document.getElementById('nine_months_claim').style.display='';
                document.getElementById('annual_claim').style.display='none';

                document.getElementById('quarterly_claim').value='';
                document.getElementById('quarterly_claim_empty').value='';
                document.getElementById('half_hearly_claim').value='';
                document.getElementById('annual_claim').value='';
            }

            if(val==4)
            {
                document.getElementById('half_hearly_claim').style.display='none';
                document.getElementById('quarterly_claim').style.display='none';
                document.getElementById('quarterly_claim_empty').style.display='none';
                document.getElementById('nine_months_claim').style.display='none';
                document.getElementById('annual_claim').style.display='';

                document.getElementById('quarterly_claim').value='';
                document.getElementById('quarterly_claim_empty').value='';
                document.getElementById('half_hearly_claim').value='';
                document.getElementById('nine_months_claim').value='';
            }
        }  

        $(document).ready(function () {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("applicant_det");
                btn.disabled = true;
                setTimeout(function(){btn.disabled = false;}, (1000*20));
            });
        });
</script>
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimApplicationRequest', '#application-create') !!}
@endpush
@endpush
