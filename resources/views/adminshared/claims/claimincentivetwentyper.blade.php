@extends('layouts.admin.master')

@push('styles')
    <style>
        th {
            text-align: center;
            vertical-align: top !important;
            font-size: 14px;
            background-color: #f8f9fa;
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

        </div>
    </div>
    <form action="{{ route('admin.claims.twentyper.incentiveStore', $fy_id) }}" id="incentive-create" role="form"
        method="post" class='form-horizontal prevent_multiple_submit cree' files=true enctype='multipart/form-data'
        accept-charset="utf-8" onsubmit="return validateForm()">
        @csrf

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

                                    </tr>
                                </thead>
                                <tbody class="appstable-body">
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
                                            <input type="hidden"   name="claim[{{ $count }}][user_id]" value="{{ $data->user_id }}">
                                            <input type="hidden" name="claim[{{ $count }}][app_id]" value="{{ $data->app_id }}">
                                            <input type="hidden" name="claim[{{ $count }}][claim_id]"  value="{{ $data->claim_id }}">
                                            <input type="hidden" name="claim[{{ $count }}][company_name]"  value="{{ $data->company_name }}">
                                            <input type="hidden" name="claim[{{ $count }}][claim_duration]"  value="{{ $data->claim_duration }}">
                                            <input type="hidden" name="claim[{{ $count }}][claim_filing]"  value="{{ $data->claim_filing }}">
                                            <input type="hidden" name="claim[{{ $count }}][product_name]"  value="{{ $data->product_name }}">
                                            

                                            
                                            <td class="text-right">
                                    
                                                <input type="text" name="claim[{{ $count }}][incAmount]"
                                                    class="form-control form-control-sm text-right" required value="">
                                            </td>

                                            <input type="hidden" name="claim[{{ $count }}][id]"
                                                class="form-control form-control-sm" value="" readonly>
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
                                                    class="form-control form-control-sm" value="">
                                            </td>
                                            <td class="text-left">
                                                <input type="date" name="claim[{{ $count }}][reportMeitytoPMA]"
                                                    id="reportMeitytoPMA{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    onchange="DateDiff(this,{{ $count }})" value="">
                                            </td>
                                            <td class="text-left"><input type="number"
                                                    name="claim[{{ $count }}][noOfDaysSubReport]"
                                                    id="noOfDaysSubReport{{ $count }}"
                                                    class="form-control form-control-sm" readonly value=""></td>
                                            <td class="text-left"><input type="number"
                                                    name="claim[{{ $count }}][noOfDaysCompData]"
                                                    id="noOfDaysCompData{{ $count }}"
                                                    class="form-control form-control-sm" readonly value=""></td>
                                            <td class="text-left col-lg-4">
                                                <input type="text" name="claim[{{ $count }}][remarks]"
                                                    id="remarks{{ $count }}" class="form-control form-control-sm"
                                                    value="">
                                            </td>
                                            <td class="text-left">
                                                <select style="width: 100px;" id="status{{ $count }}"
                                                    name="claim[{{ $count }}][status]"
                                                    class="form-control form-control-sm text-left"
                                                    onchange="Status({{ $count }})">
                                                    <option selected disabled>Select</option>
                                                    <option value="A">Approved</option>
                                                    <option value="UP">Under Process</option>
                                                    <option value="R">Rejected</option>
                                                </select>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" name="claim[{{ $count }}][apprDate]"
                                                    id="date{{ $count }}" class="form-control form-control-sm"
                                                    onchange="checkAppr(this,{{ $count }})" readonly
                                                    value="">
                                            </td>
                                            <td class="text-left">
                                                <input type="date"
                                                    name="claim[{{ $count }}][date_of_disbursal_claim_pma]"
                                                    id="date_of_disbursal_claim_pma{{ $count }}"
                                                    class="form-control form-control-sm"
                                                    onchange="DateDiffDis(this,{{ $count }})" value="">
                                            </td>
                                            <td class="text-left">
                                                <input type="number"
                                                    name="claim[{{ $count }}][total_duration_disbursal]"
                                                    id="total_duration_disbursal{{ $count }}"
                                                    class="form-control form-control-sm" readonly value="">
                                            </td>
                                            <td class="text-left">
                                                <input type="number" name="claim[{{ $count }}][apprAmount]"
                                                    id="amount{{ $count }}" class="form-control form-control-sm"
                                                    readonly value="">
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="claim[{{ $count }}][processed_amount]"
                                                    id="amount{{ $count }}"
                                                    class="form-control form-control-sm text-right" value="">
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
                            class="btn btn-primary btn-sm form-control form-control-sm fas fa-save"> Submit </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CorrespondenceRequest', '.cree') !!}
    <script>
        async function checkDate(input, claimIndex) {
            var reportInfo = document.getElementById('reportInfo' + claimIndex).value;
            await new Promise(resolve => setTimeout(resolve, 1000)); // Simulating 1 second delay
            var reportMeitytoPMA = input.value;
            var reportInfoObj = new Date(reportInfo);
            var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
            var timeDiff = reportMeitytoPMAObj - reportInfoObj;
            var diffDays = timeDiff / (1000 * 3600 * 24);

            if (diffDays < 0) {
                swal({
                    title: "Invalid Date",
                    text: 'Report to Ministry by PMA date cannot be earlier than Report Info Date',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                });
                // alert('Report MeitytoPMA date cannot be earlier than Filing Date');
                input.value = '';
                $('#noOfDaysSubReport' + claimIndex).val('');
                $('#noOfDaysCompData' + claimIndex).val('');
            }
        }


        async function checkCia(input, claimIndex) {
            var filingDate = document.getElementById('filingDate' + claimIndex).value;
            await new Promise(resolve => setTimeout(resolve, 1000)); // Simulating 1 second delay
            var reportInfo = input.value;
            var filingDateObj = new Date(filingDate);
            var reportInfoObj = new Date(reportInfo);
            var timeDiff = reportInfoObj - filingDateObj;
            var diffDays = timeDiff / (1000 * 3600 * 24);

            if (diffDays < 0) {
                // Simulating an asynchronous operation that takes some time
                swal({
                    title: "Invalid Date",
                    text: 'Report Info date cannot be earlier than Filing Date',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                });
                // alert('Report Info date cannot be earlier than Filing Date');
                input.value = '';
                $('#noOfDaysSubReport' + claimIndex).val('');
                $('#noOfDaysCompData' + claimIndex).val('');
            }
        }


        async function checkDdcp(input, claimIndex) {
            var reportMeitytoPMA = document.getElementById('reportMeitytoPMA' + claimIndex).value;
            await new Promise(resolve => setTimeout(resolve, 1000));
            var date_of_disbursal_claim_pma = input.value;
            var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
            var date_of_disbursal_claim_pma = new Date(date_of_disbursal_claim_pma);
            var timeDiff = date_of_disbursal_claim_pma - reportMeitytoPMAObj;
            var diffDays = timeDiff / (1000 * 3600 * 24);

            if (diffDays < 0) {
                swal({
                    title: "Invalid Date",
                    text: 'Date Of Disbursal Claim PMA date cannot be earlier than Report to Ministry by PMA',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                });
                // alert('Date Of Disbursal Claim PMA date cannot be earlier than Filing Date');
                input.value = '';
                $('#total_duration_disbursal' + claimIndex).val('');
            }
        }
        async function checkAppr(input, claimIndex) {
            var reportMeitytoPMA = document.getElementById('reportMeitytoPMA' + claimIndex).value;
            await new Promise(resolve => setTimeout(resolve, 1000));
            var apprdate = input.value;
            var reportMeitytoPMAObj = new Date(reportMeitytoPMA);
            var apprdate = new Date(apprdate);
            var timeDiff = apprdate - reportMeitytoPMAObj;
            var diffDays = timeDiff / (1000 * 3600 * 24);

            if (diffDays < 0) {
                swal({
                    title: "Invalid Date",
                    text: 'Approval date cannot be earlier than Report to Ministry by PMA',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                });
                // alert('Date Of Disbursal Claim PMA date cannot be earlier than Filing Date');
                input.value = '';
                $('#total_duration_disbursal' + claimIndex).val('');
            }
        }

        async function checkResDate(input, claimIndex) {
            var raisedate = document.getElementById('raise' + claimIndex).value;
            await new Promise(resolve => setTimeout(resolve, 1000));
            var response_date = input.value;
            var raisedateObj = new Date(raisedate);
            var response_dateObj = new Date(response_date);
            var timeDiff = response_dateObj - raisedateObj;
            var diffDays = timeDiff / (1000 * 3600 * 24);
            // console.log(raisedate,response_date,raisedateObj,response_dateObj,timeDiff,diffDays);

            if (diffDays < 0) {
                console.log('if');
                swal({
                    title: "Invalid Date",
                    text: 'Response date must be greater than the raised date',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                });
                input.value = '';

            }
        }
        $(document).ready(function() {

            const btn = document.getElementById("submit_update");
            const btn_modal = document.getElementById("submit_modal");

            $('.prevent_multiple_submit').on('submit', function() {
                $(".prevent_multiple_submit").parent().append(
                    '<div class="offset-md-4 msg"><span class="text-danger text-sm text-center">Please wait while your request is being processed. &nbsp&nbsp&nbsp<i class="fa fa-spinner fa-spin" style="font-size:24px;color:black"></i></span></div>'
                    );

                btn.disabled = true;
                btn_modal.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 50));
                setTimeout(function() {
                    btn_modal.disabled = false;
                }, (1000 * 50));
                setTimeout(function() {
                    $(".msg").hide()
                }, (1000 * 50));
            });

        });



        $(document).ready(function() {
            var i = 1;


            $('[id^="addCorres"]').on('click', function() {
                var button_id = $(this).attr("id").match(/\d+/)[0];
                var add_id = $(this).attr("id").match(/\d+/)[0];
                var ser = $(this).attr("row_serial").match(/\d+/)[0];



                i++;
                $('#morecon' + add_id).append('<div class="row" id="row' + button_id + i +
                    '"><div class="col-4"><label >' + i +
                    '. Date Of Raising First Query by PMA</label><input type="date" class="form-control dateCompare" id="raise' +
                    i + '" name="corres[' + i +
                    '][raise_date]"></div><div class="col-4"><label >Date of Reply by the Beneficiary</label><input type="date" id="respo' +
                    i + '" class="form-control dateCompare" onchange="checkResDate(this,' + i +
                    ')" name="corres[' + i +
                    '][response_date]"></div><div class="col-4"><label >Document</label><input type="file" class="form-control" name="corres[' +
                    i +
                    '][image]"></div><div class="col-12"><label>Message</label><textarea id="" class="summernote form-control" placeholder="Message" name="corres[' +
                    i +
                    '][message]"></textarea></div><div class="offset-10 col-2"><button class="btn btn-danger btn_remove" type="button" id="' +
                    button_id + i + '">Remove</button></div></div>');
                $('.summernote').summernote();
            });
            // });
            $(document).on('click', '.btn_remove', function() {
                var r_id = $(this).attr("id");
                $('#row' + r_id + '').remove();
            });



            $("#filterData").click(function(event) {
                var fyId = $('#fy_name').val();
                var link = '/admin/claims/incentive/' + fyId;
                window.location.href = link;
            });

            var t = $('#apps').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [0, 'asc']
                ],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                },
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

        function DateDiff(e, count) {
            var ids = $(e).attr('id');
            var val = new Date($('#' + ids).val());
            var filDate = new Date($('#filingDate' + count).val());
            var reportDate = new Date($('#reportInfo' + count).val());
            var reportData = Math.round((val - filDate) / (1000 * 60 * 60 * 24));
            var reportMeitytoPMA = Math.round((val - reportDate) / (1000 * 60 * 60 * 24));
            $('#noOfDaysSubReport' + count).val(reportData);
            $('#noOfDaysCompData' + count).val(reportMeitytoPMA);

            checkDate(e, count);
        }

        function DateDiffDis(e, count) {
            var ids = $(e).attr('id');
            var val = new Date($('#' + ids).val());
            var filDate = new Date($('#filingDate' + count).val());

            var reportMeitytoPMA = Math.round((val - filDate) / (1000 * 60 * 60 * 24));
            // console.log(val,reportMeitytoPMA);
            $('#total_duration_disbursal' + count).val(reportMeitytoPMA);
            checkDdcp(e, count);
        }

        function Status(count) {
            $("#status" + count).click(function(e) {
                var val = $(this).val();
                if (val == 'A') {
                    // $("#remarks"+count).prop('readonly', false);
                    $("#amount" + count).prop('readonly', false);
                    $("#date" + count).prop('readonly', false);
                } else if (val == 'UP' || val == 'R') {
                    // $("#remarks"+count).prop('readonly', true);
                    $("#amount" + count).prop('readonly', true);
                    $("#date" + count).prop('readonly', true);
                    // $("#remarks"+count).val('');
                    $("#amount" + count).val('');
                    $("#date" + count).val('');
                }
            });
        }

        function validateDates(index) {
            var filingDate = document.getElementById('filingDate' + index).value;
            var reportInfoDate = document.getElementById('reportInfo' + index).value;

            if (new Date(reportInfoDate) < new Date(filingDate)) {
                swal({
                    title: "Invalid Date",
                    text: 'Please Select Valid Date',
                    icon: "warning",
                    buttons: {
                        cancel: 'Close'
                    },
                })


                $('#reportInfo' + index).css('border-color', "#ff0000");

                return false;
            }
            return true;
        }

        function resetBorders() {
            var claimCount = <?php echo count($claimData); ?>;
            for (var i = 0; i < claimCount; i++) {

                $('#reportInfo' + i).css('border-color', "#000000");
            }
        }

        function validateForm() {
            resetBorders();

            var claimCount = <?php echo count($claimData); ?>;
            for (var i = 0; i < claimCount; i++) {
                if (!validateDates(i)) {
                    return false;
                }
            }
            return true;
        }


        $(function() {
            $('.summernote').summernote()


        });
    </script>
@endpush
