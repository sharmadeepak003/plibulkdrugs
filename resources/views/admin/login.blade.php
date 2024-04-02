@extends('layouts.admin.master')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
<style>
    #table{
        width:inherit !important;
    }
</style>
@endpush


@section('title')
Admin List - Dashboard
@endsection

@section('content')


<div class="row">
    @if (AUTH::user()->hasRole('Admin'))
    <div class="col-md-12 mb-2 float-right">
        <span style="color:#DC3545;font-size:20px">
            <a href="{{route('admin.login.create')}}"
            class="btn btn-info text-white btn-sm float-right  p-2">Create Login Id</a></span>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12">
       <div class="card border-primary">
            <div class="card-header bg-gradient-info">
                Admin/Admin Ministry List
            </div>
            <div class="card-body py-0 px-0">
                <div class="table-responsive p-0 m-0">
                    <table class="table table-sm table-bordered table-hover uploadTable">
                        <thead>
                            <tr class="table-primary">
                                <th class="w-45 text-center">S.No</th>
                                <th class="w-45 text-center">Name</th>
                                <th class="w-10 text-center">Email</th>
                                <th class="w-30 text-center">Mobile</th>
                                <th class="w-5 text-center">Rights</th>
                                <th class="w-5 text-center">Active/Deactive</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admin_list as $k=>$val)
                            <tr>
                                <td class="text-center">{{$k+1}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->email}}</td>
                                <td>{{$val->mobile}}</td>
                                <!-- <td>@if($val->role_id == 2) Admin @else Admin Ministry @endif</td> -->
                              <td>@if($val->role_id == 2)  Modification + View @else View Only @endif</td>
                                <td class="text-center"><a href="" onclick="UpdateStatus($(this).attr('id'),$(this).attr('data-val'))" id="{{$val->isapproved}}" data-val ="{{$val->id}}"  @if($val->isapproved == 'Y') class="btn btn-sm btn-success" @else class="btn btn-sm btn-danger" @endif>
                                @if($val->isapproved == 'Y') Active @else Deactive @endif</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function UpdateStatus(status,id){
        // alert(status,id)
        jQuery.ajax({
                type: "GET",
                url: '/admin/login/'+status+'/'+id,
            });  
    } 
</script>
@endpush