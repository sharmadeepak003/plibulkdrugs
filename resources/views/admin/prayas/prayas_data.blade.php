@extends('layouts.adminshared.master')

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
        <div class="col-md-12">
            <form action="{{ route('admin.praysdetail') }}" id="qrr-vehicledva" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">

                @csrf
                <div class="row mb-4 mt-2">
                    <div class="col-md-3 offset-md-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect">Select Year</label>
                            <select class="form-control" id="exampleFormControlSelect" required name="fyear">
                                <option value="">Please Select Year</option>
                                @foreach ($qtr as $item)
                                    <option value="{{ $item->fy }}">{{ $item->fy }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Quarter</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="quarter" required>
                                <option value="">Select</option>
                                <option value="1">Quarter 1</option>
                                <option value="2">Quarter 2</option>
                                <option value="3">Quarter 3</option>
                                <option value="4">Quarter 4</option>

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

            

            <!-- Current Application-->

            {{-- @if ($qtrval)
                <span class="text-danger" style="text-align: left"><b>2022-23(3rd Qtr)</b></span>
            @else --}}
            {{-- @endif --}}

            {{-- @if (count($pushdata) > 0) --}}

            <form action="{{ route('adminshared.prayas.data') }}" id="qrr-vehicledva" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                {{-- {!! method_Rfield('patch') !!} --}}

                @csrf

                {{-- @else --}}

                {{-- <form action="{{ route('adminshared.prayas.store') }}" id="qrr-vehicledva" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                accept-charset="utf-8">
                {{-- {!! method_field('patch') !!} --}}

                {{-- @csrf --}}

            {{-- @endif --}}

                {{-- {{dd($qtrval)}} --}}


                <div class="card border-primary">
                    <div class="card-header text-white bg-primary border-primary">
                        <h5> Quarterly Review Report Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table id="apishowdata" class="table table-sm  table-bordered table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Company Code</th>
                                                <th class="text-justify">Name of Selected Beneficiary </th>
                                                <th >Target Segment**</th>
                                                <th>Estimated Investement (in Cr)</th>
                                                <th>Estimated Sales (in Cr)</th>
                                                <th>Estimated Exports (in Cr)</th>
                                                <th>Estimated Employment (in Number)</th>
                                                <th>Estimated DVA (in %)</th>
                                                <th>Actual Investement (in Cr)</th>
                                                <th>Actual Sales (in Cr)</th>
                                                {{-- <th>Actual Exports (in Cr)</th> --}}
                                                <th>Actual Employment (in Number)</th>
                                                {{-- <th>Actual DVA (in %)</th> --}}
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>



                                            {{-- @foreach ($detail as $key=> $val) --}}
                                            {{-- <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val->user_id }}</td>
                                            <td>{{ $val->company_name }}</td>
                                            <td>{{ $val->target_seg }}</td>
                                            <td>{{ $val->inv }}</td>
                                            <td>{{ $val->esti_sale }}</td>
                                            <td>{{ $val->exp_sale }}</td>
                                            <td>{{ $val->emp }}</td>
                                            <td>{{ $val->esti_dva }}</td>
                                            <td>{{ $val->actual_inv }}</td>
                                            <td>{{ $val->tardomsale }}</td> --}}
                                            {{-- <td>{{ $val->actual_exports }}</td> --}}
                                            {{-- <td>{{ $val->actual_emp }}</td> --}}
                                            {{-- <td>{{ $val->actual_dva }}</td> --}}
                                            {{-- <td> <a href="{{route('adminshared.praysdetailedit',[$val->company_code,$val->quarter])}}"class="btn btn-primary btn-sm btn-block">Edit</a></td> --}}


                                            {{-- </tr> --}}


                                            {{-- <tr> --}}
                                                {{-- {{dd($val->id)}} --}}
                                                {{-- <input type="hidden" value="{{$qtrval}}" name="qtr">

                                                <input type="hidden" name="fy" id="" value="{{$val->fy}}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td >
                                                    <input type="number" name="prayas[{{$key}}][com_code]"
                                                    class="form-control form-control-sm valid"
                                                    value="{{ $val->company_code }}" readonly>
                                                    <input type="hidden" value="{{$val->id}}" name="prayas[{{$key}}][id]">
                                                </td>
                                                <td style="width: 35%">
                                                    <input type="text" name="prayas[{{$key}}][company_name]"
                                                        class="form-control form-control-sm valid"
                                                        value="{{ $val->name_selected_beneficiary }}" readonly>

                                                </td>
                                                <td style="width: 25%">
                                                    <input type="text" name="prayas[{{$key}}][target_seg]"
                                                    class="form-control form-control-sm valid"
                                                    value="{{ $val->target_segment }}" readonly>
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][esti_inv]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->estimated_investement }}">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][esti_sales]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->estimated_sales }}">
                                                </td>
                                                <td style="width: 5%">

                                                    <input type="number" name="prayas[{{$key}}][esti_export]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->estimated_exports }}">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][esti_employ]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->estimated_employment }}">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][esti_dva]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->estimated_dva }}">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][actual_inv]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->actual_investemen }}">
                                                </td>
                                                <td style="width: 5%">
                                                    <input type="number" name="prayas[{{$key}}][actual_sale]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->actual_sales }}">
                                                </td> --}}
                                                {{-- <td>{{ $val->actual_exports }}</td> --}}
                                                {{-- <td style="width: 5%">

                                                    <input type="number" name="prayas[{{$key}}][actual_emp]"
                                                    class="form-control form-control-sm valid text-right"
                                                    value="{{ $val->actual_employment }}">

                                                </td> --}}
                                                {{-- <td>{{ $val->actual_dva }}</td> --}}
                                                {{-- <td> <a href="{{route('adminshared.praysdetailedit',[$val->company_code,$val->quarter])}}"class="btn btn-primary btn-sm btn-block">Edit</a></td> --}}


                                            {{-- </tr>
                                            @endforeach
 --}}
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-2 offset-md-5">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" disabled><i
                                class="fas fa-save" ></i>
                            Save as Draft</button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <a href="" class="btn btn-warning btn-sm form-control form-control-sm" style="pointer-events: none">Push to prayas<i
                                class="fas fa-angle-double-right" ></i></a>
                    </div>
                </div>
            </form>
        </div>
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
    </script>
@endpush
