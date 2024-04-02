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
        <form action="{{ route('manuaddress.update',$loc_id) }}" id="madd-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $loc['app_id'] }}">
            <input type="hidden" id="qtr" name="qtr" value="{{ $loc['qtr_id'] }}">
            <input type="hidden" id="type" name="type" value="{{ $type }}">

            
            <div class="col-md-4" style="margin-left:66%">
                @if($qrr==null)
                <a href="{{ route('qpr.create',['id'=>$loc['app_id'],'qrrName'=>$qtr]) }}"
                    class="btn btn-warning btn-sm form-control form-control-sm"><i
                        class="fas fa-angle-double-left"></i>Back to Create Details </a>
                @else 
                <a href="{{ route('qpr.edit',$qrr->id) }}"
                    class="btn btn-warning btn-sm form-control form-control-s>m"><i
                        class="fas fa-angle-double-left"></i>Back to Create Details </a>
                @endif
            </div>
        <small class="text-danger">(All fields are mandatory)</small>
            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Applicant / Company Details</b>
                </div>
                <div class="card-body">
                    <div class="card border-primary p-0 mb-1">
                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm p-0 m-0" id="manu_address">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center ">Address</th>
                                        </tr>
                                        <tr >
                                            <th colspan="3"><input type="text" id="address" name="address" placeholder="Address" class="form-control form-control-sm" value="{{$loc['address']}}" readonly></th>
                                        </tr>
                                    </tr>
                                    <th class="text-center ">State</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Pincode</th>
                                    {{-- <th class="text-center"><button type="button" name="add" id="add"
                                       class="btn btn-success">Add More</button></th> --}}
                                 </tr>
                                 <tr>
                                    {{-- @foreach($loc as $key => $location) --}}
                                    <tr>
                                  
                                       <td style="width: 780px">
                                             <select id="corpAddState_0" name="state"
                                                class="form-control form-control-sm"
                                                value="{{ $loc['state'] }}" onchange="GetCityByStateName(this.value)">
                                                <option value="" selected="selected">Please select..
                                                </option>
                                                @foreach ($states as $key => $value)
                                                   <option value="{{$key}}"
                                                         @if ($key ==$loc['state']) selected @endif>
                                                         {{ $value }}</option>
                                                @endforeach
                                             </select>
                                             @error('state')
                                                <span class="text-danger">{{ $message }}</span>
                                             @enderror
                                       </td>
                                      
                                       <td style="width: 780px">
                                             <select id="corpAddCity_0" name="city"
                                                class="form-control form-control-sm"
                                                value="{{ $loc['city'] }}" onkeyup="chekPinCode(this.value)">
                                                <option value="">Please choose..</option>
                                                   @foreach($city->where('state',$loc['state']) as $kcity => $vcity)
                                                   <option value="{{ $vcity->city }}" @if($loc['city']== $vcity->city) selected @endif>{{$vcity->city   }}</option>
                                                   @endforeach
                                             </select>
                                             @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                             @enderror
                                       </td>
                                       <td style="width: 780px">
                                             <input type="number" name="pincode"
                                                id="corpAddPin_0" class="form-control name_list"
                                                value="{{ $loc['pincode'] }}" />
                                       </td>
                                    </tr>
                                    {{-- @endforeach --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <table class="table table-bordered table-hover table-sm p-0 m-0" id="manuaddr_21_pro_table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:40%">Product</th>
                                                        <th style="width:40%">Capacity</th>
                                                        <th><button type="button" id="addmanuaddr_21_pro" name="addmanuaddr_21_pro"
                                                        class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add Product </button>
                                                        </th>
                                                    </tr>
                                                    @foreach ($productCapacity as $key => $item)
                                                   
                                                    
                                                    <tr>
                                                        <input type="hidden" name="madd[{{$key}}][id]" value='{{ $item->id }}' >
                                                        <td><input type="text" name="madd[{{$key}}][product]" placeholder="Product Name"
                                                            class="form-control form-control-sm" value='{{ $item->product }}' ></td>
                                                        <td><input type="text" name="madd[{{$key}}][capacity]" placeholder="Capacity"
                                                            class="form-control form-control-sm" value='{{$item->capacity}}'></td>
                                                        <td><a href="{{ route('manuaddress.deleteProduct',$item->id) }}"
                                                            class="btn btn-danger btn-sm float-right remove-prom"
                                                            onclick="return confirm('Confirm Delete?')">Remove</a></td>
                                                    </tr>
                                                    @endforeach
                                                </thead>
                                            </table>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                    class="fas fa-save"></i>
                Save as Draft</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
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
        console.log(pincode);
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
</script>
@push('scripts')
@include('user.partials.js.manufact-address')
{!! JsValidator::formRequest('App\Http\Requests\MaddressStore','#madd-create') !!}
@endpush