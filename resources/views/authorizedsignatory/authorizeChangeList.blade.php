{{-- @extends('layouts.admin.master') --}}
@extends(Auth::user()->hasRole('Admin') ? 'layouts.admin.master' : 'layouts.user.dashboard-master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('title')
Change Requests
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <h5 class="text-center">Select Change Request</h5>
            </div>
            <div style="display: flex; margin:0.3rem; place-content:center; margin-bottom: 20px">
                <select name="change_type" id="change_type"  class="fyval form-control-sm"
                    style="margin:0.1rem 2rem;">
                    <option value="ALL" @if($change_type=="ALL")selected @endif>All</option>
                    <option value="A"  @if($change_type=="A")selected @endif>Authorised Signatory</option>
                    <option value="C"  @if($change_type=="C")selected @endif>Corporate Addess</option>
                    <option value="R"  @if($change_type=="R")selected @endif>Registered Addess</option>
                </select>
                <button type="button" onclick="send_change_type(document.getElementById('change_type').value)" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
    @if($change_type == 'A')
    <div class="row">
        <div class="col-md-12"><span style="float:right;padding:2px"><a href="{{ route('admin.users.export_data', ['id' =>'1','type'=>$change_type]) }}" class="btn btn-sm btn-warning">Export (Excel) <i class="fa fa-download" aria-hidden="true"></i></a></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="card card-info card-tabs">
                <div class="card-body">
                    <div class="tab-content">
                        <div>
                            <div class="row">
                                <div class="col-md-6 pt-1">
                                    <h5>Authorization Change Request-List</h5>
                                </div>
                            </div>
                            <div class="card border-primary"  style="padding: 5px;">
                                
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh1">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <th class="text-center">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody class="userstable-body">
                                            @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @if($autorisedPersonRow->status == 'S')
                                                {{-- {{dd($autorisedPersonRow->person_id)}} --}}
                                                    <tr>
                                                        <td class="text-center">{{ $cnt1 }}</td>
                                                        <td class="text-center">{{ $autorisedPersonRow->name}}</td>
                                                        <td class="text-center">Authorised Signatory</td>
                                                        <td class="text-center">{{ date('d/m/Y', strtotime($autorisedPersonRow->submitted_at)) }}
                                                        </td>
                                                        <td class="text-center">@if($autorisedPersonRow->status == 'S')
                                                            Pending
                                                            @endif</td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->person_id,'type'=>'A']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endif
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
                            <div class="card border-primary" style="padding: 5px;">
                          
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh2">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="userstable-body">
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                
                                                    @if($autorisedPersonRow->status == 'A' || $autorisedPersonRow->status == 'R') 
                                                    <tr>
                                                    <td class="text-center">{{ $cnt1 }}</td>
                                                    <td class="text-center">{{ $autorisedPersonRow->name}}</td>
                                                    <td class="text-center">Authorised Signatory</td>
                                                    <td class="text-center">{{ date('d/m/Y', strtotime($autorisedPersonRow->approved_at)) }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($autorisedPersonRow->status == 'A')
                                                            Approved
                                                        @else
                                                            Rejected
                                                        @endif
                                                        </td>
                                                    <td class="text-center"><a href="{{ route('admin.users.authorizeChangeView',[$autorisedPersonRow->person_id,'A']) }}"  class="btn btn-success btn-sm btn-block">View</a></td>
                                                    </tr>
                                                    @endif
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
    @elseif($change_type == 'C')
    <div class="row">
        <div class="col-md-12"><span style="float:right;padding:2px"><a href="{{ route('admin.users.export_data', ['id' =>'1','type'=>$change_type]) }}" class="btn btn-sm btn-warning">Export (Excel) <i class="fa fa-download" aria-hidden="true"></i></a></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="card card-info card-tabs">
                <div class="card-body">
                    <div class="tab-content">
                        <div>
                            <div class="row">
                                <div class="col-md-6 pt-1">
                                    <h5>Corporate office Address List</h5>
                                </div>
                            </div>
                            <div class="card border-primary"  style="padding: 5px;">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh1">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <th class="text-center">Action</th>
                                                    @endif
                                                </tr>

                                            </thead>
                                            <tbody class="userstable-body">
                                               
                                            @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @if($autorisedPersonRow->status == 'S')
                                                    <tr>
                                                        <td>{{ $key+1}}</td>
                                                        <td>{{ $autorisedPersonRow->name}}</td>
                                                        <td>Corporate Address</td>
                                                        <td>{{ date('d/m/Y', strtotime($autorisedPersonRow->submitted_at)) }}
                                                        </td>
                                                        <td class="text-center">@if($autorisedPersonRow->status == 'S')
                                                            Pending
                                                            @endif</td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                        <td>
                                                            <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->created_by,'type'=>'C']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endif
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
                                    <h5>History of Corporate Office Address</h5>
                                </div>
                            </div>
                            <div class="card border-primary" style="padding: 5px;">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh2">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="userstable-body">
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                  
                                                    @if($autorisedPersonRow->status == 'A' || $autorisedPersonRow->status == 'R') 
                                                    <tr>
                                                        <td class="text-center">{{ $cnt1 }}</td>
                                                        <td class="text-center">{{ $autorisedPersonRow->name}}</td>
                                                        <td class="text-center">Corporate Address</td>
                                                        <td class="text-center">{{ date('d/m/Y', strtotime($autorisedPersonRow->approved_at)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($autorisedPersonRow->status == 'A')
                                                                Approved
                                                            @else
                                                                Rejected
                                                            @endif
                                                            </td>
                                                           
                                                        <td class="text-center"><a href="{{ route('admin.users.authorizeChangeView',['id'=>$autorisedPersonRow->created_by,'change_type'=>'C']) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a></td>
                                                    </tr>
                                                    @endif
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
    @elseif($change_type == 'R')
    <div class="row">
        <div class="col-md-12"><span style="float:right;padding:2px"><a href="{{ route('admin.users.export_data', ['id' =>'1','type'=>$change_type]) }}" class="btn btn-sm btn-warning">Export (Excel) <i class="fa fa-download" aria-hidden="true"></i></a></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="card card-info card-tabs">
                <div class="card-body">
                    <div class="tab-content">
                        <div>
                            <div class="row">
                                <div class="col-md-6 pt-1">
                                    <h5>Registered Office Address List</h5>
                                </div>
                            </div>
                            <div class="card border-primary"  style="padding: 5px;">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh1">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <th class="text-center">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody class="userstable-body">
                                            @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                           
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @if($autorisedPersonRow->status == 'S')
                                                    <tr>
                                                        <td>{{ $key+1}}</td>
                                                        <td>{{ $autorisedPersonRow->name}}</td>
                                                        <td>Registered Address</td>
                                                        <td>{{ date('d/m/Y', strtotime($autorisedPersonRow->submitted_at)) }}
                                                        </td>
                                                        <td class="text-center">@if($autorisedPersonRow->status == 'S')
                                                            Pending
                                                            @endif</td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                        <td>
                                                            <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->app_id,'type'=>'R']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endif
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
                                    <h5>History of Registered Office Address</h5>
                                </div>
                            </div>
                            <div class="card border-primary" style="padding: 5px;">
                              
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh2">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    <th class="text-center">Action</th>
    
                                                </tr>
    
                                            </thead>
    
                                            <tbody class="userstable-body">
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                  
                                                    @if($autorisedPersonRow->status == 'A' || $autorisedPersonRow->status == 'R') 
                                                    <tr>
                                                        <td class="text-center">{{ $cnt1 }}</td>
                                                        <td class="text-center">{{ $autorisedPersonRow->name}}</td>
                                                        <td class="text-center">Registered Address</td>
                                                        <td class="text-center">{{ date('d/m/Y', strtotime($autorisedPersonRow->approved_at)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($autorisedPersonRow->status == 'A')
                                                                Approved
                                                            @else
                                                                Rejected
                                                            @endif
                                                            </td>
                                                        <td class="text-center"><a href="{{ route('admin.users.authorizeChangeView',['id'=>$autorisedPersonRow->app_id,'change_type'=>'R']) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a></td>
                                                    </tr>
                                                    @endif
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
    @else
    <div class="row">
        <div class="col-md-12"><span style="float:right;padding:2px"><a href="{{ route('admin.users.export_data', ['id' =>'1','type'=>'ALL']) }}" class="btn btn-sm btn-warning">Export (Excel) <i class="fa fa-download" aria-hidden="true"></i></a></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="card card-info card-tabs">
                <div class="card-body">
                    <div class="tab-content">
                        <div>
                            <div class="row">
                                <div class="col-md-6 pt-1">
                                    <h5>Change Request-List</h5>
                                </div>
                            </div>
                            <div class="card border-primary"  style="padding: 5px;">
                               
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh1">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    @if (AUTH::user()->hasRole('Admin'))
                                                    <th class="text-center">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                          
                                            <tbody class="userstable-body">
                                            @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                               
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @if($autorisedPersonRow->status == 'S')
                                                    <tr>
                                                        <td class="text-center">{{ $key+1}}</td>
                                                        <td class="text-center">{{ $autorisedPersonRow->name}}</td>
                                                        <td class="text-center">@if($autorisedPersonRow->change_type == 'C')
                                                                Corporate Address
                                                            @elseif($autorisedPersonRow->change_type == 'R')
                                                                Registered Address
                                                            @elseif($autorisedPersonRow->change_type == 'A')
                                                                Authorised Signatory
                                                            @endif
                                                            </td>
                                                        <td class="text-center">{{ date('d/m/Y', strtotime($autorisedPersonRow->submitted_at)) }}
                                                        </td>
                                                        <td class="text-center">@if($autorisedPersonRow->status == 'S')
                                                            Pending
                                                            @endif</td>
                                                        @if (AUTH::user()->hasRole('Admin'))
                                                        <td>
                                                            @if($autorisedPersonRow->change_type == 'C')
                                                                <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->created_by,'type'=>'C']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                            @elseif($autorisedPersonRow->change_type == 'R')
                                                            
                                                                <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->person_id,'type'=>'R']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                            @elseif($autorisedPersonRow->change_type == 'A')
                                                            <a href="{{ route('admin.users.authorizechangedetail',['person_id'=>$autorisedPersonRow->person_id,'type'=>'A']) }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a>
                                                            @endif
                                                            <!-- <a href="{{ route('admin.authoriseSignatorylist.admin_dash','ALL') }}"
                                                                class="btn btn-warning btn-sm btn-block"><i
                                                                    class="right fas fa-edit"></i></a> -->
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endif
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
                                    <h5>Change History</h5>
                                </div>
                            </div>
                            <div class="card border-primary" style="padding: 5px;">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover usersTable"
                                            id="tablePh2">
                                            <thead class="userstable-head">
                                                <tr class="table-info">
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Applicant's Name</th>
                                                    <th class="text-center">Type of Request</th>
                                                    <th class="text-center">Request Date</th>
                                                    <th class="text-center">Status of Request</th>
                                                    <th class="text-center">Action</th>
                                                   
                                                </tr>

                                            </thead>

                                            <tbody class="userstable-body">
                                                @php
                                                $cnt1 = 1;
                                                @endphp
                                                @foreach($authorisedPersonRows as $key => $autorisedPersonRow)
                                                    @if($autorisedPersonRow->status == 'A' || $autorisedPersonRow->status == 'R') 
                                                    <tr>
                                                    <td>{{ $cnt1 }}</td>
                                                    <td>{{ $autorisedPersonRow->name}}</td>
                                                    <td class="text-center">@if($autorisedPersonRow->change_type == 'C')
                                                        Corporate Address
                                                    @elseif($autorisedPersonRow->change_type == 'R')
                                                        Registered Address
                                                    @elseif($autorisedPersonRow->change_type == 'A')
                                                        Authorised Signatory
                                                    @endif
                                                    </td>
                                                    <td>{{ date('d/m/Y', strtotime($autorisedPersonRow->approved_at)) }}
                                                    </td>
                                                    <td>
                                                        @if($autorisedPersonRow->status == 'A')
                                                            Approved
                                                        @else
                                                            Rejected
                                                        @endif
                                                        </td>
                                                    <td><a href="{{ route('admin.users.authorizeChangeView',['id'=>$autorisedPersonRow->person_id,'change_type'=>$autorisedPersonRow->change_type]) }}"
                                                        class="btn btn-success btn-sm btn-block">View</a></td>
                                                        
                                                    </tr>
                                                    @endif
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
    @endif
@endsection

@push('scripts')
<script>
    
    $(document).ready(function () {
      /*  var t1 = $('#tablePh1').DataTable({


        });



        var t2 = $('#tablePh2').DataTable({


        });
    */
    $('#tablePh1').DataTable(

    /*   {
            dom: 'Bfrtip',
            buttons: [
                'csv'
            ]
        }*/
    );
    $('#tablePh2').DataTable(

    /*  {
            dom: 'Bfrtip',
            buttons: [
                'csv'
            ]
        }
        */
    );


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
    function send_change_type(a) {
        // alert(a);
            if(a == 'ALL'){
                // alert(window.location.href);
                var b= window.location.href = '' + a;
            }else{
                var b= window.location.href = '' + a;
            }
        }

</script>
@endpush