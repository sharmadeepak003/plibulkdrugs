@extends('layouts.user.dashboard-master')

@section('title')
    QRR Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row" style="margin-left: 14%;">
        <div class="col-md-2">
            <label>Select Quarter</label>
        </div>
        <div class="col-md-2">
            {{-- <select name="target_id" id="target_id" class="form-control form-control-sm" style="width: 100%;">
                <option @if ($qrrName == '202101') selected @endif value="202101">June, 2021-22</option>
                <option @if ($qrrName == '202102') selected @endif value="202102">Sept, 2021-22</option>
                <option @if ($qrrName == '202103') selected @endif value="202103">Dec, 2021-22</option>
                <option @if ($qrrName == '202104') selected @endif value="202104">Mar, 2022-23</option>
                <option @if ($qrrName == '202201') selected @endif value="202201">June, 2022-23</option>
            </select> --}}

            {{-- Ajaharuddin Ansari  --}}
            <select name="target_id" id="target_id" class="form-control form-control-sm" style="width: 100%;">
                @foreach ($qtrMast as $qtr1)
                    @if ($qtr1->status=='1')
                        <option value="{{$qtr1->qtr_id}}" @if($qrrName==$qtr1->qtr_id) selected @endif>{{$qtr1->month}},{{$qtr1->year}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-1" style="margin-left:1%;">
            <button id="filterData" class="btn btn-sm btn-block btn-primary text-white">
                Filter</button>
        </div>
    </div>
    <br>
    <div class="row" >
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    @if ($qrrName == 202101)
                        <h5 class="text-center">QRR Data For June-21</h5>
                    @else
                        <h5 class="text-center">QRR Data For {{ $currcolumnName->month }}-{{ $currcolumnName->year }}
                        </h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Sr No</th>
                                            <th>Eligible Product</th>
                                            <th>Application No</th>
                                            <th>Quarter</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($apps as $app1)
                                            <tr>
                                                <td class="text-center">{{ $app1->rownum }}</td>
                                                <td>{{ $app1->product }}</td>
                                                <td>{{ $app1->app_no }}</td>
                                                <td>
                                                    @if ($qrrName == 202101)
                                                        June-21
                                                    @else
                                                        {{ $currcolumnName->month }}-{{ $currcolumnName->year }}
                                                    @endif
                                                </td>
                                                @if (in_array($app1->id, $qrrAppIds))
                                                    @foreach ($qrrMast as $qrr)
                                                        @if ($app1->id == $qrr->app_id)
                                                            @if ($qrr->status == 'D')
                                                                <td style="background-color: #f3cccc;"
                                                                    class="text-center">Draft</td>
                                                            @elseif($qrr->status == 'S')
                                                                <td style="background-color: #97f58a;"
                                                                    class="text-center">Submitted</td>
                                                            @else
                                                                <td class="text-center">Not Created</td>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <td class="text-center">Not Created</td>
                                                @endif
                                                <td>
                                                    @if (in_array($app1->id, $qrrAppIds))
                                                        @foreach ($qrrMast as $qrr)
                                                            @if ($app1->id == $qrr->app_id)
                                                                @if ($qrr->status == 'D')
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-sm btn-block"
                                                                        data-toggle="modal"
                                                                        data-target="#editModal{{ $qrr->id }}">
                                                                        Edit
                                                                    </button>
                                                                    @include('user.partials.qrreditModal1')
                                                                @elseif($qrr->status == 'S')
                                                                    <a href="{{ route('qpr.show', $qrr->id) }}"
                                                                        class="btn btn-warning btn-sm btn-block">View</a>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <a href="{{ route('qpr.create', ['id' => $app1->id, 'qrrName' => $qrrName]) }}"
                                                            class="btn btn-success btn-sm btn-block">Create</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('table').DataTable();
            $("#filterData").click(function(event) {
                var tarId = $('#target_id').val();
                var link = '/qpr/getByName/' + tarId;
                window.location.href = link;
            });
        });
    </script>
@endpush
