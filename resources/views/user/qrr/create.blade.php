@extends('layouts.user.dashboard-master')

@section('title')
QRR Dashboard
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <form action='{{ route('qpr.store') }}' id="qrr-create" role="form" method="post"
            class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $apps->id }}">
            <input type="hidden" id="qtr_name" name="qtr_name" value="{{ $qtr }}">

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Applicant / Company Details</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Name</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Coorporate Office Address</label>
                            <textarea class="form-control form-control-sm" rows="2" disabled>{{ $companyDet->corp_add }} , {{ $companyDet->corp_city }}, {{ $companyDet->corp_state }}, {{ $companyDet->corp_pin }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Approved Eligible Product</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ $prods->product }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Target Segment</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ $prods->target_segment }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Application Number</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ $apps->app_no }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label col-form-label-sm">Application Approval Date</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ $apps->approval_dt }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Project Details</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">Committed Annual Capacity (MT)</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{ $eva_det->capacity }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">Committed Investment (Rs. crore)</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{  $eva_det->investment  }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">Quoted Sales Price  (Rs./kg.)</label>
                            <input type="text" class="form-control form-control-sm"
                                value="{{  $eva_det->price  }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label col-form-label-sm">Installed Annual Capacity(MT)</label>
                            <input type="number" class="form-control form-control-sm" name="pd_capacity" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Status of Commercial Date</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-7">
                            <label class="col-form-label col-form-label-sm">Scheduled Commercial Operational Date</label>
                        </div><div class="col-md-4 form-group">
                            <input type="text" class="form-control form-control-sm"
                                value="{{  $proposal_det->prod_date  }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <label class="col-form-label col-form-label-sm">Whether the committed annual production capacity of eligible product has been installed and COD has been achieved.</label>
                        </div><div class="col-md-4 form-group">
                            <select class="form-control form-control-sm conditioncheck" id="proCap" name="proCap">
                                @if(empty($commercial_dt))
                                    <option value="" selected="selected">Please Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                @else
                                    <option value="yes" @if($commercial_dt->committed_annual=='yes')selected @endif>Yes</option>
                                    <option value="no" @if($commercial_dt->committed_annual=='no')selected @endif @if($commercial_dt->committed_annual=='yes')disabled @endif>No</option>
                                @endif
                              </select>
                        </div>
                    </div>
                    <div class="row actual_dt">
                        <div class="form-group col-md-7 ">
                            <label class="col-form-label col-form-label-sm">Actual Date of Commercial Operation</label>
                        </div><div class="col-md-4 form-group">
                            @if(empty($commercial_dt))
                            <input type="date" class="form-control form-control-sm"
                            id="dateCO" name="dateCO"  value="" disabled>
                            @else
                            <input type="date" class="form-control form-control-sm"
                            id="dateCO" name="dateCO" @if($commercial_dt->committed_annual =='yes') value="{{$commercial_dt->commercial_op}}" @endif  @if ($commercial_dt->committed_annual!='yes') disabled @endif  @if ($commercial_dt->committed_annual=='yes')readonly @endif>
                            @endif
                        </div>
                    </div>
                    <div class="row expected_dt">
                        <div class="form-group col-md-7 ">
                            <label class="col-form-label col-form-label-sm">Expected Date of Commercial Operation</label>
                        </div><div class="col-md-4 form-group">
                            @if(empty($commercial_dt))
                            <input type="date" class="form-control form-control-sm"
                            id="expected_dt" name="dateCO"  value="" disabled>
                            @else
                            <input type="date" class="form-control form-control-sm"
                            id="expected_dt" name="dateCO" @if ($commercial_dt->committed_annual =='no') value="{{$commercial_dt->commercial_op}}" @endif @if ($commercial_dt->committed_annual!='no') disabled @endif>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Manufacturing Location</b>
                </div>
                <div class="card-body">
                    <span class="help-text">
                        <b> Location of Greenfield Project proposed under the scheme<b>
                        <br>(i) Provide production capacity of all the products in the manufacturing location.
                        <br>(ii) Existing Capacity and Greenfield Capacity of Eligible Product approved under the scheme may be shown separately.
                    </span>
                    <div class="card border-primary p-0 mb-1">
                        <div class="card-header">
                            <b>Address</b>
                            <a href="{{route('manuaddress.create',['id' => $apps->id, 'qtr' => $qtr,'type' => 'green'])  }}"
                                class="btn btn-success btn-sm float-right"> Add Address</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm p-0 m-0" id="manuaddr_21_Table">
                                    <thead>
                                        <tr>
                                            <th >Address</th>
                                            <th >State</th>
                                            <th >City</th>
                                            <th >Pin Code</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($green_mAddress as $item)
                                        <tr>
                                            <td>{{$item->address}}</td>
                                            <td>{{$item->state}}</td>
                                            <td>{{$item->city}}</td>
                                            <td>{{$item->pincode}}</td>
                                            <td><a href="{{route('manuaddress.edit',['id' => $item->id, 'qtr' => $qtr,'type' => 'green']) }}"
                                                class="btn btn-success btn-sm float-right">Edit</a></td>
                                            <td><a href="{{route('manuaddress.delete',$item->id) }}"
                                                class="btn btn-warning btn-sm float-right">Delete</a></td>
                                         </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <span class="help-text">
                        <b>(iii) Other Manufacturing Facilities </b>
                            Please provide address and product wise manufacturing capacity of
                            all the products and Production facilities.
                    </span>
                    <div class="card border-primary p-0 mb-1">
                        <div class="card-header">
                            <b>Address</b>
                            <a href="{{route('manuaddress.create',['id' => $apps->id, 'qtr' => $qtr,'type' => 'other']) }}"
                                class="btn btn-success btn-sm float-right"> Add Address</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm p-0 m-0" id="manuaddr_21_Table">
                                    <thead>
                                        <tr>
                                            <th>Address</th>
                                            <th >State</th>
                                            <th >City</th>
                                            <th >Pin Code</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($other_mAddress as $item)
                                        <tr>
                                            <td>{{$item->address}}</td>
                                            <td>{{$item->state}}</td>
                                            <td>{{$item->city}}</td>
                                            <td>{{$item->pincode}}</td>
                                            <td><a href="{{route('manuaddress.edit',['id' => $item->id, 'qtr' => $qtr,'type' => 'other'])}}"
                                                class="btn btn-success btn-sm float-right">Edit</a></td>
                                            <td><a href="{{route('manuaddress.delete',$item->id) }}"
                                                class="btn btn-warning btn-sm float-right">Delete</a></td>
                                         </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Means of Finance</b>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Amount (Rs. crore)</th>
                                    <th>Status and Arrangement</th>
                                    <th style="width:40%">Remarks</th>
                                </tr>
                                <tr>
                                    <td>Equity</th>
                                    <td><input type="text" class="form-control form-control-sm amount"
                                        name="eAmount" id="eAmount" ></td>
                                    <td><select class="form-control form-control-sm conditioncheck"
                                        name="eStatus" id="eStatus">
                                            <option value="" selected="selected">Please Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                          </select>
                                    </td>
                                    <td><textarea
                                        class="form-control form-control-sm" rows="2"
                                        name="eRemarks" id="eRemarks"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Debt</th>
                                    <td><input type="text" class="form-control form-control-sm amount"
                                        name="dAmount" id="dAmount" ></td>
                                    <td><select class="form-control form-control-sm conditioncheck"
                                        name="dStatus" id="dStatus">
                                            <option value="" selected="selected">Please Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                          </select></td>
                                    <td><textarea
                                        class="form-control form-control-sm" rows="2"
                                        name="dRemarks" id="dRemarks"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Internal Accrual</th>
                                    <td><input type="text" class="form-control form-control-sm amount"
                                        name="iAmount" id="iAmount" ></td>
                                    <td><select class="form-control form-control-sm conditioncheck"
                                        name="iStatus" id="iStatus">
                                            <option value="" selected="selected">Please Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                          </select></td>
                                    <td><textarea
                                        class="form-control form-control-sm" rows="2"
                                        name="iRemarks" id="iRemarks"></textarea></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><input type="text" class="form-control form-control-sm tamount"
                                        name="tAmount" id="tAmount" readonly></td>
                                        <td></td>
                                        <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="help-text">Please mention about tie-up of requisite funds for installation of project and give remarks about current status. For example whether investors have infused equity or sanction of loans from Banks/ Fis/ other finanncial intermediaries.</span>
                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper" id="submitshareper"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href=#
                    class="btn btn-warning btn-sm form-control form-control-sm">
                    <i class="fas fa-angle-double-right"></i>Revenue</a>
                </div>
            </div>


        </form>

    </div>
</div>
@endsection

@push('scripts')
@include('user.partials.js.prevent_multiple_submit')
@include('user.partials.js.create-qrr')
{!! JsValidator::formRequest('App\Http\Requests\QRRDetStore','#qrr-create') !!}
@endpush
