@extends('layouts.user.dashboard-master')

@section('title')
    Claim: Document Upload
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"]{
            padding:1px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimdocumentupload.store','A') }}" id="application-create" role="form" method="POST"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <input type="hidden" name="app_id" value="{{$apps->app_id}}">
                <input type="hidden" name="claim_id" value="{{$apps->claim_id}}">
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
                                        <table class="table table-sm table-bordered table-hover"
                                            id="appExist">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-center">S.No.</th>
                                                    <th class="text-center">Document/ Certificate to be Uploaded</th>
                                                    <th class="text-center">Pdf Upload</th>
                                                    <th class="text-center">Excel Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>List of manufacturing locations with details of products manufactured at each facility.</td>
                                                    <td><input type="file" name="GenListDoc[1]" id="manufacturing" ></td>
                                                    <td><input type="file" name="GenListDocExcel[1]" id="manufacturing" ></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Financial Statements and ledger grouping of Financial Staement (in excel format).</td>
                                                    <td ><input type="file" name="GenFinDocPdf[1]" id="ledger1" ></td>
                                                    <td ><input type="file" name="GenFinancialDoc[1]" id="ledger" ></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td  colspan="2">Whether applicant is required to have an internal audit system u/s 138 of Companies Act. If yes, then upload Audit Report for claim period on sales and fixed assets function.</td>
                                                    <td><select id="problem" name="problem"
                                                        class="form-control form-control-sm text-center">
                                                        <option selected disabled>Select</option>
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="card border-primary display m-2 py-10" style="display:none;">
                                        <div class="card-body">
                                            <table class="table table-sm table-bordered table-hover" id="related">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center"></th>
                                                        <th class="text-center">Period</th>
                                                        <th class="text-center">From Date</th>
                                                        <th class="text-center">To Date</th>
                                                        <th class="text-center">Upload File</th>
                                                        <th class="text-center"><button type="button" name="add" id="add"
                                                                class="btn btn-success">Add More</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                    @endphp
                                                    <td class="text-center">{{ $sn++ }}</td>
                                                    <td class="text-center"><input type="date" name="GenCompDoc[1][period]" id="period"
                                                            class="form-control form-control-sm name_list1"></td>
                                                    <td class="text-center"><input type="date" name=" GenCompDoc[1][from_date]" id="from_date"
                                                        class="form-control form-control-sm name_list1"></td>
                                                    <td class="text-center"><input type="date" name="GenCompDoc[1][to_date]" id="to_date"
                                                            class="form-control form-control-sm name_list1"></td>
                                                    <td class="text-center"><input type="file" name="GenCompDoc[1][doc]" id="fileGen"
                                                            class="form-control form-control-sm name_list1"></td>
                                                    <td></td>
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
                                                    <th>PDF Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <td></td>
                                              <td><input type="text" name="GenChqDoc[1][bank_name]" value="" class="form-control form-control-sm name_list1" id=""></td>
                                              <td><input type="text" name="GenChqDoc[1][acc_name]" value="" class="form-control form-control-sm name_list1" id="acc_name"></td>
                                              <td><input type="text" name="GenChqDoc[1][acc_type]" value="" class="form-control form-control-sm name_list1" id="acc_type"></td>
                                              <td><input type="number" name="GenChqDoc[1][acc_no]" value="" class="form-control form-control-sm name_list1" id="acc_no"></td>
                                              <td><input type="text" name="GenChqDoc[1][branch_name]" value="" class="form-control form-control-sm name_list1" id="branch_name"></td>
                                              <td><input type="text" name="GenChqDoc[1][ifsc_code]" value="" class="form-control form-control-sm name_list1" id="ifsc_code"></td>
                                              <td><input type="file" name="GenChqDoc[1][doc]" value="" class="form-control form-control-sm name_list1" id="doc"></td>
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
                                        <table class="table table-sm table-bordered table-hover"
                                            id="appExist">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Document Name</th>
                                                    <th>PDF Upload</th>
                                                    <th>Excel Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Policy on sale recognition and discount & rebates given post sales of article.</td>
                                                    <td colspan="2"><input type="file" name="SalesPolicyDoc[1]" id="recognition"></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Reconciliation of sales from Greenfield Project on which incentive is claimed with ledger codes/Financial Statement	</td>
                                                    <td><input type="file" name="SalesReconDoc[1]" id="greenfield" ></td>
                                                    <td><input type="file" name="SalesReconDocExcel[1]" id="recognition"></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Purchase agreements in respect of the cost of technology, Intellectual Property Rights (IPRs), patents and copyrights.</td>
                                                    <td colspan="2"><input type="file" name="SalesAgreeDoc[1]" id="purchase" ></td>
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
                                        <table class="table table-sm table-bordered table-hover"
                                            id="appExist">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Document Name</th>
                                                    <th>PDF Upload</th>
                                                    <th>Excel Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td >Income Tax Return</td>
                                                    <td colspan=2><input type="file" name="RegulatoryITRDoc[1]" id="income_tx"></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Annual return filed under Companies Act</td>
                                                    <td><input type="file" name="RegulatoryAnnualDoc[1]" id="companies_act" ></td>
                                                    <td><input type="file" name="RegulatoryAnnualDocExcel[1]" id="income_tx"></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>GST Return</td>
                                                    <td><input type="file" name="RegulatoryGSTDoc[1]" id="gst_return" ></td>
                                                    <td><input type="file" name="RegulatoryGSTDocExcel[1]" id="income_tx"></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Working of GST reconciliation given in  Statutory Auditor's Certificate	</td>
                                                    <td><input type="file" name="RegulatorySADoc[1]" id="gst_reconciliation" ></td>
                                                    <td><input type="file" name="RegulatorySADocExcel[1]" id="income_tx"></td>
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
                      
                        <a href="  {{ route('relatedpartytransaction.create',$apps->claim_id) }}" class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i>Related Party</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="pre_event">
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claimdocumentupload.create', ['B',$apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Upload Section B <i
                            class="fa  fa-forward"></i></a>
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
                    $('#related').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td> <td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][period]" id="name" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][from_date]" id="from_date" class="form-control form-control-sm name_list1"></td> <td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][to_date]" id="to_date" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="file" name=" GenCompDoc['+ (sn-1) +'][doc]" id="to_date" class="form-control form-control-sm name_list1"></td><td></td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
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

        $(document).ready(function () {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("pre_event");
                btn.disabled = true;
                setTimeout(function(){btn.disabled = false;}, (1000*20));
            });
        });
    </script>
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadDocumentRequest', '#application-create') !!}
@endpush
@endpush
