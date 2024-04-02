@extends('layouts.user.dashboard-master')

@section('title')
    @if ($change_type == 'A')
        Authorised Signatory
    @elseif($change_type == 'C')
        Corporate Address
    @elseif($change_type == 'R')
        Registered Address
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
@endpush
@section('content')
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info">
                    <div class="row">
                        <div class="col-md-2 text-bold">
                            @if ($change_type == 'A')
                                Authorised Signatory
                            @elseif($change_type == 'C')
                                Corporate Address
                            @elseif($change_type == 'R')
                                Registered Address
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.storeAuthoriseSignatory') }}" id="authorise-signatory" role="form"
                        method="post" class='form-horizontal' files=true enctype='multipart/form-data'
                        accept-charset="utf-8">
                        @csrf

                        @if ($change_type == 'A')
                            <input type="hidden" name="change_type" id="" value="{{ $change_type }}"
                                class="form-control form-control-sm">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th class="w-50">Name of Authorised Person</th>
                                        <td><input type="text" name="authorise_user_name" required
                                                class="form-control form-control-sm"></td>
                                        @if ($errors->has('authorise_user_name'))
                                            <span class="invalid feedback"role="alert" style="color:red;">
                                                <strong>{{ $errors->first('authorise_user_name') }}.</strong>
                                            </span>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="w-50">Designation</th>
                                        <td><input type="text" name="designation" class="form-control form-control-sm"
                                                required></td>
                                        @if ($errors->has('designation'))
                                            <span class="invalid feedback"role="alert" style="color:red;">
                                                <strong>{{ $errors->first('designation') }}.</strong>
                                            </span>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="w-50">Phone</th>
                                        <td><input type="text" name="mobile" class="form-control form-control-sm"
                                                required>
                                            @if ($errors->has('mobile'))
                                                <span class="invalid feedback"role="alert" style="color:red;">
                                                    <strong>{{ $errors->first('mobile') }}.</strong>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">E-Mail</th>
                                        <td><input type="text" name="email" class="form-control form-control-sm">
                                            @if ($errors->has('email'))
                                                <span class="invalid feedback"role="alert" style="color:red;">
                                                    <strong>{{ $errors->first('email') }}.</strong>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">Request letter for Authorisation</th>
                                        <td><input type="file" name="authorizeLetter"
                                                class="form-control form-control-sm" style="padding:1px"></td>
                                        @if ($errors->has('authorizeLetter'))
                                            <span class="invalid feedback"role="alert" style="color:red;">
                                                <strong>{{ $errors->first('authorizeLetter') }}.</strong>
                                            </span>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span style="font-weight: bold">Note:</span>Formal request attached on the latter head of the company specifying old information vis-a-vis new information with reason for change(Format-PDF).</td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                            <div class="text-center">
                                <a href="{{ route('admin.authoriseSignatory.auth_dash') }}" class="btn btn-success btn-sm form-control form-control-sm"
                                style="width:10%;"><i class="fa fa-arrow-left"></i> Back</a>
                                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"
                                    style="width:10%;"><i class="fas fa-save"></i> Submit</button>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info">
                                            <div class="row">
                                                <div class="col-md-4 text-bold">
                                                    Authorised Signatory Request
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if (!empty($authorisedPersonRow))
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table cellspacing="0" width="100%"
                                                            class="table table-sm table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center col-6">Previous</th>
                                                                    <th class="text-center col-6">Current</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table cellspacing="0" width="100%"
                                                                            class="table table-sm table-bordered table-hover">
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <td>{{ $authorisedPersonRow->old_contact_person }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Designation</th>
                                                                                <td>{{ $authorisedPersonRow->old_designation }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Phone</th>
                                                                                <td>{{ $authorisedPersonRow->old_mobile }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>E-Mail</th>
                                                                                <td>{{ $authorisedPersonRow->old_email }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td>
                                                                        <table cellspacing="0" width="100%"
                                                                            class="table table-sm table-bordered table-hover">
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <td>{{ $authorisedPersonRow->new_contact_person }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Designation</th>
                                                                                <td>{{ $authorisedPersonRow->new_designation }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Phone</th>
                                                                                <td>{{ $authorisedPersonRow->new_mobile }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>E-Mail</th>
                                                                                <td>{{ $authorisedPersonRow->new_email }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Status</th>
                                                                                <td>
                                                                                    @if($authorisedPersonRow->status == 'S')
                                                                                        Pending
                                                                                    @elseif($authorisedPersonRow->status == 'R')
                                                                                        Rejected
                                                                                    @elseif($authorisedPersonRow->status == 'A')
                                                                                        Approved
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Uploaded Document</th>
                                                                                    <td class="text-center"  class=""><a class="btn-sm btn-primary" href="{{ route('admin.down', encrypt($authorisedPersonRow->upload_id)) }}">View</a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                No Pending Request
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($change_type == 'C')
                            <div class="card-body">
                                <div class="card border-primary p-0 mb-1">
                                    <div class="card-body p-0">
                                        <div class="table-responsive rounded m-0 p-0">
                                            <table class="table table-bordered table-hover table-sm p-0 m-0"
                                                id="manu_address">
                                                <thead>

                                                    {{-- {{dd($corporate_add)}} --}}
                                                    @foreach ($corporate_add as $key => $location)
                                                        <tr>
                                                            <th class="">Address</th>
                                                            <input type="hidden" name="change_type" id=""
                                                                value="{{ $change_type }}"
                                                                class="form-control form-control-sm">
                                                            <input type="hidden" name="id" id="id]"
                                                                value="{{ $location->id }}"
                                                                class="form-control form-control-sm">
                                                            <td style="">
                                                                <input type="text" name="addr"
                                                                    class="form-control name_list"
                                                                    value="{{ $location->off_add }}" />
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <th>State</th>
                                                            <td style="width: 780px">
                                                                <select id="corpAddState_0" name="state"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $location->off_state }}"
                                                                    onchange="GetCityByStateName(this.value)">
                                                                    <option value="" selected="selected">Please
                                                                        select..
                                                                    </option>
                                                                    @foreach ($states as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($key == $location->off_state) selected @endif>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('state')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">City</th>
                                                            <td style="width: 780px">
                                                                <select id="corpAddCity_0" name="city"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $location->off_city }}"
                                                                    onkeyup="chekPinCode(this.value)">
                                                                    <option value="">Please choose..</option>
                                                                    @foreach ($city->where('state', $location->off_state) as $kcity => $vcity)
                                                                        <option value="{{ $vcity->city }}"
                                                                            @if ($location->off_city == $vcity->city) selected @endif>
                                                                            {{ $vcity->city }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('city')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">Pincode</th>
                                                            <td style="width: 780px">
                                                                <input type="number" name="pincode" id="corpAddPin_0"
                                                                    class="form-control name_list"
                                                                    value="{{ $location->off_pin }}" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th>Request Letter</th>
                                                        <td colspan="2"><input type="file" name="corpletter"
                                                                class="form-control form-control-sm" style="padding:1px"
                                                                required></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Proof of Address</th>
                                                        <td colspan="2"><input type="file" name="corpProof"
                                                                class="form-control form-control-sm" style="padding:1px"
                                                                required></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                    <a href="{{ route('admin.authoriseSignatory.auth_dash') }}" class="btn btn-success btn-sm form-control form-control-sm"
                                    style="width:10%;"><i class="fa fa-arrow-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"
                                        style="width:10%;"><i class="fas fa-save"></i> Submit</button>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info">
                                            <div class="row">
                                                <div class="col-md-4 text-bold">
                                                    Pending Corporate Address
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            @if (count($corporate_add_change) > 0)
                                                @foreach ($corporate_add_change as $key => $data)
                                                    @if ($data->status != 'A')
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table cellspacing="0" width="100%"
                                                                    class="table table-sm table-bordered table-hover">
                                                                    <tbody>
                                                                        <tr class="table-info">
                                                                            <th class="text-center">Previous</th>
                                                                            <th class="text-center">Current</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table cellspacing="0" width="100%"
                                                                                    class="table table-sm table-bordered table-hover">

                                                                                    <tr>
                                                                                        <th>Address</th>
                                                                                        <td>{{ $data->off_add }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>State</th>
                                                                                        <td>{{ $data->off_state }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>City</th>
                                                                                        <td>{{ $data->off_city }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Pin Code</th>
                                                                                        <td>{{ $data->off_pin }}</td>
                                                                                    </tr>
                                                                        </tr>
                                                                </table>
                                                                <td>
                                                                    <table cellspacing="0" width="100%"
                                                                        class="table table-sm table-bordered table-hover">
                                                                        <tr>
                                                                            <th>Address</th>
                                                                            <td>{{ $data->new_off_add }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>State</th>
                                                                            <td>{{ $data->new_off_state }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>City</th>
                                                                            <td>{{ $data->new_off_city }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Pin Code</th>
                                                                            <td>{{ $data->new_off_pin }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <td>
                                                                                @if($data->status == 'S')
                                                                                    Pending
                                                                                @elseif($data->status == 'R')
                                                                                    Rejected
                                                                                @elseif($data->status == 'A')
                                                                                    Approved
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Request of Letter</th>
                                                                                <td class="text-center"  class=""><a class="btn-sm btn-primary" href="{{ route('admin.down', encrypt($data->upload_id_letter)) }}">View</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Proof of Address</th>
                                                                                <td class="text-center"  class=""><a class="btn-sm btn-primary" href="{{ route('admin.down', encrypt($data->upload_id_proof)) }}">View</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                </tr>

                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                No Pending Request
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($change_type == 'R')
                            <div class="card-body">
                                <div class="card border-primary p-0 mb-1">
                                    <div class="card-body p-0">
                                        <div class="table-responsive rounded m-0 p-0">
                                            <table class="table table-bordered table-hover table-sm p-0 m-0"
                                                id="manu_address">
                                                <input type="hidden" name="change_type" id=""
                                                    value="{{ $change_type }}" class="form-control form-control-sm">
                                                <thead>
                                                    @foreach ($registered_add as $key => $location)
                                                        <tr>
                                                            <th class="">Address</th>
                                                            <input type="hidden" name="app_id" id=""
                                                                value="{{ $location->app_id }}"
                                                                class="form-control form-control-sm">
                                                            <input type="hidden" name="id" id="id]"
                                                                value="{{ $location->id }}"
                                                                class="form-control form-control-sm">
                                                            <td style="" colspan="3">
                                                                <input type="text" name="addr"
                                                                    class="form-control name_list"
                                                                    value="{{ $location->corp_add }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>State</th>
                                                            <td style="width: 780px">
                                                                <select id="corpAddState_0" name="state"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $location->corp_state }}"
                                                                    onchange="GetCityByStateName(this.value)">
                                                                    <option value="" selected="selected">Please
                                                                        select..
                                                                    </option>
                                                                    @foreach ($states as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($key == $location->corp_state) selected @endif>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('state')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>City</th>
                                                            <td style="width: 780px">
                                                                <select id="corpAddCity_0" name="city"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $location->corp_city }}"
                                                                    onkeyup="chekPinCode(this.value)">
                                                                    <option value="">Please choose..</option>
                                                                    @foreach ($city->where('state', $location->corp_state) as $kcity => $vcity)
                                                                        <option value="{{ $vcity->city }}"
                                                                            @if ($location->corp_city == $vcity->city) selected @endif>
                                                                            {{ $vcity->city }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('city')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pincode</th>
                                                            <td style="width: 780px">
                                                                <input type="number" name="pincode" id="corpAddPin_0"
                                                                    class="form-control name_list"
                                                                    value="{{ $location->corp_pin }}" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th>Request Letter</th>
                                                        <td><input type="file" name="registeredletter"
                                                                class="form-control form-control-sm" style="padding:1px"
                                                                required></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Proof Of Address</th>
                                                        <td><input type="file" name="registeredProof"
                                                                class="form-control form-control-sm" style="padding:1px"
                                                                required></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('admin.authoriseSignatory.auth_dash') }}" class="btn btn-success btn-sm form-control form-control-sm"
                                style="width:10%;"><i class="fa fa-arrow-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"
                                        style="width:10%;"><i class="fas fa-save"></i> Submit</button>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info">
                                            <div class="row">
                                                <div class="col-md-4 text-bold">
                                                    Pending Registered Address
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            @if (count($registered_add_change) > 0)
                                                @foreach ($registered_add_change as $key => $data)
                                                    @if ($data->status != 'A')
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table cellspacing="0" width="100%"
                                                                    class="table table-sm table-bordered table-hover">
                                                                    <tbody>
                                                                        <tr class="table-info">
                                                                            <th class="text-center">Previous</th>
                                                                            <th class="text-center">Current</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table cellspacing="0" width="100%"
                                                                                    class="table table-sm table-bordered table-hover">

                                                                                    <tr>
                                                                                        <th>Address</th>
                                                                                        <td>{{ $data->corp_add }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>State</th>
                                                                                        <td>{{ $data->corp_state }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>City</th>
                                                                                        <td>{{ $data->corp_city }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Pin Code</th>
                                                                                        <td>{{ $data->corp_pin }}</td>
                                                                                    </tr>
                                                                        </tr>
                                                                </table>
                                                                <td>
                                                                    <table cellspacing="0" width="100%"
                                                                        class="table table-sm table-bordered table-hover">
                                                                        <tr>
                                                                            <th>Address</th>
                                                                            <td>{{ $data->new_corp_add }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>State</th>
                                                                            <td>{{ $data->new_corp_state }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>City</th>
                                                                            <td>{{ $data->new_corp_city }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Pin Code</th>
                                                                            <td>{{ $data->new_corp_pin }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Request of Letter</th>
                                                                                <td class="text-center"  class=""><a class="btn-sm btn-primary" href="{{ route('admin.down', encrypt($data->upload_id_letter)) }}">View</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Proof of Address</th>
                                                                                <td class="text-center"  class=""><a class="btn-sm btn-primary" href="{{ route('admin.down', encrypt($data->upload_id_proof)) }}">View</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                </tr>

                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                No Pending Request
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\AuthorisedRequest', '#authorise-signatory') !!}
@endpush
@push('scripts')
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script>
        function GetCityByStateName(state_name) {
            jQuery.ajax({
                type: "GET",
                url: "/cities/" + state_name,
                dataType: "json",
                success: function(data) {
                    jQuery('#corpAddCity_0').empty();
                    $('#corpAddCity_0').append('<option value="">Please Choose...</option>');
                    jQuery.each(data, function(key, value) {
                        $('#corpAddCity_0').append('<option value="' + key + '">' + value +
                        '</option>');
                    });
                }
            });
        }

        function chekPinCode(pincode) {

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
    {!! JsValidator::formRequest('App\Http\Requests\AuthorizeSignatory', '#authorise-signatory') !!}
@endpush
