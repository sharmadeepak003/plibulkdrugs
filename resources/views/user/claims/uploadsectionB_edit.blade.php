@extends('layouts.user.dashboard-master')

@section('title')
    Claim: Document Upload
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"] {
            padding: 1px;
        }

        #loader-overlay {

            display: none;

            position: fixed;

            top: 0;

            left: 0;

            width: 100%;

            height: 100%;

            background-color: rgba(0, 0, 0, 0.7);
            /* semi-transparent black */

            z-index: 9999;
            /* Ensure the loader is above other content */

        }



        .loader {

            position: absolute;

            top: 50%;

            left: 50%;

            transform: translate(-50%, -50%);

            border: 4px solid #f3f3f3;
            /* Light grey */

            border-top: 4px solid #3498db;
            /* Blue */

            border-radius: 50%;

            width: 50px;

            height: 50px;

            animation: spin 1s linear infinite;
            /* Animation */

        }



        @keyframes spin {

            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }

        }
    </style>
@endpush

@section('content')
    <div id="loader-overlay">

        <div class="loader"></div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimdocumentupload.update', 'B') }}" id="application-create" role="form"
                method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                @csrf
                @method('patch')
                <input type="hidden" name="app_id" value="{{ $apps->app_id }}">
                <input type="hidden" name="claim_id" value="{{ $apps->claim_id }}">



                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-info">
                        <strong>Certificates</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="card border-primary p-0 m-10">
                                <div class="card-header bg-gradient-info">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" id="appExist">
                                            <thead>
                                                <th>S.No</th>
                                                <th></th>
                                                <th>Download</th>
                                                <th colspan="2" class="text-center">PDF Upload</th>
                                                <th>Download</th>
                                                <th colspan="2" class="text-center">Excel Upload</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Statutory Auditor's Certificate Annexure 1 to 4</td>
                                                    <td>
                                                        <a
                                                            href="{{ asset('docs/doc_claim/PLI_BD_SA_Certificate_Annexure_i_to_vi.pdf') }}">
                                                            Format download</a>
                                                    </td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1012) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1012) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">

                                                            <td>
                                                                <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="income_tx"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1017) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1017) --}}
                                                            <td></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>

                                                
                                                <tr>
                                                    <td>2</td>
                                                    <td>Annexure 5 of Statutory Auditor's Certificate (Sales Register)</td>
                                                    <td>

                                                    </td>

                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1013) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1013) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="companies_act">
                                                            </td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach

                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                        {{-- @if ($doc->doc_id == 1018) --}}
                                                        @foreach ($doc_data->where('doc_id',1018) as $key => $doc)
                                                            <td><a
                                                                    href="{{ asset('docs/doc_claim/PLIBD_Sales_Register.csv') }}">Format
                                                                    download</a></td>
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    class="fileInput" filename="PLIBD_Sales_Register"></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Annexure 6 of SA certifcate (Capex Register)</td>
                                                    <td>

                                                    </td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1014) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1014) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_return"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1019) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1019) --}}
                                                            <td><a
                                                                    href="{{ asset('docs/doc_claim/PLIBD_Capex_Register.csv') }}">Format
                                                                    download</a></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    class="fileInput" filename="PLIBD_Capex_Register"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>CE Certificate</td>
                                                    <td></td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1015) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1015) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1020) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1020) --}}
                                                            <td></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Certificate from Statutory Auditor for Intellectual Property Rights
                                                        (IPRs), patents and copyrights.</td>
                                                    <td></td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1016) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1016) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    {{-- @foreach ($doc_data as $key12 => $doc)
                                                    @if ($doc->doc_id == 1021)
                                                    <input type="hidden" value="{{$doc->upload_id}}" name=upload_doc[{{$key}}][id]>
                                                    <td><input type="file" name="upload_doc[{{$key}}][doc]" ></td>
                                                    <td><a class="btn btn-success btn-sm" href="{{ route('doc.down',$doc->upload_id) }}">View</a></td>
                                                    @endif
                                                    @endforeach --}}
                                                    @php
                                                        $counter1 = 0;
                                                        $counter2 = 0;
                                                    @endphp
                                                    {{-- 
                                                    @foreach ($doc_data as $doc)
                                                        @if ($doc->doc_id == 1016)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $counter1 }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $counter1 }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                            @php $counter1++; @endphp
                                                        @endif
                                                    @endforeach --}}

                                                    {{-- @foreach ($doc_data as $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1021) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1021) --}}
                                                            <td></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                            @php $key++; @endphp
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Certificate from Statutory Auditor or Independent Chartered
                                                        Accountant for Intellectual Property Rights (IPRs), patents and
                                                        copyrights.</td>
                                                    <td></td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                        {{-- @if ($doc->doc_id == 1028) --}}
                                                        @foreach ($doc_data->where('doc_id',1028) as $key => $doc)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1029) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1029) --}}
                                                            <td></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Certificate from Cost Accountant.</td>
                                                    <td></td>
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1030) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1030) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                    {{-- @foreach ($doc_data as $key => $doc) --}}
                                                    @foreach ($doc_data->where('doc_id',1031) as $key => $doc)
                                                        {{-- @if ($doc->doc_id == 1031) --}}
                                                            <td></td>

                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Statutory Auditor's Certificate</td>
                                                    
                                                    <td>
                                                        <a
                                                            href="{{ asset('docs/doc_claim/PLI_BD_SA_Certificate_for_Incentive_Claim.pdf') }}">
                                                            Format download</a>
                                                    </td>

                                                  
                                                    @foreach ($doc_data->where('doc_id',5010) as $key => $doc)
                                                      
                                                        {{-- @if ($doc->doc_id == 5010) --}}
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td> <input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]" class="filePdfInput" filename="PLI_BD_SA_Certificate_for_Incentive_Claim"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View </a>
                                                            </td>
                                                        {{-- @endif --}}
                                                    @endforeach

                                                    @if (!$doc_data->contains('doc_id', 5010))
                                                        <td> <input type="file"
                                                                name="upload_doc[{{ $key+1}}][doc]"
                                                                class="filePdfInput"
                                                                filename="PLI_BD_SA_Certificate_for_Incentive_Claim"></td>
                                                        
                                                    @endif
                                                   
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-info">
                        <strong>Undertakings / Declarations from applicant</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="card border-primary p-0 m-10">
                                <div class="card-header bg-gradient-info">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" id="appExist">
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Declaration for usage of machinery as per Clause 6.2.3 of the Scheme
                                                        Guidelines </td>
                                                    <td><a
                                                            href="{{ asset('docs/doc_claim/Declaration for usage of machinery.docx') }}">Format
                                                            download</a></td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1022)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>No Deviation in Eligible Product(s) as per Point 9 (Annexure 4) of
                                                        the Scheme Guidelines</td>
                                                    <td><a
                                                            href="{{ asset('docs/doc_claim/No Deviation in Eligible Product(s).docx') }}">Format
                                                            download</a></td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1023)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Integrity compliance as per Annexure 11 Part A & Part B refer Point
                                                        13.1 (Annexure 4A) of the Scheme Guidelines</td>
                                                    <td><a
                                                            href="{{ asset('docs/doc_claim/Integrity compliance as per Annexure 11 Part A & Part B.docx') }}">Format
                                                            download</a></td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1024)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Certificate from Company Secretary of the company refer Point 10
                                                        (Annexure 4) of the Scheme Guidelines </td>
                                                    <td><a
                                                            href="{{ asset('docs/doc_claim/Certificate from Company Secretary of the company.docx') }}">Format
                                                            download</a></td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1025)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Undertaking from the applicant for refund of incentive as per format
                                                        given in Appendix 4A of the Scheme Guidelines refer Point 13.2
                                                        (Annexure 4) of the Scheme Guidelines </td>
                                                    <td><a
                                                            href="{{ asset('docs/doc_claim/Undertaking from the applicant for refund of incentive as per format given in Appendix 4A of the Scheme.docx') }}">Format
                                                            download</a></td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1026)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1021)
                                                            <td>6</td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>Board Resolution to effect that applicant agrees by the
                                                                applicant agrees by the terms and condition as laid down in
                                                                PLI Scheme refer point 13.3 (Annexure 4) of the Scheme
                                                                Guidelines </td>
                                                            <td><a
                                                                    href="{{ asset('docs/doc_claim/Board Resolution to effect that applicant agrees by the applicant agrees by the terms and condition as laid down.docx') }}">Format
                                                                    download</a></td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div>Note: One Management Representation Letter shall be taken post verification of claim
                                    but before submission of report to DoP.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row pb-2">
                    <div class="col-md-2 offset-md-0">

                        <a href="{{ route('claimdocumentupload.create', ['A', $apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i>Upload Section A</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="pre_event">
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claimdocumentupload.create', ['C', $apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Upload Section C
                            <i class="fa  fa-forward"></i></a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add').click(function() {
                i++;
                $('#related').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                    '</td> <td class="text-center"><input type="date" name=" GenCompDoc[' + (sn - 1) +
                    '][period]" id="name" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="date" name=" GenCompDoc[' +
                    (sn - 1) +
                    '][from_date]" id="from_date" class="form-control form-control-sm name_list1"></td> <td class="text-center"><input type="date" name=" GenCompDoc[' +
                    (sn - 1) +
                    '][to_date]" id="to_date" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="file" name=" GenCompDoc[' +
                    (sn - 1) +
                    '][doc]" id="to_date" class="form-control form-control-sm name_list1"></td><td></td><td class="text-center"><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            $('#problem').on('change', function() {
                $('.display').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });
        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("pre_event");
                btn.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 20));
            });
        });
    </script>

    {{-- azeem file format check --}}
    <script>
        $('.fileInput').change(function(event) {

            var file = event.target.files[0];

            var formData = new FormData();

            formData.append('file', file);

            var filename = $(this).attr('filename');

            formData.append('filename', filename);

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': csrfToken

                }

            });

            $.ajax({
                url: '/upload-format',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loader-overlay').show();
                },

                success: function(response) {

                    $('#loader-overlay').hide();
                    if (response.code.trim() == "false") {
                        swal({
                            icon: 'error',
                            text: response.message,
                        });
                        $('.fileInput').val('');

                    }

                },

                error: function(xhr, status, error) {

                    $('#message').text("Error uploading file");

                }

            });

        });
    </script>

    {{-- SA Certificate --}}

    <script>
        $('.filePdfInput').change(function(event) {

            var file = event.target.files[0];
            if (file) {
                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase(); // Get the file extension

                if (fileExtension !== 'pdf') {
                    alert('Please select a PDF file.');
                    $('.filePdfInput').val('');
                    // Clear the input field if the file is not a PDF
                    document.getElementById('your-input-element-id').value = '';
                }
            }
            var formData = new FormData();
            formData.append('file', file);
            var filename = $(this).attr('filename');
            formData.append('filename', filename);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $.ajax({
                url: '/upload-pdf-format',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loader-overlay').show();
                },
                success: function(response) {
                    var responseObject = JSON.parse(response);
                    $('#loader-overlay').hide();
                    if (responseObject.status != 200) {
                        swal({
                            icon: 'error',
                            text: responseObject.result,
                        });

                        $('.filePdfInput').val('');

                    }
                },
                error: function(xhr, status, error) {
                    $('#message').text("Error uploading file");
                }

            });

        });
    </script>

    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadBRequest', '#application-create') !!}
    @endpush
@endpush
