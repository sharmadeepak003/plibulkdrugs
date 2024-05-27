@extends('layouts.user.dashboard-master')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
<style>
    #table{
        width:inherit !important;
    }
</style>
@endpush


@section('title')
Brochure - Document
@endsection

@section('content')
<div class="row">
    <div class="col-md-0 offset-md-1">
        <span  style="color:#DC3545;font-size:15px"> <b> Application Name : </b> </span>
    </div>
    {{-- <div class="col-md-0" style="font-size:15px">&nbsp;{{$apps->user->name}}</div> --}}
    <div class="col-md-0" style="font-size:15px">&nbsp;{{Auth::user()->name}}</div>
</div>
<div class="row">
    <div class="col-md-0 offset-md-1">
        <span style="color:#DC3545;font-size:15px"> <b> Application Number : </b></span>
    </div>
    <div class="col-md-0" style="font-size:15px">&nbsp;{{$apps->app_no}}</div>
    {{-- {{dd($apps->id)}} --}}
</div>
<div class="row">
    <div class="col-md-0 offset-md-1">
        <span  style="color:#DC3545;font-size:15px"> <b> Target Segment : </b> </span>
    </div>
    {{-- <div class="col-md-0" style="font-size:15px">{{get_target_segment()[$apps->target_segment]}}</div> --}}
    <div class="col-md-0" style="font-size:15px">&nbsp;{{$getEligibleProdDetails->target_segment}}</div>


</div>
{{-- <div class="row">
    <div class="col-md-12 float-right">
        <span style="color:#DC3545;font-size:15px">
            <a href="{{route('admin.admin_brochure.create',$apps->id)}}"
            class="btn btn-info text-white btn-sm float-right  p-2">Upload Document</a></span>
    </div>
</div> --}}

<form action={{ route('app_brochure.store') }} id="brochure-create" role="form" method="post"
    class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
    @csrf
    <input type="hidden" name="app_id" value="{{ $apps->id}}">
    <input type="hidden" name="target_seg_id" value="{{ $getEligibleProdDetails->target_segment_id}}">
    <div class="row pt-2">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    Documents Upload
                </div>
                <div class="card-body py-0 px-0">
                    <div class="table-responsive p-0 m-0">
                        <table class="table table-sm table-bordered table-hover uploadTable">
                            <thead>
                                <tr class="table-primary">
                                    <tr class="table-primary">
                                        <th class="text-center" style="width: 25%">Product Name &nbsp;<span style="color: red">*</span></th>
                                        {{-- <th class="text-center" style="width: 15%">Website Link</th> --}}
                                      
                                        <th class="text-center" style="width: 20%">Upload Product Brochure &nbsp;<span style="color: red">*</span></th>
                                        <th class="text-center" style="width: 20%">Upload Tech. Comm. Specs.</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    <select id="product_id" name="product_id" class="form-control form-control-sm">
                                    <option value="" selected="selected">Please choose..</option>
                                   
                                    @foreach ($approved_prods as $pval)
                                        {{-- @if(!in_array($pval->p_id,$arr_brochure_product_id)) --}}
                                            <option value="{{$pval->id}}">{{ $pval->product }}</option>
                                        {{-- @endif     --}}
                                    @endforeach 
                                </select></td>
                                {{-- <td>
                                    <input type="text" class="form-control form-control-sm valid"  id="websitelink" name="websitelink">
                                </td> --}}
                               
                                <td><input type="file" id="doc_type" name="doc_type"  class="form-control form-control-sm valid"></td>
                                <td><input type="file" id="broch_other_doc" name="broch_other_doc"  class="form-control form-control-sm valid"></td>
                            </tr>
                        </table>
                    </div>
                </div>                
            </div>
        </div>  
    </div>
    <div class="row">
        <div class="col-md-2 offset-md-5">
            <button type="submit" id="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"><i class="fas fa-save"></i>
                Save </button>
        </div> 
    </div>
</form>    
<div class="row pt-2">
    <div class="col-md-12">
       <div class="card border-primary">
            <div class="card-header bg-gradient-info">
                Documents
            </div>
            <div class="card-body py-0 px-0">
                <div class="table-responsive p-0 m-0">
                    <table class="table table-sm table-bordered table-hover uploadTable">
                        <thead>
                            <tr class="table-primary">
                                <th class="w-20 text-center">Product Name</th>
                                {{-- <th class="w-15 text-center">Website Link</th> --}}
                                <th class="w-15 text-center">Date & Time</th>
                                <th class="w-5 text-center">Brochure</th>
                                <th class="w-5 text-center">Techno Commercial</th>
                                <th class="w-5 text-center" colspan="2">Action</th>
                                {{-- <th class="w-5 text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody class="applicant-uploads">
                            @foreach($contents as $key=>$content)
                            <tr>
                                <td class="text-center">{{$content->product}}</td>
                                {{-- <td class="text-center">{{$content->websitelink}}</td> --}}
                                <td class="text-center">{{$content->created_at}}</td>
                                
                                <td class="text-center"> <a href="{{ route('app_brochure.bro_down', encrypt($content->id)) }}" 
                                    class="btn btn-success btn-sm float-centre">
                                    Download</a>
                                </td>
                                <td class="text-center"> 
                                    @if(isset($content->other_uploaded_file))
                                        <a href="{{ route('app_brochure.other_broch_down', encrypt($content->id)) }}" 
                                        class="btn btn-success btn-sm float-centre">
                                        Download</a>
                                    @endif
                                </td>
                                <td class="text-center"> <a href="{{ route('app_brochure.edit_document_listing', ['app_id' => $apps->id,'id' =>$content->id]) }}" 
                                    class="btn btn-warning btn-sm float-centre">
                                    Edit</a>
                                </td>
                                
                                <td class="text-center"> 
                                     <a href="{{ route('app_brochure.delete',[encrypt($content->id) , encrypt($content->app_id)])}}" class="form-control-sm btn-sm btn btn-danger" onclick="return confirm('Do you want deleted brochure')">Delete</a>
                                </td>
                                {{-- <td class="text-center"> 
                                    <a href="{{ route('admin.admin_brochure.delete',[encrypt($content->id) , encrypt($content->app_id)])}}" class="form-control-sm btn-sm btn btn-danger" onclick="return confirm('Do you want deleted brochure')">Delete</a>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pb-2">
    <div class="col-md-2 offset-md-0">
        <a href="{{ route('app_brochure.index') }} "
            class="btn btn-info text-white btn-sm form-control form-control-sm">
            <i class="fas fa-angle-double-left"></i>Back </a>
    </div>
</div>
@endsection
@push('scripts')
@include('user.partials.js.prevent-multiple-submit-js')    
{!! JsValidator::formRequest('App\Http\Requests\User\BrochureDocUploads','#brochure-create') !!}
@endpush