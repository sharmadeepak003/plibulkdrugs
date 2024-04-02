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
            <form action="{{ route('claimdocumentupload.update', 'A') }}" id="application-create" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                @csrf
                @method('patch')
                <input type="hidden" name="app_id" value="{{ $apps->app_id }}">
                <input type="hidden" name="claim_id" value="{{ $apps->claim_id }}">
                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-info">
                        <strong>General</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="card border-primary p-0 m-10">
                                <div class="card-header bg-gradient-info">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" id="appExist">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-center">S.No.</th>
                                                    <th class="text-center">Document/ Certificate to be Uploaded</th>
                                                    <th class="text-center" colspan="2">Pdf Upload</th>
                                                    <th class="text-center" colspan="2">Excel Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- {{dd($doc_data)}} --}}
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1001)
                                                        {{-- {{dd($doc)}} --}}
                                                            <td>1</td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>List of manufacturing locations with details of products
                                                                manufactured at each facility.</td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="manufacturing"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1056)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="manufacturing"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1002)
                                                            <td>2</td>
                                                            <td>Financial Statements and ledger grouping of Financial
                                                                Staement (in excel format).</td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1000)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="manufacturing"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1002)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="manufacturing"></td>

                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        <!-- @if ($doc->doc_id == 1061)
                                                        <td>2</td>
                                                        <input type="hidden" value="{{ $doc->upload_id }}" name=upload_doc[{{ $key }}][id]>
                                                        <td >Financial Statements and ledger grouping of Financial Staement (in excel format).</td>
                                                        <td><input type="file" name="upload_doc[{{ $key }}][doc]" id="ledger" ></td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.down', $doc->upload_id) }}">View</a></td>
                                                        @endif
                                                        @if ($doc->doc_id == 1002)
                                                        <td><input type="file" name="upload_doc[{{ $key }}][doc]" id="ledger" ></td>
                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.down', $doc->upload_id) }}">View</a></td>
                                                        @endif -->
                                                        <!-- @if ($doc->doc_id == 1061)
                                                        <td>2</td>
                                                        <input type="hidden" value="{{ $doc->upload_id }}" name=upload_doc[{{ $key }}][id]>
                                                        <td>Financial Statements and ledger grouping of Financial Staement (in excel format).</td>
                                                        <td><input type="file" name="upload_doc[{{ $key }}][doc]" id="manufacturing" ></td>

                                                        <td ><a class="btn btn-success btn-sm" href="{{ route('doc.down', $doc->upload_id) }}">View</a></td>
                                                        @endif
                                                        @if ($doc->doc_id == 1002)
                                                        <input type="hidden" value="{{ $doc->upload_id }}" name=upload_doc[{{ $key }}][id]>
                                                        <td><input type="file" name="upload_doc[{{ $key }}][doc]" id="ledger" ></td>
                                                        <td><a class="btn btn-success btn-sm" href="{{ route('doc.down', $doc->upload_id) }}">View</a></td>
                                                        @endif -->
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Whether applicant is required to have an internal audit system u/s
                                                        138 of Companies Act. If yes, then upload Audit Report for claim
                                                        period on sales and fixed assets function.</td>
                                                    <td colspan="2">
                                                        <input type="hidden" name="response" value="{{ $response }}">
                                                        <select id="problem" name="problem"
                                                            class="form-control form-control-sm text-center">
                                                            <option value="Y"
                                                                @if ($response == 'Y') selected @endif>Yes
                                                            </option>
                                                            <option value="N"
                                                                @if ($response == '') selected @endif>No
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                        <div class="card border-primary display m-2 py-10"
                                            style="@if ($response == 'N') display:none;  @else @endif">
                                            <div class="card-body">
                                                <table class="table table-sm table-bordered table-hover" id="related">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th class="text-center"></th>
                                                            <th class="text-center">Period</th>
                                                            <th class="text-center">From Date</th>
                                                            <th class="text-center">To Date</th>
                                                            <th class="text-center" colspan="2">Upload File</th>
                                                            <th class="text-center"><button type="button" name="add"
                                                                    id="add" class="btn btn-success btn-sm">Add
                                                                    More</button></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($genral_doc as $key => $data)
                                                            <tr>
                                                                @php
                                                                    $sn = 1;
                                                                @endphp
                                                                <input type="hidden"
                                                                    name=" GenCompDoc[{{ $key }}][id]"
                                                                    value="{{ $data->id }}"
                                                                    class="form-control form-control-sm name_list1">
                                                                <td class="text-center">{{ $key + 1 }}</td>

                                                                <td class="text-center"><input type="date"
                                                                        name=" GenCompDoc[{{ $key }}][period]"
                                                                        id="period" value="{{ $data->period }}"
                                                                        class="form-control form-control-sm name_list1">
                                                                </td>
                                                                <td class="text-center"><input type="date"
                                                                        name=" GenCompDoc[{{ $key }}][from_date]"
                                                                        id="from_date" value="{{ $data->from_dt }}"
                                                                        class="form-control form-control-sm name_list1">
                                                                </td>
                                                                <td class="text-center"><input type="date"
                                                                        name=" GenCompDoc[{{ $key }}][to_date]"
                                                                        id="to_date" value="{{ $data->to_dt }}"
                                                                        class="form-control form-control-sm name_list1">
                                                                </td>
                                                                <input type="hidden"
                                                                    name="GenCompDoc[{{ $key }}][upload_id]"
                                                                    value="{{ $doc->upload_id }}">
                                                                <td class="text-center"><input type="file"
                                                                        name=" GenCompDoc[{{ $key }}][doc]"
                                                                        id="fileGen"
                                                                        class="form-control form-control-sm name_list1">
                                                                </td>

                                                                <td><a class="btn btn-success btn-sm"
                                                                        href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <table class="table table-sm table-bordered table-hover" style=>
                                            <thead>
                                                <tr>
                                                    <td>4</td>
                                                    <td colspan="8">Bank details for remmittance of Incentive </td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>Bank Name</th>
                                                    <th>Account Name</th>
                                                    <th>Account Type</th>
                                                    <th>Account Number</th>
                                                    <th>Branch Name</th>
                                                    <th>IFSC Code</th>
                                                    <th colspan="2">Upload File</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <input type="hidden" name="GenChqDocN[1][id]"
                                                    value="{{ $bank_info->id }}"
                                                    class="form-control form-control-sm name_list1" id="">
                                                <td></td>
                                                <td><input type="text" name="GenChqDocN[1][bank_name]"
                                                        value="{{ $bank_info->bank_name }}"
                                                        class="form-control form-control-sm name_list1" id="">
                                                </td>
                                                <td><input type="text" name="GenChqDocN[1][acc_name]"
                                                        value="{{ $bank_info->account_holder_name }}"
                                                        class="form-control form-control-sm name_list1" id="acc_name">
                                                </td>
                                                <td><input type="text" name="GenChqDocN[1][acc_type]"
                                                        value="{{ $bank_info->acc_type }}"
                                                        class="form-control form-control-sm name_list1" id="acc_type">
                                                </td>
                                                <td><input type="number" name="GenChqDocN[1][acc_no]"
                                                        value="{{ $bank_info->acc_no }}"
                                                        class="form-control form-control-sm name_list1" id="acc_no">
                                                </td>
                                                <td><input type="text" name="GenChqDocN[1][branch_name]"
                                                        value="{{ $bank_info->branch_name }}"
                                                        class="form-control form-control-sm name_list1" id="branch_name">
                                                </td>
                                                <td><input type="text" name="GenChqDocN[1][ifsc_code]"
                                                        value="{{ $bank_info->ifsc_code }}"
                                                        class="form-control form-control-sm name_list1" id="ifsc_code">
                                                </td>
                                                @foreach ($doc_data as $key => $doc)
                                                    @if ($doc->doc_id == 1004)
                                                        <input type="hidden" name="GenChqDocN[1][upload_id]"
                                                            value="{{ $doc->upload_id }}">
                                                        <td><input type="file" name="GenChqDocN[1][doc]"
                                                                class="form-control form-control-sm name_list1"
                                                                id="doc"></td>
                                                        <td><a class="btn btn-success btn-sm"
                                                                href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                        </td>
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

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-info">
                        <strong>Sales</strong>
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
                                                <th>Document Name</th>
                                                <th colspan="2">Pdf Upload</th>
                                                <th colspan="2">Excel Upload</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1005)
                                                            <td>1</td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>Policy on sale recognition and discount & rebates given post
                                                                sales of article.</td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="recognition"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1006)
                                                            <td>2</td>
                                                            <input type="hidden"
                                                                name="upload_doc[{{ $key }}][id]"
                                                                id="greenfield" value="{{ $doc->upload_id }}">
                                                            <td>Reconciliation of sales from Greenfield Project on which
                                                                incentive is claimed with ledger codes/Financial Statement
                                                            </td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="greenfield"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1057)
                                                            <input type="hidden"
                                                                name="upload_doc[{{ $key }}][id]"
                                                                id="greenfield" value="{{ $doc->upload_id }}">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="greenfield"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1007)
                                                            <td>3</td>
                                                            <input type="hidden"
                                                                name="upload_doc[{{ $key }}][id]" id="purchase"
                                                                value="{{ $doc->upload_id }}">
                                                            <td>Purchase agreements in respect of the cost of technology,
                                                                Intellectual Property Rights (IPRs), patents and copyrights.
                                                            </td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="purchase"></td>
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
                        <strong>Regulatory Fillings</strong>
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
                                                <th>Document Name</th>
                                                <th colspan="2">Pdf Upload</th>
                                                <th colspan="2">Excel Upload</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1008)
                                                            <td>1</td>
                                                            <td>Income Tax Return</td>
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="income_tx"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1009)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>2</td>
                                                            <td>Annual return filed under Companies Act</td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="companies_act"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1058)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="companies_act"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1010)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>3</td>
                                                            <td>GST Return</td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_return"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1059)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_return"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($doc_data as $key => $doc)
                                                        @if ($doc->doc_id == 1011)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td>4</td>
                                                            <td>Working of GST reconciliation given in Statutory Auditor's
                                                                Certificate </td>
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_reconciliation"></td>
                                                            <td><a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', $doc->upload_id) }}">View</a>
                                                            </td>
                                                        @endif
                                                        @if ($doc->doc_id == 1060)
                                                            <input type="hidden" value="{{ $doc->upload_id }}"
                                                                name="upload_doc[{{ $key }}][id]">
                                                            <td><input type="file"
                                                                    name="upload_doc[{{ $key }}][doc]"
                                                                    id="gst_reconciliation"></td>
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

                <div class="row pb-2">
                    <div class="col-md-2 offset-md-0">
                        <a href="{{ route('relatedpartytransaction.edit', $apps->claim_id) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i> Related Party</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit"
                            class="btn btn-primary btn-sm form-control form-control-sm submitshareper pre_event"
                            id="pre_event">
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claimdocumentupload.create', ['B', $apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Upload Section B
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
            var sn = {{ sizeof($genral_doc) }} + 1;
            $('#add').click(function() {
                i++;

                $('#related').append('<tr id="row' + i + '"><td class="text-center">' + sn++ +
                    '</td> <td class="text-center"><input type="date" name=" GenCompDoc[' + (sn - 2) +
                    '][period]" id="name" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="date" name=" GenCompDoc[' +
                    (sn - 2) +
                    '][from_date]" id="from_date" class="form-control form-control-sm name_list1"></td> <td class="text-center"><input type="date" name=" GenCompDoc[' +
                    (sn - 2) +
                    '][to_date]" id="to_date" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="file" name=" GenCompDoc[' +
                    (sn - 2) +
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
        {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadDocumentRequest', '#application-create') !!}
    @endpush
@endpush
