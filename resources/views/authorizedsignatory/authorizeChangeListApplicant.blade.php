@extends('layouts.adminshared.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('title')
Authorize Signatory Request - List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-tabs">
            <div class="card-body">
                <div class="tab-content">
                    <div>
                        <div class="row">
                            <div class="col-md-6 pt-1">
                                <h5>Authorization Change Request-List</h5>
                            </div>
                        </div>
                        <div class="card border-primary">
                        
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                        id="tablePh1">
                                        <thead class="userstable-head">
                                            <tr class="table-info">
                                                <th class="text-center">Sr No</th>
                                                <th class="text-center">Organization Name</th>
                                                <th class="text-center">Request Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="userstable-body">
                                            @php
                                            $cnt1 = 1;
                                            @endphp
                                             
                                            @foreach($authorisedPersonRows as $autorisedPersonRow)
                                           
                                            <tr>
                                                <td>{{ $cnt1}}</td>
                                                <td>{{ $autorisedPersonRow->name}}</td>
                                                <td>{{ date('d/m/Y', strtotime($autorisedPersonRow->submitted_at)) }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                                        data-target="#PendingAuthRequest" href="" title="Show List"
                                                        onclick="display_detail_pending('{{$autorisedPersonRow->old_contact_person}}','{{$autorisedPersonRow->old_designation}}','{{$autorisedPersonRow->old_email}}','{{$autorisedPersonRow->old_mobile}}','{{$autorisedPersonRow->new_contact_person}}','{{$autorisedPersonRow->new_designation}}','{{$autorisedPersonRow->new_email}}','{{$autorisedPersonRow->new_mobile}}')"><i
                                                            class="right fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                            $cnt1++;
                                            @endphp
                                            @endforeach
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
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-tabs">

            <div class="card-body">
                <div class="tab-content">

                    <div>
                        <div class="row">
                            <div class="col-md-6 pt-1">
                                <h5>Authorization Change History</h5>
                            </div>
                        </div>
                        <div class="card border-primary">
                            <div class="card-header border-primary">
                                <div class="row">
                                    <div class="col-md-2 pt-1">
                                        <h5>Export Data:</h5>
                                    </div>
                                    <div class="col-md-2 ml-0">
                                        <a href="{{ route('admin.users.export') }}"
                                            class="btn btn-sm btn-block btn-success mb-1 mr-1">Download Excel</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                        id="tablePh2">
                                        <thead class="userstable-head">
                                            <tr class="table-info">
                                                <th class="text-center">Sr No</th>
                                                <th class="text-center">Organization Name</th>
                                                <th class="text-center">Approve Date</th>
                                                <th class="text-center">Valid From</th>
                                                <th class="text-center">Valid Upto</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="userstable-body">
                                            @php
                                            $cnt1 = 1;
                                            @endphp
                                            @foreach($authorisedPersonApprovedRows as $authorisedPersonApprovedRow)
                                            <tr>
                                                <td>{{ $cnt1}}</td>
                                                <td>{{ $authorisedPersonApprovedRow->name}}</td>
                                                <td>{{ date('d/m/Y',
                                                    strtotime($authorisedPersonApprovedRow->approved_at)) }}</td>
                                                <td>{{ date('d/m/Y',
                                                    strtotime($authorisedPersonApprovedRow->approved_at)) }}</td>
                                                @php
                                                $f=0;
                                                @endphp
                                                @foreach($validUptoarray as $key=>$value)
                                                @if($key==$authorisedPersonApprovedRow->auth_person_id)
                                                <td>{{ date('d/m/Y', strtotime($value))}}</td>
                                                @php
                                                $f=1;break;
                                                @endphp
                                                @endif
                                                @endforeach
                                                @if($f==0)
                                                <td>&nbsp;</td>
                                                @endif
                                                <td>
                                                    <a class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                                        data-target="#PendingQrr" href="" title="Show List"
                                                        onclick="display_detail('{{$authorisedPersonApprovedRow->old_contact_person}}','{{$authorisedPersonApprovedRow->old_designation}}','{{$authorisedPersonApprovedRow->old_email}}','{{$authorisedPersonApprovedRow->old_mobile}}','{{$authorisedPersonApprovedRow->new_contact_person}}','{{$authorisedPersonApprovedRow->new_designation}}','{{$authorisedPersonApprovedRow->new_email}}','{{$authorisedPersonApprovedRow->new_mobile}}')"><i
                                                            class="right fas fa-eye"></i></a>
                                                <a href="{{ route('admin.users.authorizechagedetail',$authorisedPersonApprovedRow->auth_person_id) }}"
                                                        class="btn btn-warning btn-sm btn-block"><i
                                                            class="right fas fa-edit"></i></a>

                                                </td>
                                            </tr>
                                            @php
                                            $cnt1++;
                                            @endphp
                                            @endforeach
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
</div>
@endsection

@push('scripts')
@include('admin.users.approvedAuthorizeSignatoryDetail')
@include('admin.users.pendingAuthorizeSignatoryDetail')

<script>
    $(document).ready(function () {
     
        $('#tablePh1').DataTable();
        $('#tablePh2').DataTable();
    });

    function display_detail(old_person_name,old_designation,old_email,old_mobile,new_person_name,new_designation,new_email,new_mobile)
    {
       // alert(old_person_name);
        $('#old_person_name').text(old_person_name);
        $('#old_email').text(old_email);
        $('#old_designation').text(old_designation);
        $('#old_mobile').text(old_mobile);
        $('#current_name').text(new_person_name);
        $('#current_email').text(new_email);
        $('#current_mobile').text(new_mobile);
        $('#current_designation').text(new_designation);

    }

    function display_detail_pending(old_person_name,old_designation,old_email,old_mobile,new_person_name,new_designation,new_email,new_mobile)
    {
        $('#pending_old_person_name').text(old_person_name);
        $('#pending_old_email').text(old_email);
        $('#pending_old_designation').text(old_designation);
        $('#pending_old_mobile').text(old_mobile);
        $('#pending_current_name').text(new_person_name);
        $('#pending_current_email').text(new_email);
        $('#pending_current_mobile').text(new_mobile);
        $('#pending_current_designation').text(new_designation);

    }

</script>
@endpush