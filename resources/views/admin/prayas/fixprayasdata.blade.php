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
    <div class="col-12">
        <form action="{{ route('admin.praysdetail') }}" id="qrr-vehicledva" role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" name="project_code" id="" value="{{$codes->id}}">
            <input type="hidden" name="instance_code" id="" value="{{$codes->instance_code}}">
            <input type="hidden" name="sec_code" id="" value="{{$codes->sec_code}}">
            <input type="hidden" name="ministry_code" id="" value="{{$codes->ministry_code}}">
            <input type="hidden" name="dept_code" id="" value="{{$codes->dept_code}}">
            <input type="hidden" name="freq_code" id="" value="{{$codes->freq_code}}">
            <input type="hidden" name="freq_name" id="" value="{{$codes->freq_name}}">
           <!-- <input type="hidden" name="qtrval" id="" value="{{$qtrval}}"> -->
           
            <div class="row mb-4 mt-2">
                <div class="col-3 offset-md-2">
                    <div class="form-group">
                        <label for="exampleFormControlSelect">Select Year</label>
                        <select class="form-control" id="exampleFormControlSelect" required name="fyear">
                            <option value="">Please Select Year</option>
                            @foreach ($qtr as $item)
                            <option value="{{ $item->fy }}" @if($item->fy==$detail[0]->fy)selected @endif>{{ $item->fy }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Quarter</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="quarter" required>
                            <option value="">Select</option>
                            <option value="1" @if(substr($qtrval,5,6)=="1")selected @endif>Quarter 1</option>
                            <option value="2" @if(substr($qtrval,5,6)=="2")selected @endif>Quarter 2</option>
                            <option value="3" @if(substr($qtrval,5,6)=="3")selected @endif>Quarter 3</option>
                            <option value="4" @if(substr($qtrval,5,6)=="4")selected @endif>Quarter 4</option>
                        </select>
                    </div>
                </div>

                <div class="col-2 mt-2">
                    <label for="exampleFormControlSelect2">Submit</label>
                    <button id="exampleFormControlSelect2" class="btn btn-sm btn-block btn-primary text-white">
                        Filter</button>

                </div>
            </div>
        </form>
    </div>
</div>

    <form action="{{ route('admin.prayas.data') }}" id="prayasnew" role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
        @csrf
        <div class="card border-primary">
            <div class="card-header text-white bg-primary border-primary">
                <h5> Quarterly Review Report Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="table-responsive">
                            <table id="apishowdata" class="table table-sm  table-bordered table-hover" style="width: 100%">
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
                                        <th>Actual DVA (in %)</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($detail as $key => $val)
                                        <tr>
                                        <input type="hidden" value="{{ $qtrval }}" name="qtr">
                                        <input type="hidden" name="fy" id="" value="{{ $val->fy }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <input readonly type="number" name="prayas[{{ $key }}][com_code]" class="form-control form-control-sm valid" value="{{ $val->company_code }}" readonly>
                                            <input readonly type="hidden" value="{{ $val->id }}" name="prayas[{{ $key }}][id]">
                                        </td>
                                        <td style="width: 35%">
                                            <input readonly type="text" name="prayas[{{ $key }}][company_name]" class="form-control form-control-sm valid" value="{{ $val->name_selected_beneficiary }}" readonly>

                                        </td>
                                        <td style="width: 25%">
                                            <input readonly type="text" name="prayas[{{ $key }}][target_seg]" class="form-control form-control-sm valid" value="{{ $val->target_segment }}" readonly>
                                        </td>
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][esti_inv]" id="fieldName" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->estimated_investement }}">
                                        </td>
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][actual_inv]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->actual_investemen }}">
                                        </td>

                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][esti_sales]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->estimated_sales }}">
                                        </td>
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][actual_sale]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->actual_sales }}">
                                        </td>

                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][esti_export]" class="form-control form-control-sm valid text-righ readprayasdata" value="{{ $val->estimated_exports }}">
                                        </td>

                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][actual_exports]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ isset($val->actual_exports) ? $val->actual_exports : '0' }}">
                                        </td>

                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][esti_employ]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->estimated_employment }}">
                                        </td>
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][actual_emp]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->actual_employment }}">

                                        </td>
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][esti_dva]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ $val->estimated_dva }}">
                                        </td>
                        
                                        <td style="width: 5%">
                                            <input readonly type="number" name="prayas[{{ $key }}][actual_dva]" class="form-control form-control-sm valid text-right readprayasdata" value="{{ isset($val->actual_dva) ? $val->actual_dva : '0' }}">

                                        </td>
                                    </tr>
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

        <div class="row pb-2">
            <div class="col-2 offset-md-5">
                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" disabled><i class="fas fa-save"></i>
                    Save as Draft</button>
            </div>

            <div class="col-2 offset-md-3">
                <a href="{{route('admin.prayas.pushdata', [$codes->id,$date])}}" type="button" class="btn btn-warning btn-sm form-control form-control-sm" id="newdata">Push to prayas<i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    </form>
</div>


@endsection
@push('scripts')
<script src=https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js></script>
<script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js></script>
<script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js></script>
<script>
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

    // $(document).ready(function() {
    //     $("#newdata").click(function() {
    //         swal({
    //                 title: "Are you sure?",
    //                 text: "Once deleted, you will not be able to recover this imaginary file!",
    //                 icon: "warning",
    //                 buttons: true,
    //                 // dangerMode: true,
    //             })
    //             .then((ok) => {
    //                 if (ok) {
    //                     jQuery.ajax({
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                             type: "POST",
    //                             url: "/shared/prayas/excel_data",
    //                             data: $('#prayasnew').serialize(),
    //                             dataType: "json",
    //                             success: function(data) {

    //                                 var qtr = data.qtr;

    //                                 window.location = 'prayas/dash/' + qtr ;
    //                             }
    //                         })
    //                         $('.readprayasdata').attr("disabled", true)




    //                 } else {
    //                     swal("Your imaginary file is safe!");
    //                 }
    //             });

    //     });

    // });
</script>
@endpush