@extends('layouts.admin.master')
@section('title')
    Quarterly Review Report Summary
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
        <div class="col-md-10">
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.prayas.download.excelformat') }}" class="btn btn-success"> Download CSV File
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.praysdetail') }}" id="qrr-vehicledva" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                <input type="hidden" name="project_code" id="" value="{{ $codes->id }}">
                <input type="hidden" name="instance_code" id="" value="{{ $codes->instance_code }}">
                <input type="hidden" name="sec_code" id="" value="{{ $codes->sec_code }}">
                <input type="hidden" name="ministry_code" id="" value="{{ $codes->ministry_code }}">
                <input type="hidden" name="dept_code" id="" value="{{ $codes->dept_code }}">
                <input type="hidden" name="freq_code" id="" value="{{ $codes->freq_code }}">
                <input type="hidden" name="freq_name" id="" value="{{ $codes->freq_name }}">

                @csrf
                <div class="row mb-4 mt-2">
                    <div class="col-md-3 offset-md-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect">Select Year</label>
                            <select class="form-control" id="exampleFormControlSelect" required name="fyear">
                                <option value="">Please Select Year</option>
                                @foreach ($qtr as $item)
                                    {{-- <option value="{{ $item->fy }}"  @if (count($detail) > 0)@if ($item->fy == $detail[0]->fy)selected @endif @endif>{{ $item->fy }}</option> --}}
                                    <option value="{{ $item->fy }}"
                                        @if (!empty($selectedFy)) @if ($item->fy == $selectedFy)selected @endif
                                        @endif>{{ $item->fy }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Quarter</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="quarter" required>
                                <option value="">Select</option>
                                <option value="1"
                                    @if (count($detail) > 0) @if (substr($qtrval, 5, 6) == '1')selected @endif
                                    @endif>Quarter 1</option>
                                <option value="2"
                                    @if (count($detail) > 0) @if (substr($qtrval, 5, 6) == '2')selected @endif
                                    @endif>Quarter 2</option>
                                <option value="3"
                                    @if (count($detail) > 0) @if (substr($qtrval, 5, 6) == '3')selected @endif
                                    @endif>Quarter 3</option>
                                <option value="4"
                                    @if (count($detail) > 0) @if (substr($qtrval, 5, 6) == '4')selected @endif
                                    @endif>Quarter 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="exampleFormControlSelect2">Submit</label>
                        <button id="exampleFormControlSelect2" class="btn btn-sm btn-block btn-primary text-white">
                            Filter</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <form id="uploadForm" enctype="multipart/form-data">
        <div class="row">

            <div class="col-md-2"></div>
            <div class="col-md-4 ">
                <input type="hidden" name="fy" value="{{ $selectedFy }}" />
                <input type="hidden" name="qtrval" value="{{ $qtrval }}" />
                    <input class="form-control" type="file" id="formFile" name="formFile" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-block btn-primary text-white" name="submit" value="S">
                    Submit
                </button>
            </div>



        </div>
    </form>
    <br>
    <form action="{{ route('admin.prayas.data') }}" id="prayasnew" role="form" method="post"
        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
        @csrf

        <input type="hidden" name="project_code" id="" value="{{ $codes->project_code }}">
        <input type="hidden" name="instance_code" id="" value="{{ $codes->instance_code }}">
        <input type="hidden" name="sec_code" id="" value="{{ $codes->sec_code }}">
        <input type="hidden" name="ministry_code" id="" value="{{ $codes->ministry_code }}">
        <input type="hidden" name="dept_code" id="" value="{{ $codes->dept_code }}">
        <input type="hidden" name="freq_code" id="" value="{{ $codes->freq_code }}">
        <input type="hidden" name="freq_name" id="" value="{{ $codes->freq_name }}">
        <input type="hidden" name="date" id="" value="{{ $date[0]->to_data }}">

       
        <div class="card border-primary">
            <div class="card-header text-white bg-primary border-primary">
                <h5> Quarterly Review Report Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table id="apishowdata" class="table table-sm  table-bordered table-hover"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Company Code</th>
                                        <th class="text-justify">Name of Selected Beneficiary </th>
                                        <th>Target Segment**</th>
                                        <th>Estimated Investement (in Cr)</th>
                                        <th>Actual Investement (in Cr)</th>
                                        <th>Estimated Sales (in Cr)</th>
                                        <th>Actual Sales (in Cr)</th>
                                        <th>Estimated Exports (in Cr)</th>
                                        <th>Actual Exports (in Cr)</th>
                                        <th>Estimated Employment (in Number)</th>
                                        <th>Actual Employment (in Number)</th>
                                        <th>Estimated DVA (in %)</th>
                                        <th>Actual DVA(in %)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $key => $val)
                                        @if (!$frz_data)
                                            <tr>
                                                <input type="hidden" value="{{ $qtrval }}" name="qtr">

                                                <input type="hidden" name="fy" id=""
                                                    value="{{ $val->fy }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="number" name="prayas[{{ $key }}][com_code]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->company_code }}" readonly>
                                                    <input type="hidden" value="{{ $val->id }}"
                                                        name="prayas[{{ $key }}][id]">
                                                </td>
                                                <td style="width: 35%">
                                                    <input type="text"
                                                        name="prayas[{{ $key }}][company_name]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->name_selected_beneficiary }}" readonly>

                                                </td>
                                                <td style="width: 25%">
                                                    <input type="text" name="prayas[{{ $key }}][target_seg]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->target_segment }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_inv]"
                                                        id="fieldName"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_investement }}" step="0.001">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_inv]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_investemen }}" step="0.001">
                                                </td>

                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_sales]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_sales }}" step="0.001">
                                                </td>

                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_sale]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_sales }}" step="0.001">
                                                </td>

                                                <td style="width: 5%">

                                                    <input type="number" name="prayas[{{ $key }}][esti_export]"
                                                        class="form-control form-control-sm valid text-righ readprayasdata"
                                                        value="{{ $val->estimated_exports }}" step="0.001">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number"
                                                        name="prayas[{{ $key }}][actual_exports]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ isset($val->actual_exports) ? $val->actual_exports : '0' }}"
                                                        step="0.001">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_employ]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_employment }}" step="0.001">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_emp]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_employment }}" step="0.001">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_dva]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_dva }}" step="0.001">
                                                </td>

                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_dva]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_dva }}" step="0.001">
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <input type="hidden" value="{{ $qtrval }}" name="qtr">
                                                <input type="hidden" name="fy" id=""
                                                    value="{{ $val->fy }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="number" name="prayas[{{ $key }}][com_code]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->company_code }}" readonly>
                                                    <input type="hidden" value="{{ $val->id }}"
                                                        name="prayas[{{ $key }}][id]">
                                                </td>
                                                <td style="width: 35%">
                                                    <input type="text"
                                                        name="prayas[{{ $key }}][company_name]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->name_selected_beneficiary }}" readonly>

                                                </td>
                                                <td style="width: 25%">
                                                    <input type="text" name="prayas[{{ $key }}][target_seg]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->target_segment }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_inv]"
                                                        id="fieldName"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_investement }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_inv]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_investemen }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_sales]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_sales }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_sale]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_exports }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_export]"
                                                        class="form-control form-control-sm valid text-righ readprayasdata"
                                                        value="{{ $val->estimated_exports }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number"
                                                        name="prayas[{{ $key }}][actual_exports]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ isset($val->actual_exports) ? $val->actual_exports : '0' }}"
                                                        readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_employ]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_employment }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_emp]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_employment }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][esti_dva]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->estimated_dva }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{ $key }}][actual_dva]"
                                                        class="form-control form-control-sm valid text-right readprayasdata"
                                                        value="{{ $val->actual_dva }}" readonly>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                                <tr>
                                    <td colspan="4" style="text-align: center;"><b>Total</b></td>

                                    <td class="text-right">
                                        {{ empty($detail) ? 'N/A' : $detail->sum('estimated_investement') }}</td>
                                    <td class="text-right">
                                        {{ empty($detail) ? 'N/A' : $detail->sum('actual_investemen') }}</td>
                                    <td class="text-right">{{ empty($detail) ? 'N/A' : $detail->sum('estimated_sales') }}
                                    </td>
                                    <td class="text-right">{{ empty($detail) ? 'N/A' : $detail->sum('actual_sales') }}
                                    </td>
                                    <td class="text-right">
                                        {{ empty($detail) ? 'N/A' : $detail->sum('estimated_exports') }}</td>
                                    <td class="text-right">{{ empty($detail) ? 'N/A' : $detail->sum('actual_exports') }}
                                    </td>
                                    <td class="text-right">
                                        {{ empty($detail) ? 'N/A' : $detail->sum('estimated_employment') }}</td>
                                    <td class="text-right">
                                        {{ empty($detail) ? 'N/A' : $detail->sum('actual_employment') }}</td>
                                    <td class="text-right">{{ empty($detail) ? 'N/A' : $detail->sum('estimated_dva') }}
                                    </td>
                                    <td class="text-right">{{ empty($detail) ? 'N/A' : $detail->sum('actual_dva') }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($frz_data)
            <div class="row pb-2">
                <div class="col-md-2 ">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" disabled><i
                            class="fas fa-save"> </i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="button" class="btn btn-primary btn-sm form-control form-control-sm" id="newdata"><i
                            class="fas fa-save"></i>
                        Freez data</button>
                </div>

                <div class="col-md-2 offset-md-3">
                    <button href="" type="button" class="btn btn-warning btn-sm form-control form-control-sm"
                        disabled>Push to prayas<i class="fas fa-angle-double-right"></i></button>
                </div>
            </div>
        @else
            <div class="row pb-2">
                <div class="col-md-2 ">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="button" class="btn btn-primary btn-sm form-control form-control-sm" id="newdata"><i
                            class="fas fa-save"></i>
                        Freez data</button>
                </div>

                <div class="col-md-2 offset-md-3">
                    <button href="" type="button" class="btn btn-warning btn-sm form-control form-control-sm"
                        disabled>Push to prayas<i class="fas fa-angle-double-right"></i></button>
                </div>
            </div>
        @endif


    </form>
    </div>
@endsection
@push('scripts')
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js></script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(event) {

                event.preventDefault(); // Prevent default form submission
                console.log(this);
                var formData = new FormData(this);
                console.log(formData);
                $.ajax({
                    url: '/admin/prayas/excel/data',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        alert('Your Data Insert Successfully');

                        // Dynamically create a form
                        var form = $('<form action="/admin/praysdetail" method="POST"></form>');

                        // Add CSRF token as a hidden input
                        form.append('<input type="hidden" name="_token" value="' + $(
                            'meta[name="csrf-token"]').attr('content') + '">');

                        // Add other parameters as hidden inputs
                        form.append(
                            '<input type="hidden" name="fyear" value="{{ $selectedFy }}">'
                            );
                        form.append(
                            '<input type="hidden" name="quarter" value="{{ substr($qtrval, 5, 6) }}">'
                            );
                        form.append(
                            '<input type="hidden" name="project_code" value="{{ $codes->id }}">'
                            );
                        form.append(
                            '<input type="hidden" name="instance_code" value="{{ $codes->instance_code }}">'
                            );
                        form.append(
                            '<input type="hidden" name="sec_code" value="{{ $codes->sec_code }}">'
                            );
                        form.append(
                            '<input type="hidden" name="ministry_code" value="{{ $codes->ministry_code }}">'
                            );
                        form.append(
                            '<input type="hidden" name="dept_code" value="{{ $codes->dept_code }}">'
                            );
                        form.append(
                            '<input type="hidden" name="freq_code" value="{{ $codes->freq_code }}">'
                            );
                        form.append(
                            '<input type="hidden" name="freq_name" value="{{ $codes->freq_name }}">'
                            );
                        form.append('<input type="hidden" name="through" value="Excel">');

                        // Append form to body and submit
                        $('body').append(form);
                        form.submit();

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Something Went Wrong');
                    }
                });

            });
        });





        $(document).ready(function() {
            var t1 = $('#apishowdata').DataTable({
                "iDisplayLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel'
                ],

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

            t1.on('order.dt search.dt', function() {
                t1.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        });

        $(document).ready(function() {
            $("#newdata").click(function() {
                swal({
                        title: "Are you sure?",
                        text: "Once Freeze data , you will not be able to edit data !",
                        icon: "warning",
                        buttons: true,
                    })
                    .then((ok) => {
                        if (ok) {
                            jQuery.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: "/admin/prayas/excel_data",
                                data: $('#prayasnew').serialize(),
                                dataType: "json",
                                success: function(data) {
                                    var qtr = data.qtr;
                                    var project_code = data.project_code;
                                    var date = data.date;

                                    window.location = '/admin/prayas/fixdata/' + qtr + '/' +
                                        project_code + '/' + date;
                                }
                            })
                            $('.readprayasdata').attr("disabled", true);
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });

        });
    </script>
@endpush
