@extends('layouts.admin.master')

@section('title')
Applicant - {{ $user->name }}
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
{{-- Content Starts --}}

<div class="row">
    <div class="col-md-2 offset-md-10">
        <a href="{{ route('admin.users.index') }}" class="btn btn-warning btn-sm btn-block">
            <i class="fas fa-angle-double-left"></i> Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('admin.users.update',$user->id) }}" id="user" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf

            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <b>Applicant Registration Details</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%">Name of the Organization</th>
                                        <td style="width: 60%">{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>CIN / LLPIN</th>
                                        <td>{{$user->cin_llpin}}</td>
                                    </tr>
                                    <tr>
                                        <th>PAN</th>
                                        <td>{{$user->pan}}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Constitution</th>
                                        <td>{{$user->type}}</td>
                                    </tr>
                                    <tr>
                                        <th>Corporate Office Address</th>
                                        <td>
                                            {{$user->off_add}},
                                            {{$user->off_state}},
                                            {{$user->off_city}},
                                            {{$user->off_pin}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Existing manufacturer in Pharma Sector?</th>
                                        <td>@if($user->existing_manufacturer == 'Y') Yes @else No @endif</td>
                                    </tr>
                                    @if(!is_null($user->business_desc))
                                    <tr>
                                        <th>Existing business description</th>
                                        <td>{{ $user->business_desc }}</td>
                                    </tr>
                                    @endif
                                    @if(!is_null($user->applicant_desc))
                                    <tr>
                                        <th>Planning to set-up Greenfield project ?</th>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <th>Brief description of Applicant</th>
                                        <td>{{ $user->applicant_desc }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Eligible product for which application is being filed</th>
                                        <td>
                                            <table class="sub-table">
                                                <tr>
                                                    <th>Target Segment</th>
                                                    <th>Eligible Product</th>
                                                </tr>
                                                @foreach($prods as $prod)
                                                @if(in_array($prod->id,$user->eligible_product))
                                                <tr>
                                                    <td>{{ $prod->target_segment }}</td>
                                                    <td>{{ $prod->product }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Authorised Signatory Details</th>
                                        <td>
                                            <table class="sub-table">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{$user->contact_person}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Designation</td>
                                                    <td>{{$user->designation}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>{{$user->mobile}}</td>
                                                </tr>
                                                <tr>
                                                    <td>E-Mail</td>
                                                    <td>{{$user->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>{{$user->contact_add}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{--Change by Ajaharuddin Ansari--}}
            @if (AUTH::user()->hasRole('Admin'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            <div class="card-header bg-gradient-info">
                                <b>User Login Activation / Deactivation</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-danger">(User can't login into the portal, if the status is
                                            de-activated)</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="userActive" name="userStatus"
                                                class="custom-control-input" value='Y'
                                                {{ $user->isapproved == 'Y' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="userActive">Activate
                                                Login</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="userInactive" name="userStatus"
                                                class="custom-control-input" value="N"
                                                {{ $user->isapproved == 'N' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="userInactive">De-Activate
                                                Login</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea id="remarks" name="remarks" class="form-control form-control-sm" rows="2"
                                            disabled>{{ $user->remarks }}</textarea>
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
            @endif
            {{--! Ajaharuddin Ansari--}}

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        $('input:radio').click(function () {
            $("#remarks").prop("disabled", true);
            if ($(this).attr('id') == 'userInactive') {
                $("#remarks").prop("disabled", false);
            }
        });

    });

</script>
{!! JsValidator::formRequest('App\Http\Requests\admin\UserUpdate','#user') !!}
@endpush
