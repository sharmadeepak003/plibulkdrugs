@extends('layouts.admin.master')

@push('styles')
    <style>
        th {
            text-align: center;
            vertical-align: top !important;
            font-size: 14px;
            background-color: #faf8fa;
            padding: 10px;
        }

        .scrollable-content {
            max-height: 100px;
            overflow-y: auto;
            padding: 5px;
            width: 160px;
        }

        .scontent {

            width: 200px;
        }

        .twentyper {
            background-color: rgb(188, 117, 25);
        }
    </style>
@endpush

@section('title')
    Claim - Incentive
@endsection

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4" style="margin-left: 10%">
                    <label>Financial Year for which details are to be filled in</label>
                </div>
                <div class="col-md-3">
                    {{-- {{dd($fys)}} --}}
                    <select name="fy_name" id="fy_name" class="form-control col-md-12">
                        <option value="ALL" @if ($fy_id == 'ALL') selected @endif>ALL</option>
                        @foreach ($fys as $fyname)
                            <option value="{{ $fyname->id }}" @if ($fy_id == $fyname->id) selected @endif>
                                {{ $fyname->fy_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="filterData" class="btn btn-sm btn-block btn-primary text-white">
                        Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{-- <div class="card border-primary"> --}}
            {{-- <div class="card-body"> --}}
            <div class="col">
                <div class="offset-md-2">
                    <a href="{{ route('admin.claims.incentiveExport') }}" class="btn btn-sm btn-warning"
                        style="float:right;">Export All Data (Excel)</a>
                </div>
            </div>

            <div class="col-md-2 offset-md-8">
                <div class="offset-md-2">
                    <a href="{{ route('admin.claims.summaryReportView') }}" class="btn btn-sm btn-secondary"
                        style="float:right;">Summary Report<i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>

            {{-- <div class="col-md-2 offset-md-8">
                    <div class="offset-md-2">
                        <a href="{{ route('shared.claims.summaryReport') }}"
                            class="btn btn-sm btn-secondary" style="float:right;">Download Summary Report<i class="fa fa-download" aria-hidden="true"></i></a>
                    </div>
                </div> --}}
            {{-- </div>
        </div> --}}
        </div>
    </div>
    <form action="{{ route('admin.claims.incentiveUpdate', $fy_id) }}" id="incentive-create" role="form" method="post"
        class='form-horizontal prevent_multiple_submit cree' files=true enctype='multipart/form-data' accept-charset="utf-8"
        onsubmit="return validateForm()">
        @csrf
        @method('PATCH')
        <div class="row py-4">
            <div class="col-md-12">
                <div class="card border-primary">
                    <div class="card-header text-center bg-primary text-white font-weight-bold">
                        Claim Incentive
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                                <thead class="appstable-head">
                                    <tr class="table-info">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="3">Expected Date of Submission of</th>
                                        <th colspan="2">Number of days between</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>


                                    </tr>
                                    <tr class="table-info">
                                        <th class="text-center">Sr. No.</th>
                                        <th class="text-center">Scheme Name</th>
                                        <th class="text-center">
                                            <div class="scontent">Name of the Beneficiary</div>
                                        </th>
                                        <th class="text-center">
                                            <div class="scontent">Timeline Provided in the Guidelines/SOP for processing of
                                                claims and disbursal of incentives</div>
                                        </th>
                                        <th class="text-center">Financial Year &nbsp (FY)</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Amount Claims Received (₹ in crores)</th>
                                        <th class="text-center">
                                            <div class="scontent">Date of Submission of claims by beneficiary</div>
                                        </th>
                                        <th class="text-center">First Query Raised by PMA</th>
                                        <th class="text-center">Complete Information by Applicant</th>
                                        <th class="text-center">Report to Ministry by PMA</th>
                                        <th class="text-center">Date of filing and submission of report to ministry</th>
                                        <th class="text-center">
                                            <div class="scontent">Receipt of complete information and submission of report
                                                to ministry</div>
                                        </th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date of approval of the claim by competent authority</th>
                                        <th class="text-center">Date of disbursal of claim by PMA</th>
                                        <th class="text-center">
                                            <div class="scontent">Total Duration from receipt of first application and
                                                disbursal of claim ( in days)</div>
                                        </th>
                                        <th class="text-center">Approved Incentive Amount &nbsp(₹ in crores)</th>
                                        <th class="text-center">Processed by PMA Amount</th>
                                        {{-- <th class="text-center">Twenty / Without Twenty </th> --}}
                                        <th class="text-center">Transaction Status </th>
                                        <th class="text-center">Correspondence</th>
                                    </tr>
                                    <tr class="table-info">
                                        <td class="text-center">A</td>
                                        <td class="text-center">B</td>
                                        <td class="text-center">C</td>
                                        <td class="text-center">D</td>
                                        <td class="text-center">E</td>
                                        <td class="text-center">F</td>
                                        <td class="text-center">G</td>
                                        <td class="text-center">H</td>
                                        <td class="text-center"></td>

                                        <td class="text-center">I</td>
                                        <td class="text-center">J</td>
                                        <td class="text-center">K=J-H</td>
                                        <td class="text-center">L=J-I</td>
                                        <td class="text-center">M</td>
                                        <td class="text-center">N</td>
                                        <td class="text-center">O</td>
                                        <td class="text-center">P</td>
                                        <td class="text-center">Q=P-H</td>
                                        <td class="text-center">R</td>
                                        <td class="text-center">S</td>
                                        <td class="text-center">T</td>
                                        <td class="text-center">U</td>

                                    </tr>
                                </thead>
                                <tbody id="TestEyestbl" class="appstable-body">
                                    @php
                                        $count = 1;

                                    @endphp
                                    @foreach ($claimData as $data)
                                        <tr>

                                            <td class="text-left">{{ $count++ }}</td>
                                            <td class="text-left">{{ $data->scheme_name }}</td>
                                            <td class="text-left">{{ $data->company_name }}</td>
                                            <td class="text-left">{{ $data->claim_duration }}</td>
                                            <td class="text-left">{{ $data->claim_fy }}</td>
                                            <td class="text-left">{{ $data->product_name }}</td>
                                            <td class="text-right">

                                                <input type="text" name="claim[{{ $count }}][incAmount]"
                                                    class="form-control form-control-sm text-right"
                                                    value={{ $data->incentive_amount != null ? $data->incentive_amount : '' }}>
                                            </td>

                                            <input type="hidden" name="claim[{{ $count }}][id]"
                                                class="form-control form-control-sm" value="{{ $data->id }}"
                                                readonly>
                                            <td class="text-left">
                                                <input type="date" name="claim[{{ $count }}][filingDate]"
                                                    id="filingDate{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    value="{{ date('Y-m-d', strtotime($data->claim_filing)) }}" readonly>
                                            </td>
                                            <td><input type="date" class="form-control"
                                                    name="claim[{{ $count }}][first_query_by_pma]"></td>
                                            <td class="text-left">

                                                <input type="date" name="claim[{{ $count }}][reportInfo]"
                                                    onchange="checkCia(this,{{ $count }})"
                                                    id="reportInfo{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    value="{{ $data->expsubdate_reportinfo }}">
                                            </td>
                                            <td class="text-left">
                                                <input type="date" name="claim[{{ $count }}][reportMeitytoPMA]"
                                                    id="reportMeitytoPMA{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    onchange="DateDiff(this,{{ $count }})"
                                                    value="{{ $data->expsubdate_reportmeitytopma }}">
                                            </td>
                                            <td class="text-left"><input type="number"
                                                    name="claim[{{ $count }}][noOfDaysSubReport]"
                                                    id="noOfDaysSubReport{{ $count }}"
                                                    class="form-control form-control-sm" readonly
                                                    value={{ $data->daysbetween_submandreport }}></td>
                                            <td class="text-left"><input type="number"
                                                    name="claim[{{ $count }}][noOfDaysCompData]"
                                                    id="noOfDaysCompData{{ $count }}"
                                                    class="form-control form-control-sm" readonly
                                                    value={{ $data->daysbetween_dataandreport }}></td>
                                            <td class="text-left col-lg-4">
                                                <input type="text" name="claim[{{ $count }}][remarks]"
                                                    id="remarks{{ $count }}" class="form-control form-control-sm"
                                                    value="{{ $data->remarks }}">
                                            </td>
                                            <td class="text-left">
                                                <select style="width: 100px;" id="status{{ $count }}"
                                                    name="claim[{{ $count }}][status]"
                                                    class="form-control form-control-sm text-left"
                                                    onchange="Status({{ $count }})">
                                                    <option selected disabled>Select</option>
                                                    <option @if ($data->status == 'A') selected @endif
                                                        value="A">Approved</option>
                                                    <option @if ($data->status == 'UP') selected @endif
                                                        value="UP">Under Process</option>
                                                    <option @if ($data->status == 'R') selected @endif
                                                        value="R">Rejected</option>
                                                </select>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" name="claim[{{ $count }}][apprDate]"
                                                    id="date{{ $count }}" class="form-control form-control-sm"
                                                    onchange="checkAppr(this,{{ $count }})" readonly
                                                    value="{{ $data->appr_date }}">
                                            </td>
                                            <td class="text-left">
                                                <input type="date"
                                                    name="claim[{{ $count }}][date_of_disbursal_claim_pma]"
                                                    id="date_of_disbursal_claim_pma{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    onchange="DateDiffDis(this,{{ $count }})"
                                                    value="{{ $data->date_of_disbursal_claim_pma }}">
                                            </td>
                                            <td class="text-left">
                                                <input type="number"
                                                    name="claim[{{ $count }}][total_duration_disbursal]"
                                                    id="total_duration_disbursal{{ $count }}"
                                                    class="form-control form-control-sm" readonly
                                                    value={{ $data->total_duration_disbursal }}>
                                            </td>
                                            <td class="text-left">
                                                <input type="number" name="claim[{{ $count }}][apprAmount]"
                                                    id="amount{{ $count }}" class="form-control form-control-sm"
                                                    readonly value={{ $data->appr_amount }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="claim[{{ $count }}][processed_amount]"
                                                    id="amount{{ $count }}"
                                                    class="form-control form-control-sm text-right"
                                                    value={{ $data->processed_amount }}>
                                            </td>
                                            <?php
                                            $claimIncDocMap = DB::table('incetive_doc_map')
                                                ->where('claim_id', $data->claim_id)
                                                ->where('status', '=', 'S')
                                                ->count();
                                            $dataExist = DB::table('tbl_twenty_per_claim_incentive')
                                                ->where('admin_claim_inc_id', $data->id)
                                                ->count();
                                            ?>
                                            <td>
                                                @if ($claimIncDocMap >= 1)
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="modal"
                                                        data-target="#addtransict{{ $data->id }}"><i
                                                            class="fa fa-plus" style="color:white"></i>
                                                        </button>
                                                    @include('adminshared.claims.addclaimtransaction')
                                                @else
                                                    <p>Not Applicable</p>
                                                @endif

                                                @if ($dataExist >= 1)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal"
                                                        data-target="#viewtransict{{ $data->id }}"><i
                                                            class="fa fa-eye" style="color:white"></i></button>

                                                    @include('adminshared.claims.claimtransaction')
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @php
                                                    $claimCor = DB::table('claim_incentive_correspondence')
                                                        ->where('claim_id', $data->claim_id)
                                                        ->count();
                                                @endphp
                                                @if ($claimCor >= 1)
                                                    <a href="{{ route('admin.claims.correspondanceEdit', encrypt($data->claim_id)) }}"
                                                        class="btn btn-sm btn-warning">Update</a>
                                                    <a href="{{ route('admin.claims.correspondanceView', encrypt($data->claim_id)) }}"
                                                        class="btn btn-sm btn-success">View</a>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal"
                                                        data-target="#addmodel{{ $data->id }}">Add</button>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row py-2">

                    <div class="col-md-2 offset-md-5">
                        <button type="submit" id="submit_update"
                            class="btn btn-primary btn-sm form-control form-control-sm fas fa-save">Update </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @foreach ($claimData as $data)
        <div class="modal fade" id="addmodel{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Correspondence</h5>
                        <button type="button" id="addCorres{{ $data->id }}" class="btn btn-success ml-40 btnsub"
                            row_serial="{{ $data->id }}">
                            Add <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <form id="corresCreate" action="{{ route('admin.claims.correspondance', encrypt($data->claim_id)) }}"
                        role="form" method="POST" class='form-horizontal prevent_multiple_submit cree'
                        enctype='multipart/form-data' accept-charset="utf-8" files=true>
                        @csrf
                        @php
                            $i = 1;
                        @endphp
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="app_id" value="{{ $data->app_id }}">
                                <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                                <div class="col-4">
                                    <label>1. Date Of Raising First Query by PMA <span
                                            class="text-danger">(*)</span></label>
                                    <input type="date" class="form-control dateCompare" id="raise{{ $data->id }}"
                                        name="corres[{{ $i }}][raise_date]">
                                </div>
                                <div class="col-4">
                                    <label>Date of Reply by the Beneficiary</label>
                                    <input type="date" class="form-control dateCompare" id="respo{{ $data->id }}"
                                        onchange="checkResDate(this,{{ $data->id }})"
                                        name="corres[{{ $i }}][response_date]">
                                </div>

                                <div class="col-4">
                                    <label>Document</label>
                                    <input type="file" class="form-control"
                                        name="corres[{{ $i }}][image]">
                                </div>
                                <div class="col-12">
                                    <label>Message <span class="text-danger">(*)</span></label>
                                    <textarea class="form-control summernote" placeholder="Message" name="corres[{{ $i }}][message]"></textarea>
                                </div>
                            </div>
                            <div id="morecon{{ $data->id }}"></div>
                        </div>
                        <div class="modal-footer">
                            <span class="text-dark text-left text-bold" style="float: left;padding-right: 50%;">All *
                                field is Mandatory.</span>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit_modal">Save changes</button>
                        </div>
                        @php
                            $i++;
                        @endphp
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    {{-- end View Twenty Percentage Claim --}}
@endsection

@push('scripts')

@include('partials/admin/shared/js/claimIncentive');

@endpush
