@extends('layouts.admin.master')

@section('title')
Admin Dashboard
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- {{dd($loc['id'])}} --}}
        <form action="{{ route('admin.qrr_location.update',$loc['id']) }}" id="madd-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $loc['app_id'] }}">
            <input type="hidden" id="qtr" name="qtr" value="{{ $loc['qtr_id'] }}">
            <input type="hidden" id="type" name="type" value="">

            
        <small class="text-danger">(All fields are mandatory)</small>
            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Greenfield Location Change</b>
                </div>
                <div class="card-body">
                    <div class="card border-primary p-0 mb-1">
                        <div class="card-body p-0">
                            <div class="table-responsive rounded m-0 p-0">
                                <table class="table table-bordered table-hover table-sm p-0 m-0" id="manu_address">
                                    
                                    <thead>
                                        @foreach ($appdata as $app)
                                        <tr>
                                            <th>Name</th>
                                            <td colspan="2">{{ $app->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Application Number</th>
                                            <td colspan="2">{{ $app->app_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Target Segment</th>
                                            <td colspan="2">{{ $app->target_segment }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approved Eligible Product</th>
                                            <td colspan="2">{{ $app->product }}</td>
                                        </tr>
                                        <tr>
                                            <th>Quarter</th>
                                            <td colspan="2"> {{ $app->month }}-{{ $app->year }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>Address</th>
                                            <td colspan="2"><input type="text" id="address" name="address" placeholder="Address" class="form-control form-control-sm" value="{{$loc['address']}}" ></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center ">State</th>
                                            <th class="text-center">City</th>
                                            <th class="text-center">Pincode</th>
                                        </tr>
                                        <tr>
                                        <td style="width: 780px">
                                                <select id="corpAddState_0" name="state"
                                                    class="form-control form-control-sm"
                                                    value="{{ $loc['state'] }}" onchange="GetCityByStateName(this.value)">
                                                    <option value="" selected="selected">Please select..
                                                    </option>
                                                    @foreach ($states as $key => $value)
                                                    <option value="{{ $key }}"
                                                            @if ($key == $loc['state']) selected @endif>
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
                                                    value="{{ $loc['city'] }}" onkeyup="checkPinCode(this.value)">
                                                    <option value="">Please choose..</option>
                                                    @foreach($city as $kcity => $vcity)
                                                    <option value="{{ $kcity }}" @if($loc['city']==$vcity) selected @endif>{{ $vcity}}</option>
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
                                        <tr>
                                            <th>Remarks</th>
                                            @if($loc['remarks'])
                                            <td colspan="2"> <input type="text" name="remarks"
                                                id="remarks" class="form-control form-control-sm"
                                                value="{{ $loc['remarks'] }}" /></td>
                                            @else
                                            <td colspan="2"> <input type="text" name="remarks"
                                                id="remarks" class="form-control form-control-sm"
                                                value="" /></td>
                                            @endif
                                        </tr>
                                    </thead>
                                   
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

        function checkPinCode(pincode)
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