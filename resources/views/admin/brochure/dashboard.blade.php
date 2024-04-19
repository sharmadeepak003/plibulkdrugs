@extends('layouts.admin.master')
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
            <div class="table-responsive">
               <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                  <thead class="appstable-head">
                     <tr class="table-info">
                        <th class="text-center" style="width: 6%">Sr. No.</th>
                        <th class="text-center" style="width: 30%">Organization Name</th>
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
                        <td class="text-center">{{ $app->rno }}</td>
                        <td>{{ $app->name }}</td>
                        <td class="text-center">TS-{{  $app->tar_seg_no }}</td>
                        <td class="text-center">{{ $app->app_no }}</td>
                        <th class="text-center">{{  $app->round }}</th>
                        <td class="text-center">
                           @if($app->status == 'S')
                           <a href="{{ route('admin.admin_brochure.brochure_list',$app->id) }}"
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
<div class="card border-primary">
   <div class="card-body">
   Note:<br>
   TS-1 = A. Cancer care / Radiotherapy Medical / Devices <br>
   TS-2 = B. Radiology & Imaging Medical Devices (both ionizing & non-ionizing radiation products) and Nuclear Imaging Devices <br>
   TS-3 = C. Anesthetics & Cardio-Respiratory Medical Devices including Catheters of Cardio Respiratory Category & Renal Care Medical Devices <br>
   TS-4 = D. All Implants including implantable electronic Devices 
   </div>
</div>
<div class="row py-2">
</div>
@endsection
@push('scripts')
@include('admin.partials.applicationfilter')
@endpush