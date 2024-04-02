<style>
    .modal-lg {
        max-width: 180% !important;
    }

    .table-responsive {
        font-size: 13px !important;
    }

</style>
<div class="modal fade" id="PendingQrr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <a data-dismiss="modal" class="float-right" style="margin-left: auto;"><i
                    class="fas fa-window-close"></i></a>
            <div>
                <div class="card-header text-bold">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="appPhase1" data-toggle="tab" href="#appPhase1pending"
                                        role="tab" aria-controls="appPhase1pending" aria-selected="true">QRR for
                                        Applications Round
                                        I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase2" data-toggle="tab" href="#appPhase2pending"
                                        role="tab" aria-controls="appPhase2pending" aria-selected="false">QRR for
                                        Applications
                                        Round II</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase3" data-toggle="tab" href="#appPhase3pending"
                                        role="tab" aria-controls="appPhase3pending" aria-selected="false">QRR for
                                        Applications
                                        Round III</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appPhase4" data-toggle="tab" href="#appPhase4pending"
                                        role="tab" aria-controls="appPhase4pending" aria-selected="false">QRR for
                                        Applications
                                        Round IV</a>
                                </li>
                                <li class="pt-2">
                                <!-- <div class="col-md-2" style="float:right; padding:0;"> -->
                                            <a href="{{ route('admin.qrr.exportall', ['qtr' => $qtr,'type'=>'P']) }}" class="btn btn-sm btn-warning"
                                                style="">Export All Data (Excel)</a>
                                        <!-- </div> -->
                                </li>
                                <div class="col-md-4">
                                    <div class="progress-group">
                                        @if ($qtr == 202101)
                                            <span class="col-form-label col-form-label-sm text-danger">Pending QRR<b
                                                    class="text-dark"> - JUNE-2021</b></span>
                                        @else
                                            <span class="col-form-label col-form-label-sm text-danger">Pending QRR<b
                                                    class="text-dark"> -
                                                    {{ $currcolumnName->month }}-{{ $currcolumnName->yr_short }}</b></span>
                                        @endif
                                        <span class="float-right"><b
                                                class="text-danger">{{ $notfillqrr }}</b>/{{ $totalqrr }}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ ($fillqrr / $totalqrr) * 100 }}%">
                                            </div>
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ ($notfillqrr / $totalqrr) * 100 }}%">
                                            </div>
                                            
                                        </div>
                                       
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="appPhase1pending" role="tabpanel"
                        aria-labelledby="appPhase1pending-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body p-1 py-3">
                                        <div class="table-responsive">
                                            <table style="width: 100%"
                                                class="table table-sm table-striped table-bordered table-hover"
                                                id="ts1">
                                                <thead class="appstable-head">
                                                    <tr class="table-info">
                                                        <th class="text-center w-auto p-3">Sr No</th>
                                                        <th class="text-center w-auto p-3">Application No</th>
                                                        <th class="text-center w-auto p-3">Organization Name</th>
                                                        <th class="text-center w-auto p-3">Eligible Product</th>
                                                        <th class="text-center w-auto p-3">Target Segment</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="appstable-body">
                                                    @php
                                                        $key = 1;
                                                    @endphp
                                                    @foreach ($pending_qrr as $item)
                                                        @if ($item->round == '1')
                                                            <tr>
                                                                <td>{{ $key++ }}</td>
                                                                <td>{{ $item->app_no }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->product }}</td>
                                                                <td>{{ $item->target_segment }}</td>
                                                            </tr>
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

                    <div class="tab-pane fade  show" id="appPhase2pending" role="tabpane2"
                        aria-labelledby="appPhase2pending-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body p-1 py-3">
                                        <div class="table-responsive">
                                            <table style="width: 100%"
                                                class="table table-sm table-striped table-bordered table-hover"
                                                id="ts2">
                                                <thead class="appstable-head">
                                                    <tr class="table-info">
                                                        <th class="text-center w-auto p-3">Sr No</th>
                                                        <th class="text-center w-auto p-3">Application No</th>
                                                        <th class="text-center w-auto p-3">Organization Name</th>
                                                        <th class="text-center w-auto p-3">Eligible Product</th>
                                                        <th class="text-center w-auto p-3">Target Segment</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="appstable-body">
                                                    @php
                                                        $key = 1;
                                                    @endphp
                                                    @foreach ($pending_qrr as $item)
                                                        @if ($item->round == '2')
                                                            <tr>
                                                                <td>{{ $key++ }}</td>
                                                                <td>{{ $item->app_no }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->product }}</td>
                                                                <td>{{ $item->target_segment }}</td>
                                                            </tr>
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

                    <div class="tab-pane fade  show" id="appPhase3pending" role="tabpane3"
                        aria-labelledby="appPhase3pending-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body p-1 py-3">
                                        <div class="table-responsive">
                                            <table style="width: 100%"
                                                class="table table-sm table-striped table-bordered table-hover"
                                                id="ts2">
                                                <thead class="appstable-head">
                                                    <tr class="table-info">
                                                        <th class="text-center w-auto p-3">Sr No</th>
                                                        <th class="text-center w-auto p-3">Application No</th>
                                                        <th class="text-center w-auto p-3">Organization Name</th>
                                                        <th class="text-center w-auto p-3">Eligible Product</th>
                                                        <th class="text-center w-auto p-3">Target Segment</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="appstable-body">
                                                    @php
                                                        $key = 1;
                                                    @endphp
                                                    @foreach ($pending_qrr as $item)
                                                        @if ($item->round == '3')
                                                            <tr>
                                                                <td>{{ $key++ }}</td>
                                                                <td>{{ $item->app_no }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->product }}</td>
                                                                <td>{{ $item->target_segment }}</td>
                                                            </tr>
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

                    <div class="tab-pane fade  show" id="appPhase4pending" role="tabpane4"
                        aria-labelledby="appPhase4pending-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body p-1 py-3">
                                        <div class="table-responsive">
                                            <table style="width: 100%"
                                                class="table table-sm table-striped table-bordered table-hover"
                                                id="ts2">
                                                <thead class="appstable-head">
                                                    <tr class="table-info">
                                                        <th class="text-center w-auto p-3">Sr No</th>
                                                        <th class="text-center w-auto p-3">Application No</th>
                                                        <th class="text-center w-auto p-3">Organization Name</th>
                                                        <th class="text-center w-auto p-3">Eligible Product</th>
                                                        <th class="text-center w-auto p-3">Target Segment</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="appstable-body">
                                                    @php
                                                        $key = 1;
                                                    @endphp
                                                    @foreach ($pending_qrr as $item)
                                                        @if ($item->round == '4')
                                                            <tr>
                                                                <td>{{ $key++ }}</td>
                                                                <td>{{ $item->app_no }}</td>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->product }}</td>
                                                                <td>{{ $item->target_segment }}</td>
                                                            </tr>
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
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            var t = $('#ts1').DataTable({
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

        $(document).ready(function() {
            var t = $('#ts2').DataTable({
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
    </script>
@endpush
