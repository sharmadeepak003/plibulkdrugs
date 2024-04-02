@extends('layouts.user.dashboard-master')

@section('title')
Claim: Related Party Transaction
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
<style>
    input[type="file"] {
        padding: 1px;
    }
</style>
@endpush

@section('content')
<div class="container  py-4 px-2 col-lg-12">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('relatedpartytransaction.update',$apps->app_id) }}" id="relatedparty-create"
                role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                @csrf
                @method('PUT')

                <input type="hidden" name="app_id" value="{{$apps->app_id}}">
                <input type="hidden" name="claim_id" value="{{$apps->claim_id}}">
                <div class="card border-primary">
                    <div class="card-header bg-gradient-info">
                        <b>6.1 Related Party Transactions</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover" id="related3">
                            <thead class="table-primary">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Nature of Transaction</th>
                                    <th>Disclosed in Financial Statement</th>
                                    <th>Reported in Form 3CEB(Transfer Pricing)</th>
                                    <th>Reported in Form 3CD</th>
                                    <th><button type="button" name="add3" id="add3" class="btn btn-success">Add
                                            More</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sn=1;
                                @endphp
                                {{-- {{dd($related_party)}} --}}
                                @foreach ($related_party as $key=>$prt )

                                <tr>
                                    <input type="hidden" name="app_num[{{$key}}][id]" value="{{$prt['id']}}">
                                    <input type="hidden" name="app_num[{{$key}}][prt_id]"
                                        value="{{$prt['related_prt_id']}}">
                                    <th class="text-center">{{$sn++}}</th>
                                    <th>
                                        @if($prt['related_prt_id'] == 8)
                                        other
                                        <br><input type="text" class="form-control form-control-sm "
                                            name="app_num[{{$key}}][prt_name]" value="{{$prt['nature_name']}}">
                                        @else
                                        {{$prt['nature_name']}}
                                        <input type="hidden" name="app_num[{{$key}}][prt_name]"
                                            value="{{$prt['nature_name']}}">
                                        @endif
                                    </th>
                                    <td><input type="number" name="app_num[{{$key}}][fy_statement]" id="app_num22"
                                            class="form-control form-control-sm addition" style="font-size: 15px;"
                                            value="{{$prt['fy_statement']}}"></td>

                                    <td>
                                        <select id="problem3ceb{{$key}}" name="app_num[{{$key}}][3CEB]"
                                            class="form-control form-control-sm text-center 3ceb_select">
                                            <option value="NA" @if($prt['3CEB']=='NA' )selected @endif>Not Applicable
                                            </option>
                                            <option value="0" @if($prt['3CEB']=='0' )selected @endif>Not Yet Filed
                                            </option>
                                            <option value="Y" @if($prt['3CEB']=='Y' )selected @endif>Filed</option>
                                        </select>

                                        @if($prt['3CEB'] == 'Y' && $prt['ceb_amount'])
                                        <input type="number" name="app_num[{{$key}}][3CEB_A]" id="problem3ceb{{$key}}t"
                                            value="{{$prt['ceb_amount']}}"
                                            class="form-control form-control-sm addition1" style="">
                                        @else
                                        <input type="number" name="app_num[{{$key}}][3CEB_A]" id="problem3ceb{{$key}}t"
                                            value="{{$prt['ceb_amount']}}"
                                            class="form-control form-control-sm addition1"
                                            style="font-size: 15px;display: none">
                                        @endif
                                    </td>
                                    
                                    <td><select id="problem3cd{{$key}}" name="app_num[{{$key}}][cd_type]"
                                        class="form-control form-control-sm text-center 3cd_select">
                                        <option value="NA" @if($prt['cd_type']=='NA' )selected @endif>Not Applicable
                                        </option>
                                        <option value="0" @if($prt['cd_type']=='0' )selected @endif>Not Yet Filed
                                        </option>
                                        <option value="Y" @if($prt['cd_type']=='Y' )selected @endif>Filed</option>
                                    </select>
                                     @if($prt['cd_type'] == 'Y' && $prt['3CD'])
                                        <input type="number" name="app_num[{{$key}}][3CD]" id="problem3cd{{$key}}t"
                                            value="{{$prt['3CD']}}"
                                            class="form-control form-control-sm addition2" style="">
                                        @else
                                        <input type="number" name="app_num[{{$key}}][3CD]" id="problem3cd{{$key}}t"
                                            value="{{$prt['3CD']}}"
                                            class="form-control form-control-sm addition2"
                                            style="font-size: 15px;display: none">
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="width: 434px" class="text-center">Grand Total</th>
                                    <td><input type="number" name="app_num" id="app_num"
                                            value="{{array_sum(array_column($related_party,'fy_statement'))}}"
                                            class="form-control form-control-sm tot_addition" style="font-size: 15px;"
                                            disabled></td>
                                    <td><input type="number" name="app_num" id="app_num"
                                            value="{{array_sum(array_column($related_party,'ceb_amount'))}}"
                                            class="form-control form-control-sm tot_addition1" style="font-size: 15px;"
                                            disabled></td>
                                    <td><input type="number" name="app_num" id="app_num"
                                            value="{{array_sum(array_column($related_party,'3CD'))}}"
                                            class="form-control form-control-sm tot_addition2" style="font-size: 15px;"
                                            disabled></td>
                                    <td style="width: 90px;"></td>
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
                                    <th colspan="3" class="text-left">6.2 Whether there is any pending dispute in
                                        connection with related party transactions of current year or any previous year
                                        at any forum.?</th>
                                    <input type="hidden" name="ques[20]" value="{{$response['ques_id']}}">
                                    <input type="hidden" name="ans20" value="{{$response['response']}}">
                                    <td class="text-center" style="width: 10%">
                                        <select id="problem" name="problem[20]"
                                            class="form-control form-control-sm text-center">
                                            <option value="Y" @if ($response['response']=='Y' ) selected @else @endif>
                                                Yes</option>
                                            <option value="N" @if ($response['response']=='N' ) selected @else @endif>No
                                            </option>
                                        </select>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @foreach($user_response as $key=>$response)
                    @if($response['ques_id'] == 20)
                    <div class="card border-primary display m-2 py-10"
                        style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
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
                                        <th class="text-center"><button type="button" name="add" id="add"
                                                class="btn btn-success">Add More</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach ($pending as $key=>$pen )
                                    <input type="hidden" name="pendingdispute[{{$key}}][id]" value="{{$pen->id}}">
                                    <input type="hidden" name="pendingdispute[{{$key}}][upload_id]"
                                        value="{{$pen->upload_id}}">
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center"><input type="number"
                                                name="pendingdispute[{{$key}}][year]" id="name"
                                                class="form-control form-control-sm name_list1" value="{{$pen->year}}">
                                        </td>
                                        <td class="text-center"><input type="text"
                                                name="pendingdispute[{{$key}}][forum_name]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$pen->forum_name}}"></td>
                                        <td class="text-center"><input type="number"
                                                name=" pendingdispute[{{$key}}][amt]" id="name"
                                                class="form-control form-control-sm name_list1" value="{{$pen->amt}}">
                                        </td>
                                        <td class="text-center"><input type="text"
                                                name="pendingdispute[{{$key}}][dispute]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$pen->dispute}}"></td>
                                        <td class="text-center"><input type="file" name="pendingdispute[{{$key}}][doc]"
                                                id="name" class="form-control form-control-sm name_list1"
                                                value="{{$pen->que_id}}"></td>
                                        <td class="text-center">
                                            <a class="btn btn-success"
                                                href="{{ route('doc.down',$pen->upload_id) }}">View</a>
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
                                    <th colspan="3" class="text-left">6.3 Whether transactions with related party are
                                        required to be approved by Board/Audit Committee/Shareholders under Companies
                                        Act.</th>
                                    @foreach($user_response as $key=>$response)
                                    @if($response['ques_id'] == 21)
                                    <input type="hidden" name="ques[21]" value="{{$response['ques_id']}}">
                                    <input type="hidden" name="ans21" value="{{$response['response']}}">
                                    <td class="text-center" style="width: 10%">
                                        <select id="problem1" name="problem[21]"
                                            class="form-control form-control-sm text-center">
                                            <option value="Y" @if ($response['response']=='Y' ) selected @else @endif>
                                                Yes</option>
                                            <option value="N" @if ($response['response']=='N' ) selected @else @endif>No
                                            </option>
                                        </select>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @foreach($user_response as $key=>$response)
                    @if($response['ques_id'] == 21)
                    <div class="card border-primary display1 m-2 py-10"
                        style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" id="related1">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Approving Authority</th>
                                        <th class="text-center">Date of approval</th>
                                        <th class="text-center">Pricing mechanism</th>
                                        <th class="text-center">Nature of transaction</th>
                                        {{-- <th class="text-center"><button type="button" name="add1" id="add1"
                                                class="btn btn-success">Add More</button></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($com_act)>0)
                                    @php
                                    $sn = 1;
                                    @endphp
                                    @foreach ($com_act as $key=>$act )
                                    <input type="hidden" name="company_data[{{$key}}][id]" value="{{$act->id}}">
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center"><input type="text"
                                                name="company_data[{{$key}}][authority]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$act->authority}}"></td>
                                        <td class="text-center"><input type="date"
                                                name="company_data[{{$key}}][approval_dt]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$act->approval_dt}}"></td>
                                        <td class="text-center"><input type="text"
                                                name="company_data[{{$key}}][pricing]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$act->pricing}}"></td>
                                        <td class="text-center"><input type="text"
                                                name="company_data[{{$key}}][tran_nature]" id="name"
                                                class="form-control form-control-sm name_list1"
                                                value="{{$act->tran_nature}}"></td>
                                        {{-- <td></td> --}}
                                    </tr>
                                    @endforeach
                                    @else
                                    @php
                                    $sn = 1;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center"><input type="text" name="company_data[1][authority]"
                                                id="name" class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="date" name="company_data[1][approval_dt]"
                                                id="name" class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="company_data[1][pricing]"
                                                id="name" class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="company_data[1][tran_nature]"
                                                id="name" class="form-control form-control-sm name_list1"></td>
                                        {{-- <td></td> --}}
                                    </tr>
                                    @endif
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
                                    <th colspan="3" class="text-left">6.4 Whether applicant is required to file form
                                        3CEB for the year under consideration.</th>
                                    @foreach($user_response as $key=>$response)
                                    @if($response['ques_id'] == 22)
                                    <input type="hidden" name="ques[22]" value="{{$response['ques_id']}}">
                                    <input type="hidden" name="ans22" value="{{$response['response']}}">
                                    <td class="text-center" style="width: 10%">
                                        <select id="problem2" name="problem[22]"
                                            class="form-control form-control-sm text-center">
                                            <option value="Y" @if ($response['response']=='Y' ) selected @else @endif>
                                                Yes</option>
                                            <option value="N" @if ($response['response']=='N' ) selected @else @endif>No
                                            </option>
                                        </select>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @foreach($user_response as $key=>$response)
                    @if($response['ques_id'] == 22)
                    <div class="card border-primary display2 m-2 py-10"
                        style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" id="related2">

                                <tbody>

                                    @if($consi != null)

                                    <tr>
                                        <th class="">Upload a copy of Form 3CEB</th>
                                        <input type="hidden" name="consideration[1][consi_id]" @if($consi['id'])
                                            value="{{$consi['id']}}" @endif>
                                        <td class=""><input type="file" name="consideration[1][cd]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="">
                                            <input type="hidden" name="consideration[1][cd_upload_id]"
                                                value="{{$consi['cd_upload_id']}}">
                                            @if($consi['cd_upload_id']!=null)
                                            <a class="btn btn-success"
                                                href="{{ route('doc.down',$consi['cd_upload_id']) }}">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="">Transfer pricing study as per Income Tax Act.</th>
                                        <td class=""><input type="file" name="consideration[1][ceb]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="">
                                            <input type="hidden" name="consideration[1][ceb_upload_id]"
                                                value="{{$consi['ceb_upload_id']}}">
                                            @if($consi['ceb_upload_id']!=null)
                                            <a class="btn btn-success"
                                                href="{{ route('doc.down',$consi['ceb_upload_id']) }}">View</a>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Whether Pricing mechanismis same as applied under form 3CEB.</th>
                                        <td class="">
                                            <select id="problem3" name="problem[23]"
                                                class="form-control form-control-sm text-center">
                                                <option value="Y" @if($consi['sub_response']=='Y' )selected @endif>Yes
                                                </option>
                                                <option value="N" @if($consi['sub_response']=='N' )selected @endif>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="">Explain Pricing Mechanism.</th>
                                        <td class=""><input type="file" name="consideration[1][tax]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="">
                                            <input type="hidden" name="consideration[1][tax_upload_id]"
                                                value="{{$consi['tax_upload_id']}}">
                                            @if($consi['tax_upload_id']!=null)
                                            <a class="btn btn-success"
                                                href="{{ route('doc.down',$consi['tax_upload_id']) }}">View</a>
                                            @endif
                                        </td>
                                    </tr>

                                    @else
                                    <tr class="">
                                        <th class="">Upload a copy of Form 3CEB</th>
                                        <td class=""><input type="file" name="consideration[1][cd]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tr>
                                    <tr>
                                        <th class="">Transfer pricing study as per Income Tax Act.</th>
                                        <td class=""><input type="file" name="consideration[1][ceb]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tr>
                                    <tr>
                                        <th>Whether Pricing mechanismis same as applied under form 3CEB.</th>
                                        <td class="text-center">
                                            <select id="problem3" name="problem[23]"
                                                class="form-control form-control-sm text-center">
                                                <option selected>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="">Transfer pricing study as per Income Tax Act.</th>
                                        <td class=""><input type="file" name="consideration[1][tax]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    @endforeach

                    {{-- <div class="card-body mt-4">
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-left">6.5 Whether Pricing mechanismis same as applied
                                        under form 3CEB.</th>
                                    @foreach($user_response as $key=>$response)
                                    @if($response['ques_id'] == 23)
                                    <input type="hidden" name="ques[23]" value="{{$response['ques_id']}}">
                                    <td class="text-center" style="width: 10%">
                                        <select id="problem3" name="problem[23]"
                                            class="form-control form-control-sm text-center">
                                            <option value="Y" @if ($response['response']=='Y' ) selected @else @endif>
                                                Yes</option>
                                            <option value="N" @if ($response['response']=='N' ) selected @else @endif>No
                                            </option>
                                        </select>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @foreach($user_response as $key=>$response)
                    @if($response['ques_id'] == 23)
                    <div class="card border-primary display3 m-2 py-10"
                        style=" @if ($response['response'] == 'Y') display  @else display:none; @endif">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover" id="related2">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Explain pricing mechanism.</th>
                                        <th class="text-center">View File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($price != null)
                                    @php
                                    $sn = 1;
                                    @endphp
                                    <td class="text-center">{{ $sn++ }}</td>
                                    <td class="text-center"><input type="file" name="pricing_mech[1][doc]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                    <input type="hidden" name="pricing_mech[1][id]" value="{{$price->id}}">
                                    <input type="hidden" name="pri_res" value="{{$price->response}}">
                                    <input type="hidden" name="pricing_mech[1][doc_upload_id]"
                                        value="{{$price->upload_id}}">
                                    <td class="text-center">
                                        <a class="btn btn-success"
                                            href="{{ route('doc.down',$price->upload_id) }}">View</a>
                                    </td>
                                    @else
                                    @php
                                    $sn = 1;
                                    @endphp
                                    <td class="text-center">{{ $sn++ }}</td>
                                    <td class="text-center"><input type="file" name="pricing_mech[1][doc]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    @endforeach --}}
                </div>

                <div class="row py-2">
                    <div class="col-md-2 offset-md-0">
                        <a href="{{ route('claimprojectdetail.edit',$apps->claim_id) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i> Project Details</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" disa id="rpt_det"><i
                                class="fas fa-save"></i> Save as Draft</button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claimdocumentupload.create', ['A',$apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Upload Section
                            A<i class="fa  fa-forward"></i></a>
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
            var sn = {{sizeof($pending)}}+1;
            $('#add').click(function() {
                i++;
                $('#related').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td><td class="text-center"><input type="number" name="pendingdispute['+ (sn-1) +'][year]" id="name" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="text" name="pendingdispute['+ (sn-1) +'][forum_name]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="number" name=" pendingdispute['+ (sn-1) +'][amt]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="text" name="pendingdispute['+ (sn-1) +'][dispute]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="file" name="pendingdispute['+ (sn-1) +'][doc]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
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
            var i = 1;
            var sn ={{sizeof($com_act)}} + 1;
            $('#add1').click(function() {
                i++;
                $('#related1').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td><td class="text-center"><input type="text" name="company_data['+ (sn-1) +'][authority]" id="name"class="form-control form-control-sm name_list1"></td> <td class="text-center"><input type="date" name="company_data['+ (sn-1) +'][approval_dt]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="number" name="company_data['+ (sn-1) +'][pricing]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="text" name="company_data['+ (sn-1) +'][tran_nature]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove1">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove1', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
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


        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add2').click(function() {
                i++;
                $('#related2').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td><td><input type="file" name="name[]"  class="form-control name_list" /></td><td><input type="file" name="name[]"  class="form-control name_list" /></td><td><input type="file" name="name[]"  class="form-control name_list" /></td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove2">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove2', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            var count={{sizeof($related_party)}} ;

            $('#add3').click(function() {
                i++;
                count++;
                $('#related3').append('<tr id="row' + i +'"><th class="text-center">'+ count++ +'</th> <input type="hidden" name="app_num['+ (count-1) +'][prt_id]" value="8"><th><input type="text" name="app_num['+(count-1)+'][prt_name]" id="app_num"  class="form-control name_list" /></th><td><input type="number" name="app_num['+(count-1)+'][fy_statement]" id="app_num"  class="form-control name_list addition" /></td><td><select id="problem3ceb'+(count-1)+'" name="app_num['+(count-1)+'][3CEB]" class="form-control form-control-sm text-center 3ceb_select"><option selected >Select</option><option value="NA">Not Applicable</option><option value="0">Not Yet Filed</option><option value="Y">Filed</option></select><input type="number" name="app_num['+(count-1)+'][3CEB_A]" id="problem3ceb'+(count-1)+'t" value="" class="form-control form-control-sm addition1" style="font-size: 15px;display: none"></td><td><select id="problem3cd'+(count-1)+'" name="app_num['+(count-1)+'][cd_type]"class="form-control form-control-sm text-center 3cd_select"><option selected >Select</option><option value="NA">Not Applicable</option> <option value="0">Not Yet Filed</option> <option value="Y">Filed</option></select><input type="number" name="app_num['+(count-1)+'][3CD]" value="" id="problem3cd'+(count-1)+'t" class="form-control form-control-sm addition2" style="font-size: 15px; display: none"> </td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove3">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove3', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                var sum23 = 0;
                $(".addition").each(function(){
                    sum23 +=  +$(this).val();
                });
                $(".tot_addition").val(sum23.toFixed(2));
                
                var sum = 0;
                $(".addition1").each(function(){
                    sum +=  +$(this).val();
                });
                $(".tot_addition1").val(sum.toFixed(2));

                var sum1 = 0;
                $(".addition2").each(function(){
                    sum1 +=  +$(this).val();
                });
                $(".tot_addition2").val(sum1.toFixed(2));
            });
        });

        $(document).on("keyup", ".addition", function(){
            var sum = 0;
            $(".addition").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition").val(sum);
        });

        $(document).on("keyup", ".addition1", function(){
            var sum = 0;
            $(".addition1").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition1").val(sum);
        });

        $(document).on("keyup", ".addition2", function(){
            var sum = 0;
            $(".addition2").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition2").val(sum);
        });



        $(document).ready(function() {
            $('#problem2').on('change', function() {
                $('.display2').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display2').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem3').on('change', function() {
                $('.display3').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display3').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });
        $(document).ready(function() {
            $("#related3").delegate(".3ceb_select", "change", function() {
                var id= $(this).attr('id');
                if(this.value == 'Y'){
                    $("#"+id+"t").show();

                }else{
                    $("#"+id+"t").hide();
                }

            });
        });

        $(document).ready(function() {
            $("#related3").delegate(".3cd_select", "change", function() {
                var id= $(this).attr('id');
                if(this.value == 'Y'){
                    $("#"+id+"t").show();
                }else{
                    $("#"+id+"t").hide();
                }

            });
        });

        $(document).ready(function () {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("rpt_det");
                btn.disabled = true;
                setTimeout(function(){btn.disabled = false;}, (1000*20));
            });
        });
</script>

@endpush

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimRelatedPartyRequestEdit','#relatedparty-create') !!}
@endpush