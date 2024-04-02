@extends('layouts.admin.master')

@section('title')
    Mail Schedular
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
                    <h5> Invoice Schedular Mail List</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="#" class="table table-sm  table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Quater</th>
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
                                        $getCount = count($getSchedularMailFixiedData);
                                        ?>
                                        @if (!empty($getCount))
                                            @foreach ($getSchedularMailFixiedData as $gsmfd)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $gsmfd->qtr_id }}</td>
                                                    <td>{{ $gsmfd->financial_year }}</td>
                                                    <td>{{ $gsmfd->updated_by }}</td>
                                                    <td>{{ $gsmfd->created_at }}</td>
                                                    <td>{{ $gsmfd->remark }}</td>
                                                    <td>
                                                        @if ($gsmfd->status == 'S')
                                                            <span style="color:green; font-size:14px;"> Submit</span>
                                                        @elseif($gsmfd->status == 'D')
                                                            <span style="color:yellow; font-size:14px;"> Draft</span>
                                                        @else
                                                            <span style="color:red; font-size:14px; "> Pending</span>
                                                        @endif


                                                    <td>
                                                        @if ($gsmfd->status == 'S')
                                                            <a class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#exampleModal3" id="{{ $gsmfd->id }}"
                                                            onClick="viewMailSchedular(this.id)"><i class="fa fa-eye"
                                                                    aria-hidden="true"> View</i></a>
                                                        @elseif($gsmfd->status == 'D')
                                                            <a class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal2" id="{{ $gsmfd->id }}"
                                                                onClick="editMailSchedular(this.id)"><i class="fa fa-edit"
                                                                    aria-hidden="true"> Edit</i></a>
                                                        @else
                                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#exampleModal" id="{{ $gsmfd->id }}"
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
                    <h5 class="modal-title " id="exampleModalLabel">Fixed Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='{{ route('admin.mail.schedular.store') }}' id="mail-schedular" name="mail-schedular"
                        role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="schedular_mail_id" id="schedular_mail_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Current Quarter</label>
                                    <input class="form-control" name="quarter" type="text" value="{{ $quarter }}"
                                        readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Current Financial Year</label>
                                    <input class="form-control" name="fyear" type="text" value="{{ $year }}"
                                        readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Document Upload</label>
                                    <input class="form-control" type="file" id="formFile" name="formFile">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceAmount">Invoice Amount</label>
                                    <input type="text" name="invoiceAmount" id="invoiceAmount" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceDate">Invoice Date</label>
                                    <input type="date" class="form-control" name="invoiceDate" id="invoiceDate">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Remark</label>
                                    <textarea class="form-control" name="remark" id="remark" rows="5" cols="30"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <label for="exampleFormControlSelect1"></label>
                                <button id="exampleFormControlSelect2" class="btn btn-warning btn-sm btn-block"
                                    name="draft" value="D">
                                    Save as Draft</button>
                            </div>
                            <div class="col-md-2">
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='{{ route('admin.mail.schedular.update') }}' id="mail-schedular" name="mail-schedular"
                        role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="schedular_mail_id" id="edit_schedular_mail_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Current Quarter</label>
                                    <input class="form-control" name="quarter" type="text"
                                        value="{{ $quarter }}" readonly>
                                    <input type="hidden" id="doc_upload_id" name="doc_upload_id">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Current Financial Year</label>
                                    <input class="form-control" name="fyear" type="text"
                                        value="{{ $year }}" readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Document Upload</label>
                                    <input class="form-control" type="file" id="formFile" name="formFile">
                                    <span id="filepreview"></span>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceAmount">Invoice Amount</label>
                                    <input type="text" name="invoiceAmount" id="invoiceAmounts" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceDate">Invoice Date</label>
                                    <input type="date" class="form-control" name="invoiceDate" id="invoiceDates">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Remark</label>
                                    <textarea class="form-control" name="remark" id="remarks" rows="5" cols="30"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                            <div class="col-md-2">

                                <button id="exampleFormControlSelect2" class="btn btn-sm btn-block btn-warning text-white"
                                    name="submit">
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
                    <h5 class="modal-title " id="exampleModalLabel">Fixed Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <input type="hidden" name="schedular_mail_id" id="edit_schedular_mail_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Current Quarter</label>
                                    <input class="form-control" name="quarter" type="text"
                                        value="{{ $quarter }}" readonly>
                                    <input type="hidden" id="doc_upload_id" name="doc_upload_id">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Current Financial Year</label>
                                    <input class="form-control" name="fyear" type="text"
                                        value="{{ $year }}" readonly>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Document Upload</label>
                                    <br>
                                    <span id="filepreviewforshowonly"></span>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceAmount">Invoice Amount</label>
                                    <input type="text"  id="viewinvoiceAmounts" class="form-control"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoiceDate">Invoice Date</label>
                                    <input type="date" class="form-control"  id="viewinvoiceDates" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect">Remark</label>
                                    <textarea class="form-control" id="viewremarks" rows="5" cols="30" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                           
                            
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

            $('#schedular_mail_id').val(clicked);
            $('#edit_schedular_mail_id').val(clicked);
            //document.getElementById("schedular_mail_id").value = clicked;

        }


        function editMailSchedular(getClickedValue) {
            //alert(getClickedValue);
            var id = getClickedValue;


            $('#edit_schedular_mail_id').val(getClickedValue);
            $.ajax({
                type: 'get',
                url: '/admin/mail/schedularedit/' + id,
                data: {
                    id: getClickedValue
                },
                dataType: 'json',
                success: function(response) {
                    $('#invoiceAmounts').val(response.invoice_amt);
                    $('#invoiceDates').val(response.invoice_date);
                    $('#remarks').val(response.remark);
                    $('#doc_upload_id').val(response.doc_upload_id);

                    var url = "{{ url('doc/down', '') }}" + "/" + response.doc_upload_id;
                    $('#filepreview').append('<a href="' + url + '"> Download File</a>');

                }

            });
        }
        // view data js below

        function viewMailSchedular(getClickedValue) {
           
            var id = getClickedValue;
            $.ajax({
                type: 'get',
                url: '/admin/schedular/fixedmail/' + id,
                data: {
                    id: getClickedValue
                },
                dataType: 'json',
                success: function(data) {
                    $('#viewinvoiceAmounts').val(data.invoice_amt);
                    $('#viewinvoiceDates').val(data.invoice_date);
                    $('#viewremarks').val(data.remark);
                    $('#doc_upload_id').val(data.doc_upload_id);

                    var url = "{{ url('doc/down', '') }}" + "/" + data.doc_upload_id;
                    $('#filepreviewforshowonly').append('<a href="' + url + '"> Download Uploaded File</a>');

                }

            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#finalSubmit").click(function(event) {
                var a = $("#edit_schedular_mail_id").val();
                event.preventDefault();
                var links = 'schedular/finalsubmit';
                swal({

                        title: "Are you sure you want to submit the Invoice Details?",
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

    {!! JsValidator::formRequest('App\Http\Requests\MailSchedular', '#mail-schedular') !!}
@endpush
