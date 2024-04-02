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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimdocumentupload.update', 'B') }}" id="application-create" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
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
                                                <th colspan="2">PDF Upload</th>
                                                <th colspan="2">Excel Upload</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Statutory Auditor's Certificate (with Annexure 1 to 4)</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1012)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="income_tx"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1017)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                    <td>Annexure 5 of Statutory Auditor's Certificate (Sales Register)</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1013)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="companies_act"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1018)
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Annexure 6 of SA certifcate (Capex Register)</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1014)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_return"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1019)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                    <td>CE Certificate</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1015)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1020)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                    <td>Certificate from Statutory Auditor for Intellectual Property Rights
                                                        (IPRs), patents and copyrights.</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1016)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
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

                                                    @foreach ($doc_data as $doc)
                                                        @if ($doc->doc_id == 1021)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $counter2 }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $counter2 }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                            @php $counter2++; @endphp
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Certificate from Statutory Auditor or Independent Chartered
                                                        Accountant for Intellectual Property Rights (IPRs), patents and
                                                        copyrights.</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1028)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1029)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Certificate from Cost Accountant.</td>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1030)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1031)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                                name=upload_doc[{{ $key }}][id]>
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
                                                                name=upload_doc[{{ $key }}][id]>
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
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadBRequest', '#application-create') !!}
    @endpush
@endpush
