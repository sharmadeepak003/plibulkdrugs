@extends('layouts.master')
@push('styles')
<link href="{{ asset('css/app/preview.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}"> --}}
@endpush

<style>
    div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
}
div.dataTables_wrapper div.dataTables_filter label {
    font-weight: normal;
    white-space: nowrap;
    text-align: left;
}
.fa, .fas {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
}
div.dataTables_wrapper div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
}
div.dataTables_wrapper div.dataTables_info {
    padding-top: 0.85em;
}
div.dataTables_wrapper div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 2px 0;
    white-space: nowrap;
    justify-content: flex-end;
}
div.dataTables_wrapper div.dataTables_length select {
    width: auto;
    display: inline-block;
}
</style>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center my-3">
        <div class="col-md-9">
            <form action="{{ route('brochure')}}" id="regForm" role="form" method="POST">
                @csrf
                <input type="hidden" name="target_segment_id" value="{{$tar_seg_id}}">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <tr>
                        <th style="width: 15%;font-size:15px;">Product</th>
                        <td style="width: 30%;">
                            <select class="custom-select" id="product_id"  name="product_id" required>
                                <option value="" selected disabled>Select</option>
                                @foreach ($approved_prods as $pval)
                                    <option value="{{$pval->id}}" @if(isset($intProductId)) @if($intProductId==$pval->id) selected @endif @endif>{{ $pval->product }}</option>
                                @endforeach
                            </select>
                        </td>
                        <th style="width: 15%;font-size:15px;">Company Name</th>
                        <td style="width: 30%;">
                            <select name="company_id" id="company_id" class="custom-select">
                                <option value="">Select</option>
                                    @foreach ($applicant_com as $cval)
                                        <option value="{{$cval->id}}" @if(isset($intCompanyId)) @if($intCompanyId==$cval->id) selected @endif @endif>{{CompanyName($cval->id)}}</option>
                                    @endforeach   
                                
                            </select>
                        </td>
                        <td><button value="Filter" class="btn btn-primary">Filter</button></td>
                        <td><a class="btn btn-primary" href="{{ route('brochure_doc',[0]) }}">Back</a></td>
                    </tr>
                </table>    
            </form>
        </div>



        <div class="col-md-9 pt-3">
            <div class="card card-info card-tabs">
                <div class="card-header pt-1 text-bold">
                    <ul class="nav nav-tabs" role="tablist">
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="appTab" data-toggle="pill" href="#AllBrochureData" role="tab"
                                aria-controls="appTabContent" aria-selected="true">All</a>
                        </li> --}}
                        <div style="height: 35px; clear:both;"></div>
            
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="AllBrochureData" role="tabpanel"
                            aria-labelledby="appTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-body p-0">
                                   
                                    <div class="card-body bg-gradient-info p-2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-bordered table-hover dataTable no-footer" id="apps" role="grid" aria-describedby="apps_info">
                                                <thead class="appstable-head">
                                                    <tr class="table-info" role="row">  
                                                        <th style="width:7%; font-size:17px">Sr No.</th>
                                                        <th style="font-size:17px">Product Name</th>
                                                        <th style="width:50%; font-size:17px">Company Name</th>
                                                        <th class="text-center" style="font-size:17px">Brochure</th>
                                                    </tr>
                                                </thead>
                                                @php $indexCount=1; @endphp
                                                <tbody class="appstable-body">
                                                    @foreach ($brochure_prod_data as $key=>$val)
                                                        <tr>
                                                        <td style="font-size:14px">{{$indexCount++}}</td>
                                                       
                                                        <td style="font-size:14px">{{$val->product}}</td>
                                                     
                                                        <td style="font-size:14px">{{$val->name}} {{$val->app_id}} {{$val->product_id}}</td>
                                                        
                                                        <td style="font-size:14px" class="text-center">
                                                            @if(isset($arr_brochure_product[$val->app_id.'@_@'.$val->product_id]))
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm btn-block"
                                                                data-toggle="modal"
                                                                data-target="#editModal{{ $val->app_id.'a_a'.$val->product_id }}">
                                                                View
                                                            </button>
                                                            @include(
                                                                'landing.partials.modal.brochureVersionModal'
                                                            )
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

                        

                        
                    </div>
                </div>     
            </div>
        </div>  
                    
        
    </div>
</div>
@endsection

@push('scripts')
@include('landing.partials.applicationfilter')
@include('landing.partials.js.brochure-product-details') 
@endpush

