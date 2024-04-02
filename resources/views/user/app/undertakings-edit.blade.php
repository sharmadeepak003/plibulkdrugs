@extends('layouts.user.dashboard-master')

@section('title')
Section 4 - Undertakings and Certificates
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
{{-- Error Messages --}}
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

{{-- ContentStarts --}}
<div class="row">
    <div class="col-lg-12">
        <form action={{ route('undertakings.update',$appMast->id) }} id="form-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" name="rnd_flag" value="{{ $appMast->financials->rnd_achv ?? 'N' }}">

            {{-- Document Upload --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            4.1 Undertakings and Certificates
                        </div>
                        <div class="card-body py-0 px-0">
                            <div class="table-responsive p-0 m-0">
                                <span class="help-text">
                                    <ol type="1">
                                        <li>Please click on the file attached under the column "Template" for editable format of the certificate/ undertaking and attach original copy with application duly singed by prescribed signatory.
                                        </li>
                                        <li>Please attach a copy with application, attested by Authorised Signatory. Tick the document in Status Box and give remarks for any variation or reason for not available.
                                        </li>
                                    </ol>
                                </span>
                                <table class="table table-sm table-bordered table-hover uploadTable">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="w-35 text-center">Document</th>
                                            <th class="w-10 text-center">Template</th>
                                            <th class="w-20 text-center">Upload</th>
                                            <th class="w-5 text-center">Status</th>
                                            <th class="w-20 text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="applicant-uploads">
                                        <tr>
                                            <td>
                                                Letter of Authorization (Refer Clause 2.3 of Annexure 1 of the Scheme
                                                Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/loa_format.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="loa" name="loa"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('1', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '1')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem1" name="rem1"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[1]) ? $remarks[1] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Certificate of Shareholding/ Ownership Pattern (Refer Clause 2.2 of
                                                Annexure 1 of the Scheme Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/shareholding_certificate.xlsx')}}"
                                                    target="_blank" class="btn btn-sm text-success"><i
                                                        class="fas fa-file-excel fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="shareholdingCertificate" name="shareholdingCertificate"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('2', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '2')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem2" name="rem2"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[2]) ? $remarks[2] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Undertaking for Defaulter’s List/Bankruptcy (Refer clause 2.4 of
                                                Annexure 1 of the Scheme Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/bankruptcy_undertaking.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="bankruptcyUndertaking" name="bankruptcyUndertaking"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('3', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '3')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem3" name="rem3"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[3]) ? $remarks[3] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Undertaking for Pending Legal Cases</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/legal_undertaking.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="legalUndertaking" name="legalUndertaking"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('4', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '4')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem4" name="rem4"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[4]) ? $remarks[4] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Certificate of Net Worth Certificate (Refer Clause 2.6 of Annexure 1 of
                                                the Scheme Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/networth_certificate.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="networthCertificate" name="networthCertificate"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('5', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '5')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem5" name="rem5"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[5]) ? $remarks[5] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Undertaking for Consenting of Audit (Refer Clause 7.6 of the Scheme
                                                Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/audit_consenting.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="auditConsenting" name="auditConsenting"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('6', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '6')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem6" name="rem6"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[6]) ? $remarks[6] : '' }}">
                                            </td>
                                        </tr>
                                        {{--
                                        <tr>
                                            <td>Undertaking for Domestic Sales (Refer Clause 7.6.2 of the Scheme
                                                Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/sales_undertaking.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="salesUndertaking" name="salesUndertaking"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('7', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '7')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem7" name="rem7"
                                                    class="form-control form-control-sm">
                                            </td>
                                        </tr>
                                         --}}
                                        <tr>
                                            <td>Integrity Pact (Refer Clause 17.6 of the Scheme Guidelines)</td>
                                            <td class="text-center">
                                                <a href="{{asset('docs/app/integrity_pact.docx')}}" target="_blank"
                                                    class="btn btn-sm text-primary"><i
                                                        class="fas fa-file-word fa-2x"></i></a>
                                            </td>

                                            <td>
                                                <input type="file" id="integrityPact" name="integrityPact"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('8', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '8')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem8" name="rem8"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[8]) ? $remarks[8] : '' }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            4.2 Other Documents
                        </div>
                        <div class="card-body py-0 px-0">
                            <div class="table-responsive p-0 m-0">
                                <table class="table table-sm table-bordered table-hover uploadTable">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="w-35 text-center">Document</th>
                                            <th class="w-10 text-center">Template</th>

                                            <th class="w-20 text-center">Upload</th>
                                            <th class="w-5 text-center">Status</th>
                                            <th class="w-20 text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="applicant-uploads">
                                        <tr>
                                            <td>Business Profile (Refer clause 2.3 of Annexure 1 of the Scheme
                                                Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="businessProfile" name="businessProfile"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('9', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '9')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem9" name="rem9"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[9]) ? $remarks[9] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Memorandum & Articles of Association, Partnership Deed (Refer clause 2.2
                                                of Annexure 1 of the Scheme Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="maoa" name="maoa"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('10', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '10')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem10" name="rem10"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[10]) ? $remarks[10] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Certificate of Incorporation (Refer clause 2.2 of Annexure 1 of the
                                                Scheme Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="coi" name="coi"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('11', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '11')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem11" name="rem11"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[11]) ? $remarks[11] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Copy of PAN (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)
                                            </td>
                                            <td class="text-center"></td>

                                            <td>
                                                <input type="file" id="pan" name="pan"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('12', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '12')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem12" name="rem12"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[12]) ? $remarks[12] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Copy of GST Number (Refer clause 2.3 of Annexure 1 of the Scheme
                                                Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="gstin" name="gstin"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('13', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '13')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem13" name="rem13"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[13]) ? $remarks[13] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CIBIL Report of the applicant (Refer clause 2.4 of Annexure 1 of the
                                                Scheme Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="cibil" name="cibil"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('14', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '14')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem14" name="rem14"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[14]) ? $remarks[14] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Profile of Chairman, CEO, Managing Director, KMP (Refer clause 2.3 of
                                                Annexure 1 of the Scheme Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="managementProfiles" name="managementProfiles"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('15', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '15')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem15" name="rem15"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[15]) ? $remarks[15] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Copy of latest MGT 7 or MGT 9 filed with ROC</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="annualReports" name="annualReports"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('16', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '16')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem16" name="rem16"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[16]) ? $remarks[16] : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Detailed Project Report (Refer clause 3.3 of Annexure 1 of the Scheme
                                                Guidelines)</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="projectReport" name="projectReport"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('17', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '17')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem17" name="rem17"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[17]) ? $remarks[17] : '' }}">
                                            </td>
                                        </tr>
                                        @if($appMast->financials->rnd_achv == 'Y')
                                        <tr>
                                            <td>Recent achievements of in-house R&D</td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="rdAchievement" name="rdAchievement"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('18', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '18')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem18" name="rem18"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[18]) ? $remarks[18] : '' }}">
                                            </td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td>FY 2017-18

                                            </td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="annualReportsfy1718" name="annualReportsfy1718"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('19', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '19')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem19" name="rem19"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[19]) ? $remarks[19] : '' }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>FY 2018-19

                                            </td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="annualReportsfy1819" name="annualReportsfy1819"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('20', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '20')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem20" name="rem20"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[20]) ? $remarks[20] : '' }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>FY 2019-20

                                            </td>
                                            <td></td>

                                            <td>
                                                <input type="file" id="annualReportsfy1920" name="annualReportsfy1920"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('21', $docids))
                                                @foreach($docs as $key=>$doc)
                                                @if($key == '21')
                                                <a href="{{$doc}}" target="_blank"
                                                    class="btn btn-success btn-sm float-centre">
                                                    View</a>
                                                @endif
                                                @endforeach
                                                @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" id="rem21" name="rem21"
                                                    class="form-control form-control-sm" value="{{ isset($remarks[21]) ? $remarks[21] : '' }}">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>

                {{-- <div class="col-md-2 offset-md-3">
                    <a href="{{ route('evaluations.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Evaluation </a>
                </div> --}}
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('proposal.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Proposal Details </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UndertakingUpdate','#form-create') !!}
@endpush
