@extends('layouts.admin.master')

@section('title')
    Mail Schedular Park Claim Variable
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        .align_right tr td:not(:first-child) input {
            text-align: right !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Current Application-->
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <h5> Invoice Park Claim Variable List</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="#" class="table table-sm  table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Quarter</th>
                                            <th>Financial Year </th>
                                            <th>Uploaded By</th>
                                            <th>Uploaded At</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        $getCount = count($getParkClaimVariableData);
                                        ?>
                                        @if (!empty($getCount))
                                            @foreach ($getParkClaimVariableData as $gpcvd)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $gpcvd->qtr_id }}</td>
                                                    <td>{{ $gpcvd->financial_year }}</td>
                                                    <td>{{ $gpcvd->updated_by }}</td>
                                                    <td>{{ $gpcvd->created_at }}</td>
                                                    <td>{{ $gpcvd->remark }}</td>
                                                    <td>
                                                        @if ($gpcvd->status == 'S')
                                                            <span style="color:green; font-size:14px;"> Submit</span>
                                                        @elseif($gpcvd->status == 'D')
                                                            <span style="color:yellow; font-size:14px;"> Draft</span>
                                                        @else
                                                            <span style="color:red; font-size:14px; "> Pending</span>
                                                        @endif


                                                    <td>
                                                        @if ($gpcvd->status == 'S')
                                                            <a class="btn btn-primary btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal3" id="{{ $gpcvd->id }}"
                                                                onClick="viewParkClaimVariableList(this.id)"><i class="fa fa-eye"
                                                                    aria-hidden="true"> View</i></a>
                                                        @elseif($gpcvd->status == 'D')
                                                            <a class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal2" id="{{ $gpcvd->id }}"
                                                                onClick="editParkClaimVariable(this.id)"><i class="fa fa-edit"
                                                                    aria-hidden="true"> Edit</i></a>
                                                        @else
                                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal" id="{{ $gpcvd->id }}"
                                                                onClick="GFG_click(this.id)"><i class="fa fa-pencil"
                                                                    aria-hidden="true"> Create</i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        @else
                                            <p>Data Not Found!</p>
                                        @endif


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Below is MOdal 1 For Create Form --}}

    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title " id="exampleModalLabel">Park Claim Variable Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" id="modalClose"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='{{ route('admin.parkclaimvariable.store') }}' id="mail-schedular" name="mail-schedular"
                        role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="parkClaimVariableId" id="parkClaimVariableId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Current Quarter</label>
                                    <input class="form-control form-control-sm" name="quarter" type="text"
                                        value="{{ $quarter }}" readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Current Financial Year</label>
                                    <input class="form-control form-control-sm" name="fyear" type="text"
                                        value="{{ $year }}" readonly>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">DD</label>
                                    <select class="form-control form-control-sm" id="dd" name="dd">
                                        <option value="" disabled selected="selected">Select Option</option>
                                        <option value="ministry">Ministry</option>
                                        <option value="empower committee">Empower Committee</option>
                                        <option value="mints of meeting">Mints of Meeting</option>
                                        <option value="disbursed">Disbursed</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Remark</label>
                                    <input type="text" name="remark" id="remark"
                                        class="form-control form-control-sm">
                                    {{-- <textarea class="form-control form-control-sm" name="remark" id="remark" rows="5" cols="30"></textarea> --}}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formFile" class="form-label">MOU Upload</label>
                                    <input class="form-control form-control-sm" type="file" id="mouFile"
                                        name="mouFile">
                                </div>
                            </div>

                            <div class="col-md-4"></div>

                            <div class="col-md-12 table-responsive rounded m-0 p-0">

                                <div style="height: 20px; clear:both;"></div>
                                <table class="table table-bordered table-hover table-sm" id="claimVariableTable">
                                    <tr>
                                        <td colspan="10">
                                            <button type="button" id="claimVariable" name="claimVariable"
                                                class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add
                                                Rows</button>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <div class="form-group">
                                                <label for="invoiceAmount">Invoice Amount</label>
                                                <input type="text" name="data[0][amt]" id="invoiceAmount"
                                                    class="form-control form-control-sm" value="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="invoiceDate">Invoice Date</label>
                                                <input type="date" class="form-control form-control-sm"
                                                    name="data[0][date]" id="invoiceDate">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Document Upload</label>
                                                <input class="form-control form-control-sm" type="file" id="formFile"
                                                    name="data[0][file]">
                                                <span id="filepreview"></span>
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                            </div>



                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <label for="exampleFormControlSelect1"></label>
                                <button id="exampleFormControlSelect2" class="btn btn-warning btn-sm btn-block"
                                    name="draft" value="D">
                                    Save as Draft</button>
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1"></label>
                                <button id="exampleFormControlSelect2" class="btn btn-sm btn-block btn-primary text-white"
                                    name="submit" value="S">
                                    Submit</button>

                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Below code MOdal 2 For Edit Form --}}

    <div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title " id="exampleModalLabel">Fixed Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" id="modalCloseEdit" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='{{ route('admin.parkclaimvariable.update') }}' id="mail-schedular" name="mail-schedular"
                        role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="editParkclaimVariableId" id="editParkclaimVariableId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Current Quarter</label>
                                    <input class="form-control form-control-sm" name="quarter" type="text"
                                        value="{{ $quarter }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Current Financial Year</label>
                                    <input class="form-control form-control-sm" name="fyear" type="text"
                                        value="{{ $year }}" readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">DD</label>
                                    <select class="form-control form-control-sm" id="dd" name="dd">
                                        <option value="" disabled selected="selected">Select Option</option>
                                        <option value="ministry">Ministry</option>
                                        <option value="empower committee">Empower Committee</option>
                                        <option value="mints of meeting">Mints of Meeting</option>
                                        <option value="disbursed">Disbursed</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Remark</label>
                                    <input type="text" name="editremark" id="editremark"
                                        class="form-control form-control-sm" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formFile" class="form-label">MOU Upload</label>
                                    <input class="form-control form-control-sm" type="file" id="mouFile"
                                        name="mouFile" value="">
                                    <input type="hidden" name="mom_upload_id" id="mom_upload_id">
                                    <span id="moufilepreview"></span>
                                </div>
                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-12 table-responsive rounded m-0 p-0">

                                <div style="height: 20px; clear:both;"></div>
                                <table class="table table-bordered table-hover table-sm" id="promTable">
                                    <tr>
                                        <td colspan="10">
                                            <button type="button" id="addProm" name="addProm"
                                                class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add
                                                Rows</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>amount</th>
                                        <th>date</th>
                                        <th>file</th>
                                    </tr>
                                    <tr id='editdata'>
                                    </tr>
                                </table>
                            </div>


                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                            <div class="col-md-2">
                                <button id="exampleFormControlSelect2" class="btn btn-sm btn-block btn-warning text-white"
                                    name="status" value="D">
                                    Update</button>
                            </div>
                            <div class="col-md-3">
                                <a id="finalSubmit" class="btn btn-danger btn-sm form-control form-control-sm">
                                    <i class="fas fa-save"></i> Final Submit
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Third Modal For the View Data --}}

    <div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title " id="exampleModalLabel">Park Claim Variable Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" id="modalCloseView"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Current Quarter</label>
                                <input class="form-control form-control-sm" name="quarter" type="text"
                                    value="{{ $quarter }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect">Current Financial Year</label>
                                <input class="form-control form-control-sm" name="fyear" type="text"
                                    value="{{ $year }}" readonly>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect">DD</label>
                                <input type="text" class="form-control form-control-sm" id="ddview" name="dd" value="" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect">Remark</label>
                                <input type="text"  id="viewremark"
                                    class="form-control form-control-sm" value="" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="formFile" class="form-label">MOU Upload</label>
                                <span id="moufilepreviewview"></span>
                            </div>
                        </div>
                        <div class="col-md-4"></div>

                        <div class="col-md-12 table-responsive rounded m-0 p-0">

                            <div style="height: 20px; clear:both;"></div>
                            <table class="table table-bordered table-hover table-sm" id="promTableview">
                                <tr>
                                    <th>amount</th>
                                    <th>date</th>
                                    <th>file</th>
                                </tr>
                                <tr id='viewdata'>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    {{-- End third modal for the view data --}}

@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.launch-modal').click(function() {
                alert('hello');
                $('#myModal').modal({
                    backdrop: 'static'
                });
            });
        });
    </script>

    <script>
        function GFG_click(clicked) {
            $('#parkClaimVariableId').val(clicked);
        }

        // below js code to open modal edit button
        function editParkClaimVariable(getClickedValue) {

            var id = getClickedValue;
            $('#editParkclaimVariableId').val(getClickedValue);

            $.ajax({
                type: 'get',
                url: '/admin/parkclaimvariable/' + id,
                data: {
                    id: getClickedValue
                },
                dataType: 'json',
                success: function(response) {


                    var lengthofObject = response[1].length;
                   // console.log(response[0].id);

                    $('#edit_schedular_mail_id').val(response[0].id);
                    $('#editremark').val(response[0].remark);
                    $('#dd').val(response[0].dd);
                    $('#mom_upload_id').val(response[0].mou_upload_id);
                    var url = "{{ url('doc/down', '') }}" + "/" + response[0].mou_upload_id;
                    $('#moufilepreview').append('<a href="' + url + '"> Mou File Download</a>');

                    var selectDd = response[0].dd;
                    if (selectDd != '') {
                        $('#dd').find('option:selected').attr('selected', false);
                        $('#dd > option[value="' + selectDd + '"]').attr('selected', true);
                    }


                    $.each(response[1], function(i, item) {
                        //console.log(item.invoice_amt);
                        var url = "{{ url('doc/down', '') }}" + "/" + item.doc_upload_id;
                        $("#promTable").append(
                            '<tr>' +
                            '<td><input type="text" name="data[' + i + '][amt]" value="' + item
                            .invoice_amt + '"  class="form-control form-control-sm"></td>' +
                            '<td><input type="date" name="data[' + i + '][date]" value="' + item
                            .invoice_date + '"  class="form-control form-control-sm"></td>' +
                            '<td><input type="file" name="data[' + i +
                            '][file]" value=""  class="form-control form-control-sm"> <a href="' +
                            url + '"> File Download</a><input type="hidden" name="data[' + i +
                            '][doc_upload_id]" value="' + item.doc_upload_id +
                            '" ><input type="hidden" name="data[' + i +
                            '][id]" value="' + item.id + '" ></td>'
                        );
                    });
                }

            });
        }
        // view data js below

        function viewParkClaimVariableList(getClickedValue) {

            var id = getClickedValue;
            $.ajax({
                type: 'get',
                url: '/admin/parkclaimvariable/view/' + id,
                // data: {
                //     id: getClickedValue
                // },
                dataType: 'json',
                success: function(response) {
                    $('#viewremark').val(response[0].remark);
                    $('#ddview').val(response[0].dd);
                    $('#dd').val(response[0].dd);
                    var url = "{{ url('doc/down', '') }}" + "/" + response[0].mou_upload_id;
                    $('#moufilepreviewview').append('<a href="' + url + '"> Mou File Download</a>');


                    $.each(response[1], function(i, item) {
                        //console.log(item.invoice_amt);
                        var url = "{{ url('doc/down', '') }}" + "/" + item.doc_upload_id;
                        $("#promTableview").append(
                            '<tr>' +
                            '<td><input type="text"  value="' + item
                            .invoice_amt + '"  class="form-control form-control-sm" readonly></td>' +
                            '<td><input type="date" value="' + item
                            .invoice_date + '"  class="form-control form-control-sm" readonly></td>' +
                            '<td> <a href="' +
                            url + '"> File Download</a></td>'
                        );
                    });

                }

            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#finalSubmit").click(function(event) {
                var a = $("#editParkclaimVariableId").val();
                event.preventDefault();
                var links = '/admin/parkclaimvariable/finalsubmit';
                swal({

                        title: "Are you sure you want to submit this form?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        closeOnClickOutside: false,
                    })
                    .then((value) => {
                        if (value) {
                            window.location.href = links + '/' + a;
                        }
                    });
            });

        });
    </script>

    <script>
        // below code for edit section
        var promCnt = $('input[name^="prom"]').length / 5;
        var rowCount = $('#promTable tr').length;
        $('#addProm').click(function() {
            $("#promTable").append(
                '<tr>' +
                '<td><input type="text" name="data[' + rowCount +
                '][amt]"  class="form-control form-control-sm"></td>' +
                '<td><input type="date" name="data[' + rowCount +
                '][date]" class="form-control form-control-sm"></td>' +
                '<td><input type="file" name="data[' + rowCount +
                '][file]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-prom">Remove</button></td>'
            );
            promCnt++;
            rowCount++;

            $(document).on('click', '.remove-prom', function() {
                $(this).parents('tr').remove();
            });
        });

        // below code for create section
        var promCntss = $('input[name^="prom"]').length / 5;
        var i = 1;
        $('#claimVariable').click(function() {
            $("#claimVariableTable").append(
                '<tr>' +
                '<td><input type="text" name="data[' + i +
                '][amt]"  class="form-control form-control-sm"></td>' +
                '<td><input type="date" name="data[' + i +
                '][date]" class="form-control form-control-sm"></td>' +
                '<td><input type="file" name="data[' + i +
                '][file]" class="form-control form-control-sm"></td>' +
                '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-prom">Remove</button></td>'
            );
            promCntss++;
            i++;

            $(document).on('click', '.remove-prom', function() {
                $(this).parents('tr').remove();
            });
        });

        $('#modalCloseEdit').click(function() {
            location.reload();
        });

        $('#modalCloseView').click(function() {
            location.reload();
        });
    </script>



    {!! JsValidator::formRequest('App\Http\Requests\ParlClaimVariableList', '#mail-schedular') !!}
@endpush
