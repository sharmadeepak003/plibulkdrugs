@extends('layouts.user.dashboard-master')

@section('title')
Applications Dashboard
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card border-success">
            <div class="card-header bg-gradient-success">
                Sample Application Form
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-5">
                        <h6 class="text-danger">Please view the <b>Sample Application Form</b> before Proceeding.</h6>
                    </div>
                    <div class="col-md-5 justify-content-center">
                        <a href="{{asset('docs/app/Medical Devices_sample.pdf')}}" target="_blank" download="sample.pdf"
                            class="btn btn-sm btn-outline-primary float-centre">Sample Form</a>
                            <a href="{{asset('docs/app/Undertakings_Certificates_MD.pdf')}}" target="_blank" download="Undertakings_Certificates.pdf"
                            class="btn btn-sm btn-outline-primary float-centre ml-4">Undertakings & Certificates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @php $current_round=4; @endphp --}}
@php $current_round=5; @endphp
<div class="row">
    <div class="col-md-12">
        <!-- Current Application-->
        <div class="card border-primary">
            <div class="card-header text-white bg-primary border-primary">
                <h5>Applications</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Target Segment</th>
                                        <th>Application Round</th>
                                        <th>Application No</th>
                                        <th>Status</th>
                                        <th>Creation Date</th>
                                        <th>Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($apps,$prods)}} --}}
                                    <?php //echo "<pre>"; print_r($apps); ?>
                                    <?php //echo "<pre>"; print_r($prods); ?>
                                    <?php //echo "<pre>"; print_r($createdProdApps); ?>
                                    <?php //echo "<pre>"; print_r($createdProdApps); 
                                    $index=1;
                                    $arrAppNum=array();
                                    ?>
                                        {{-- below comment code writte --}}
                                        {{-- @foreach ($getUserEligibleProduct as $item) --}}
                                        {{-- @foreach ($getDataActiveEligibleProduct as $aa) --}}
                                            {{-- @if (in_array($aa->id, explode(',', $item->eligible_product))) --}}

                                            @foreach ($prods as $prod)
                                            @if(!in_array($prod->target_segment_id.'@_@'.$current_round,$createdProdApps))
                                            <tr>
                                                <td class="text-center">{{ $index++ }}</td>
                                                <td>{{ $prod->target_segment }}</td>
                                                <td class="text-center">
                                                    {{ $current_round }}
                                                </td>
                                                <td class="text-center"></td>
                                                <td class="text-center">Not Created</td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                
                                                @if(Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-02-29 23:59:00'))) 
                                                <td>
                                                    <a href="{{ route('applications.create',$prod->target_segment_id) }}"
                                                        class="btn btn-success btn-sm btn-block">Create</a>
                                                </td>
                                                @else
                                                    <td></td>
                                                @endif  
                                            </tr>
                                            @endif
                                        @endforeach
                                            {{-- @endif
                                        @endforeach
                                        @endforeach --}}

                                    
                                    


                                    @foreach ($prods as $prod)
                                        @foreach ($apps as $app)
                                            {{-- @if(($app->target_segment == $prod->target_id && $app->app_category==$prod->prod_category && !in_array($app->id,$arrAppNum)) || ($app->status=='S' && !in_array($app->id,$arrAppNum) && ($prod->id==18 || $prod->id==34 || $prod->id==7 || $prod->id==48))) --}}
                                            @if($app->target_segment == $prod->target_id)    
                                                <tr>
                                                    <td class="text-center">{{ $index++ }}</td>
                                                    <td>{{ $prod->target_segment }}</td>
                                                    <td class="text-center">{{ $app->round}}</td>
                                                    <td class="text-center">{{ $app->app_no }}</td>
                                                    @if($app->status == 'D')
                                                    <td style="background-color: #f3cccc;" class="text-center">Draft</td>
                                                    @elseif($app->status == 'S')
                                                    <td style="background-color: #97f58a;" class="text-center">Submitted</td>
                                                    @elseif($app->status == 'A')
                                                    <td class="text-center">Under Process</td>
                                                    @else
                                                    <td class="text-center">Not Created</td>
                                                    @endif
                                                    <td class="text-center">
                                                        {{ date('d/m/Y',strtotime($app->created_at)) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ date('d/m/Y',strtotime($app->updated_at)) }}
                                                    </td>
                                                    <td>
                                                        {{-- //2022-11-21 23:59:00 --}}
                                                        @if($app->status == 'D')
                                                        {{-- @if(Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-02-29 23:59:00')))  --}}
                                                        <button type="button" class="btn btn-warning btn-sm btn-block"
                                                            data-toggle="modal" data-target="#editModal{{ $app->id }}">
                                                            Edit
                                                        </button>
                                                        @include('user.partials.editModal')
                                                        @endif  
                                                        @elseif($app->status == 'S')
                                                        <a href="{{ route('applications.show',$app->id) }}"
                                                            class="btn btn-warning btn-sm btn-block">View</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php 
                                                $arrAppNum[]=$app->id;
                                                //echo "<pre>"; print_r($prod->target_id.'@_@'.$current_round);
                                                @endphp
                                            {{-- @endif --}}
                                        @endforeach
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endpush
