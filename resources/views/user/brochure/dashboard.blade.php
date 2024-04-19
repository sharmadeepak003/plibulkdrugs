@extends('layouts.user.dashboard-master')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush
@section('title')
Brochure Doucment - Dashboard
@endsection
@section('content')
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
   {{-- <div class="col-md-1 offset-md-10">
      <span class="text-danger">Export: </span>
   </div>
   <div class="col-md-1">
      <a href="{{ route('admin.applications.export') }}"
         class="btn btn-sm btn-block btn-primary text-white">Excel</a>
   </div> --}}
</div>
<div class="row py-2">
   <div class="col-md-12">
      <div class="card border-primary">
         <div class="card-body">
            {{-- <div class="row">
               <div class="col-md-2 offset-md-4 ml-2">
                  <span class="text-danger">Please Select: </span>
               </div>
               <div class="col-md-3">
                  <label for="filter" class="text-danger">Target Segment</label>
                  <!-- <a href="{{ route('admin.applications.export') }}"
                     class="btn btn-sm btn-block btn-primary text-white">Excel</a> -->
                  <select class="custom-select" id="targetSegment" name="targetSegment" onSelect="getProducts()">
                     <option>--Target Segment--</option>
                     <option value="999">ALL</option>
                     @foreach ($eligible_pro as $eligible)
                     <option value="{{ $eligible->target_id }}">{{ $eligible->target_segment }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-3">
                  <label for="filter" class="text-danger">Product</label>
                  <!-- <a href="{{ route('admin.applications.export') }}"
                     class="btn btn-sm btn-block btn-primary text-white">Excel</a> -->
                  <select disabled class="custom-select" id="productName" name="productName" onselect="getProducts()">
                     <option>--Products---</option>
                  </select>
               </div>
            </div>
            <div id="loading" style="display:none; margin-left: 45%;" >
               <p> <b>Please Wait .....</b> </p>
               <img src="{{ asset('images/preloader.gif') }}" class="rounded t-photo"> 
            </div> --}}
            <div class="table-responsive">
               <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                  <thead class="appstable-head">
                     <tr class="table-info">
                        <th class="text-center">Sr No</th>
                        <th class="text-center">Organization Name</th>
                        <th class="text-center">Target Segment</th>
                        <th class="text-center">Application No</th>
                        <th class="text-center">Round</th>
                        <th class="text-center">Document</th>
                     </tr>
                     {{-- 
                     <tr class="table-info">
                        <th>View</th>
                        <th>Print</th>
                     </tr>
                     --}}
                  </thead>
                  <tbody class="appstable-body">
                     @foreach($apps as $app)
                     <tr>
                        <td>{{ $app->rno }}</td>
                        <td>{{ $app->name }}</td>
                        <td>{{  $app->target_segment }}</td>
                        <td>{{ $app->app_no }}</td>
                        <th class="text-center">{{  $app->round }}</th>
                        <td class="text-center">
                           @if($app->status == 'S')
                           <a href="{{ route('app_brochure.brochure_list',$app->id) }}"
                               class="btn btn-info  text-white btn-sm btn-block" >
                               <i class="far fa-file-alt"></i></a>
                            @endif
                       </td>

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
@include('user.partials.applicationfilter')
@endpush