@extends('layouts.user.dashboard-master')

@section('title')
QRR Dashboard
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-lg-12">
        <form action={{route('uploads.update',$id)}} id="uploads-create" role="form" method="post"
            class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $app_id }}">
            <input type="hidden" id="qrr" name="qrr" value="{{ $id }}">

            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Upload Documents</b>
                </div>
                <div class="card-body">
                    <span class="help-text"><b>Instructions<b>
                        <br>The photograph should not be taken after reporting date of the period for which QRR is submitted. For e.g. QRR for the June 30, {{$year}}, photograph not older than June 30 {{$year}} should be uploaded.
                        <br>Consistency of location should be maintained in photographs for the QRR for differenct reporting period. Eg. the location of Plant for showing progress of P&M for June {{$year}} should remain same in the QRR for subseqent period.
                        <br>Photograph should be taken with GPS coordinates mode in phone camera.
                        <br>Upload photograph of the Greenfield Project proposed to be installed for the following areas:- 
                    </span>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover uploadTable">
                            <thead>
                                <tr class="table-primary">
                                    {{-- <th class="w-5 text-center">Sec#</th> --}}
                                    <th class="w-40 text-center">Document Name</th>
                                    {{-- <th class="w-5 text-center">Template</th> --}}
                                    <th class="w-30 text-center">Upload</th>
                                    {{-- <th class="w-20 text-center">Remarks</th> --}}
                                </tr>
                            </thead>
                            <tbody class="applicant-uploads">
                                <tr>
                                    <td><b>Photograph of the factory gate covering surroundings</b><sup class="text-danger">*</sup></td>
                                    <td>
                                        <input type="file"   name="filefactgate" id="filefactgate"  
                                            onchange="loadFile1(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                        @if(in_array('22', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '22')
                                        <img id="output1" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="output1" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        

                                        <script>
                                        var loadFile1 = function(event) {
                                            var image = document.getElementById("output1");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                                <tr>
                                    <td><b>Photograph of main Building Block for Plant and Machinery. In case Plant and Machinery is being installed in existing building, the photograph of site location</b><sup class="text-danger">*</sup></td>
                                     <td>
                                         <input type="file"   name="filemainbuild" id="filemainbuild"  
                                        onchange="loadFile2(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                        @if(in_array('23', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '23')
                                        <img id="output2" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="output2" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif

                                        <script>
                                        var loadFile2 = function(event) {
                                            var image = document.getElementById("output2");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                                <tr>
                                    <td> Photograph 1 of area where reactors and main production line is to be installed depciting installation work in progress<sup class="text-danger">*</sup>
                                    </td>
                                    <td>
                                        <input type="file"   name="filereactor" id="filereactor"  
                                        onchange="loadFile3(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                       @if(in_array('24', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '24')
                                        <img id="output3" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="output3" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        <script>
                                        var loadFile3 = function(event) {
                                            var image = document.getElementById("output3");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                                <tr>
                                    <td> Photograph 2 of area where reactors and main production line is to be installed depciting installation work in progress<sup class="text-danger">*</sup>
                                    </td>
                                    <td>
                                        <input type="file"   name="filereactor2" id="filereactor2"  
                                        onchange="loadFilee(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                       @if(in_array('25', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '25')
                                        <img id="outputt" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="outputt" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        <script>
                                        var loadFilee = function(event) {
                                            var image = document.getElementById("outputt");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                                <tr>
                                    <td>Photograph of area where main utilities are proposed to be installed like Boiler, ZLD, Strogage Tank, etc.</td>
                                    <td>
                                        <input type="file"  name="fileutility" id="fileutility"  
                                        onchange="loadFile4(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                        @if(in_array('26', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '26')
                                        <img id="output4" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="output4" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        <script>
                                        var loadFile4 = function(event4) {
                                            var image = document.getElementById("output4");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                                <tr>
                                    <td>Any Additional Document</td>
                                    <td>
                                        <input type="file"   name="fileadditional" id="fileadditional"  
                                        onchange="loadFile5(event)">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;padding : 8px">
                                        @if(in_array('27', $docids))
                                        @foreach($docs as $key=>$doc)
                                        @if($key == '27')
                                        <img id="output5" width="1000" src="{{$doc}}" />                                        
                                        @endif
                                        @endforeach
                                        @else
                                        <img id="output5" width="1000" />
                                        <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        <script>
                                        var loadFile5= function(event5) {
                                            var image = document.getElementById("output5");
                                            image.style.border = "2px solid black";
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            
                                        };
                                        </script></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-info">
                    <b>Upload Documents</b>
                </div>
                <div class="card-body">
                    <p><label>
                            <b>Photograph of the factory gate covering surroundings</b>
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="file"  accept="image/*" name="image" id="file"  
                        onchange="loadFile(event)"></p>
                    <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                    <p><img id="outputt" width="800" /></p>

                    <script>
                    var loadFile = function(event) {
                        var image = document.getElementById('outputt');
                        image.style.border = "5px solid red";
                        image.src = URL.createObjectURL(event.target.files[0]);
                    };
                    </script>
                </div>
            </div> --}}

            <div class="row pb-2">
                <div class="col-md-2 offset-md-0">
                    <a href="{{ route('projectprogress.create',['id' => $app_id, 'qrr' => $id]) }}" 
                        class="btn btn-warning btn-sm form-control form-control-sm">
                        <i class="fas fa-angle-double-left"></i>Project Progress</a>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper" id="submitshareper"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('qrradditionalinfo.edit',$id) }}" 
                    class="btn btn-warning btn-sm form-control form-control-sm">
                    <i class="fas fa-angle-double-right"></i>Approvals Required</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@include('user.partials.js.prevent_multiple_submit')
{!! JsValidator::formRequest('App\Http\Requests\UploadsUpdate','#uploads-create') !!}
@endpush
