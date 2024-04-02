@extends('layouts.admin.master')

@section('title')
@if($change_type == 'A')
    Applicant - {{ $authorisedPersonRow->name }}
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')
    {{-- Error Messages --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <br>
            <br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
   
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('admin.users.updateAuthorization', [$authorisedPersonRow->person_id,$change_type]) }}" id="user"
                role="form" method="post" class='form-horizontal' files=true enctype='multipart/form-data'
                accept-charset="utf-8">

                @csrf
                
                @if($change_type == 'A')
                    <div class="row py-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-info">
                                    <b>Brief Particulars of the Company</b>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th class="w-50">Name of the Organization</th>
                                                <td>{{ $authorisedPersonRow->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>CIN</th>
                                                <td>{{ $authorisedPersonRow->cin_llpin }}</td>
                                            </tr>
                                            <tr>
                                                <th>PAN</th>
                                                <td>{{ $authorisedPersonRow->pan }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registered Office Address</th>
                                                <td>{{ $authorisedPersonRow->off_add }}</td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td>{{ $authorisedPersonRow->off_city }}</td>
                                            </tr>
                                            <tr>
                                                <th>State</th>
                                                <td>{{ $authorisedPersonRow->off_state }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pin Code</th>
                                                <td>{{ $authorisedPersonRow->off_pin }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-gradient-info">
                                    <b>Authorized Signatory Details</b>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table cellspacing="0" width="100%"
                                                class="table table-sm table-bordered table-hover">

                                                <tbody>
                                                    <tr class="table-info">

                                                        <th class="text-center">Old</th>
                                                        <th class="text-center">Current</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table cellspacing="0" width="100%"
                                                                class="table table-sm table-bordered table-hover">
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <td>{{ $authorisedPersonRow->old_contact_person }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Designation</th>
                                                                    <td>{{ $authorisedPersonRow->old_designation }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone</th>
                                                                    <td>{{ $authorisedPersonRow->old_mobile }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>E-Mail</th>
                                                                    <td>{{ $authorisedPersonRow->old_email }}</td>
                                                                </tr>
                                                    </tr>
                                            </table>
                                            <td>
                                                <table cellspacing="0" width="100%"
                                                    class="table table-sm table-bordered table-hover">
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{ $authorisedPersonRow->new_contact_person }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Designation</th>
                                                        <td>{{ $authorisedPersonRow->new_designation }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <td>{{ $authorisedPersonRow->new_mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>E-Mail</th>
                                                        <td>{{ $authorisedPersonRow->new_email }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            <tr>
                                            <th>Authorization Letter</th>
                                            
                                            @if($authorisedPersonRow->doc_id == 5003)
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href=" {{ route('admin.down', encrypt($authorisedPersonRow->upload_id)) }}">View</a> 
                                                </td>
                                            @endif
                                            
                                            </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($change_type == 'C')
                    <div class="row py-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-info">
                                    <b>Brief Particulars of the Company</b>
                                </div>
                                
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th class="w-50">Name of the Organization</th>
                                                <td>{{ $authorisedPersonRow->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>CIN</th>
                                                <td>{{ $authorisedPersonRow->cin_llpin }}</td>
                                            </tr>
                                            <tr>
                                                <th>PAN</th>
                                                <td>{{ $authorisedPersonRow->pan }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registered Office Address</th>
                                                <td>{{ $authorisedPersonRow->off_add }}</td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td>{{ $authorisedPersonRow->off_city }}</td>
                                            </tr>
                                            <tr>
                                                <th>State</th>
                                                <td>{{ $authorisedPersonRow->off_state }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pin Code</th>
                                                <td>{{ $authorisedPersonRow->off_pin }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-gradient-info">
                                    <b>Corporate Office Address</b>
                                </div>
                                <div class="card-body">
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
                                                                    <td>{{ $authorisedPersonRow->off_add }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>State</th>
                                                                    <td>{{ $authorisedPersonRow->off_state }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>City</th>
                                                                    <td>{{ $authorisedPersonRow->off_city }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Pin Code</th>
                                                                    <td>{{ $authorisedPersonRow->off_pin }}</td>
                                                                </tr>
                                                    </tr>
                                            </table>
                                            <td>
                                                <table cellspacing="0" width="100%"
                                                    class="table table-sm table-bordered table-hover">
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ $authorisedPersonRow->new_off_add }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td>{{ $authorisedPersonRow->new_off_state }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td>{{ $authorisedPersonRow->new_off_city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pin Code</th>
                                                        <td>{{ $authorisedPersonRow->new_off_pin }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <tr>
                                              
                                            <th>Request letter of change</th>
                                            <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href=" {{ route('admin.down', encrypt(end($doc_data)->corpletter)) }}">View</a> 
                                            </tr>
                                            <tr>
                                                <th>Proof of Address</th>
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href=" {{ route('admin.down', encrypt(end($doc_data)->corpproof)) }}">View</a> 
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($change_type == 'R')
                <div class="row py-4">
                    <div class="col-md-12">
                        <div class="card border-info">
                            <div class="card-header bg-info">
                                <b>Brief Particulars of the Company</b>
                            </div>
                           
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="w-50">Name of the Organization</th>
                                            <td>{{ $authorisedPersonRow->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>CIN</th>
                                            <td>{{ $authorisedPersonRow->cin_llpin }}</td>
                                        </tr>
                                        <tr>
                                            <th>PAN</th>
                                            <td>{{ $authorisedPersonRow->pan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Registered Office Address</th>
                                            <td>{{ $authorisedPersonRow->corp_add }}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{ $authorisedPersonRow->corp_city }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $authorisedPersonRow->corp_state }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pin Code</th>
                                            <td>{{ $authorisedPersonRow->corp_pin }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            <div class="card-header bg-gradient-info">
                                <b>Authorized Signatory Details</b>
                            </div>
                            <div class="card-body">
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
                                                                <td>{{ $authorisedPersonRow->corp_add }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td>{{ $authorisedPersonRow->corp_state }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City</th>
                                                                <td>{{ $authorisedPersonRow->corp_city }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pin Code</th>
                                                                <td>{{ $authorisedPersonRow->corp_pin }}</td>
                                                            </tr>
                                                </tr>
                                        </table>
                                        <td>
                                            <table cellspacing="0" width="100%"
                                                class="table table-sm table-bordered table-hover">
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $authorisedPersonRow->new_corp_add }}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td>{{ $authorisedPersonRow->new_corp_state }}</td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td>{{ $authorisedPersonRow->new_corp_city }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pin Code</th>
                                                    <td>{{ $authorisedPersonRow->new_corp_pin }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        </tr>
                                        <th>Request letter of change</th>
                                            <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href=" {{ route('admin.down', encrypt(end($doc_data)->regletter)) }}">View</a> 
                                            </tr>
                                            <tr>
                                                <th>Proof of Address</th>
                                                <td class="text-center p-2 "><a class="mt-2 btn-sm btn-primary" href=" {{ route('admin.down', encrypt(end($doc_data)->regproof)) }}">View</a> 
                                                </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            <div class="card-header bg-gradient-info">
                                <b>Approve/Reject Authorization Request</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 corpset-md-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="userActive" name="authorizationStatus"
                                                class="custom-control-input" value='A'
                                                @if ($authorisedPersonRow->status == 'A') checked @endif>
                                            <label class="custom-control-label" for="userActive">Approve</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="userInactive" name="authorizationStatus"
                                                class="custom-control-input" value="R"
                                                @if ($authorisedPersonRow->status == 'R') checked @endif>
                                            <label class="custom-control-label" for="userInactive">Reject
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-2 offset-md-5">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                class="fas fa-save"></i> Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

{{-- @push('scripts') --}}
{{-- {!! JsValidator::formRequest('App\Http\Requests\UpdateFees','#fees') !!} --}}
{{-- @endpush --}}
