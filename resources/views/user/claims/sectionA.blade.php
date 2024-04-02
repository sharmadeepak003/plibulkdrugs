@extends('layouts.user.dashboard-master')

@section('title')
    Claim Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="" id="sectionAupload-create" role="form" method="POST"
                class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <input type="hidden" name="app_id" value="{{$apps->app_id}}">
                <input type="hidden" name="claim_id" value="{{$apps->claim_id}}">
                <div class="card border-primary p-0 m-10"> 
                    <div class="card-header bg-gradient-info">
                        <strong>Documents Upload Section</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="card border-primary p-0 m-10">
                                <div class="card-header bg-gradient-info">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover"
                                            id="appExist">
                                            <input type="hidden" value="{{ $apps->app_id }}" name="app_id">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-center" colspan="2">S.No.</th>
                                                    <th class="text-center">Document/ Certificate to be
                                                        Uploaded</th>
                                                    <th class="text-center">Format</th>
                                                    <th class="text-center">File</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sn = 1;
                                                    $sn1 = 1;
                                                    $sn2 = 1;
                                                    $sn3 = 1;
                                                    $sn4 = 1;
                                                    $sn5 = 1;
                                                    $sn6 = 1;
                                                    $sn7 = 1;
                                                @endphp
                                                <tr>
                                                    <th class="table-success">1</th>
                                                    <th class="table-success" colspan="4">General</th>
                                                </tr>

                                                @foreach ($doc_part as $doc)
                                                    @if ($doc->realated_doc_particular_id == 1)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $doc->doc_particular }}</td>
                                                            <td></td>
                                                            <td><input type="file" name="doc_upload[{{ $doc->doc_id }}]"
                                                                    ></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <th  class="table-success">2</th>
                                                    <th  class="table-success" colspan="4">Sales</th>
                                                </tr>
                                                @foreach ($doc_part as $doc)
                                                    @if ($doc->realated_doc_particular_id == 2)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $sn1++ }}</td>
                                                            <td>{{ $doc->doc_particular }}</td>
                                                            <td></td>
                                                            <td><input type="file" name="doc_upload[{{ $doc->doc_id }}]"
                                                                    ></td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                                <tr>
                                                    <th  class="table-success">3</th>
                                                    <th  class="table-success" colspan="4">Regulatory Filings</th>
                                                </tr>
                                                @foreach ($doc_part as $doc)
                                                    @if ($doc->realated_doc_particular_id == 3)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $sn2++ }}</td>
                                                            <td>{{ $doc->doc_particular }}</td>
                                                            <td></td>
                                                            <td><input type="file" name="doc_upload[{{ $doc->doc_id }}]"></td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                                <tr>
                                                    <th  class="table-success">4</th>
                                                    <th  class="table-success" colspan="4">Certificates</th>
                                                </tr>
                                                @foreach ($doc_part as $doc)
                                                    @if ($doc->realated_doc_particular_id == 4)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $sn3++ }}</td>
                                                            <td>{{ $doc->doc_particular }}</td>
                                                            <td>
                                                                @if ($doc->doc_particular=='CE Certificate')
                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for CE certificate.docx') }}" target="_blank" ><i class="fas fa-file-word" ></i> View Formate</a>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            <td><input type="file" name="doc_upload[{{ $doc->doc_id }}]"
                                                                    ></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <th  class="table-success">5</th>
                                                    <th  class="table-success" colspan="4">
                                                        Undertakings/ Declarations from applicant</th>
                                                </tr>
                                                @foreach ($doc_part as $doc)
                                                    @if ($doc->realated_doc_particular_id == 5)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $sn4++ }}</td>
                                                            <td>{{ $doc->doc_particular }}</td>
                                                            <td>
                                                                @if ($doc->doc_particular=='Declaration for usage of machinery [ Clause 4.2.6 ]')
                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for usage of machinery.docx') }}" target="_blank" ><i class="fas fa-file-word" ></i> View Formate</a>
                                                                    </button>
                                                                    

                                                                @elseif ($doc->doc_particular=='Undertaking for no deviation from Eligible and Target Segment goods [ Clause 13.1 (Annexure 6) ]')
                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for no deviation from eligible product.docx') }}" target="_blank"><i class="fas fa-file-word"></i> View Formate</a>
                                                                    </button>
                                                                    

                                                                @elseif ($doc->doc_particular=='Integrity compliance as per Annexure 8 Part A [ Clause 14.76 ]')

                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for integrity compliance.docx') }}" target="_blank"><i class="fas fa-file-word"></i> View Formate</a>
                                                                    </button>

                                                                @elseif ($doc->doc_particular=='Certificate from Company Secretary of the company [ Clause 14.1 (Annexure 6) ]')
                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for certificate from CS.docx') }}" target="_blank"><i class="fas fa-file-word"></i> View Formate</a>
                                                                    </button>

                                                                @elseif ($doc->doc_particular=='Undertaking from the applicant as per format given in Appendix of the Scheme Guidelines [ Clause 17.1 (Annexure 6) ]')
                                                                    <button class="btn btn-warning btn-sm form-control form-control-sm">
                                                                        <a href="{{ asset('docs/claim/format for refund of incentive.docx') }}" target="_blank"><i class="fas fa-file-word"></i> View Formate</a>
                                                                    </button>
                                                                    
                                                                    
                                                                @endif
                                                            </td>
                                                            <td><input type="file" name="doc_upload[{{ $doc->doc_id }}]"
                                                            ></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-md-2 offset-md-0">
                        <a href="{{ route('claimrelated.create',$apps->app_id) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i>Related Party</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="submitshareper" >
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claimdoc.create',['B',$apps->app_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Upload Section B <i
                            class="fa  fa-forward"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimSectionARequest','#sectionAupload-create') !!}
@endpush
