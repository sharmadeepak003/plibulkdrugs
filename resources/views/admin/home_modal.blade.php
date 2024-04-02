
<div class="modal fade" id="app1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <a data-dismiss="modal" class="float-right" style="margin-left: auto;"><i
                    class="fas fa-window-close"></i></a>
            <div class="modal-body">
                        <div class="table-responsive">
                            <table style="width: 100%"  class="table table-sm table-striped table-bordered table-hover" id="ts1">
                                <thead>
                                        <th colspan="3" class="table-primary text-center bg-gradient-info">
                                            Applicants
                                        </th>
                                    <tr>
                                        <th style="width: 10%;">S.No</th>
                                        <th style="width: 70%;">Applicant Name</th>
                                        <th style="width: 20%;">Product Name</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $sno = 1;
                                    @endphp

                                    @foreach ($appDetail as $in)
                                        @if ($in->target_segment_id == '1')
                                            <tr>
                                                <td style="width: 10%;">{{ $sno++ }}</td>
                                                <td style="width: 70%;">{{ $in->name}}</td>
                                                <td style="width: 20%;">{{ $in->product}}</td>
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

<div class="modal fade" id="app2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <a data-dismiss="modal" class="float-right" style="margin-left: auto;"><i
                    class="fas fa-window-close"></i></a>
            <div class="modal-body">
                <div class="">
                    <div class="">
                        <div class="table-responsive">
                            <table style="width: 100%" class="table table-sm table-striped table-bordered table-hover" id="ts2">
                                <thead>
                                        <th colspan="3"  class="table-primary text-center bg-gradient-info">
                                            Applicants
                                        </th>
                                    <tr>
                                        <th style="width: 10%;">S.No</th>
                                        <th style="width: 70%;">Applicant Name</th>
                                        <th style="width: 20%;">Product Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($appDetail as $in)
                                        @if ($in->target_segment_id == '2')
                                            <tr>
                                                <td style="width: 10%;">{{ $sno++ }}</td>
                                                <td style="width: 70%;">{{ $in->name }}</td>
                                                <td style="width: 20%;">{{ $in->product}}</td>
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

<div class="modal fade" id="app3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <a data-dismiss="modal" class="float-right" style="margin-left: auto;"><i
                    class="fas fa-window-close"></i></a>
            <div class="modal-body">
                <div class="">
                    <div class="">
                        <div class="table-responsive">
                            <table style="width: 100%" class="table table-sm table-striped table-bordered table-hover" id="ts3">
                                <thead>
                                        <th colspan="3"  class="table-primary text-center bg-gradient-info">
                                            Applicants
                                        </th>
                                    <tr>
                                        <th style="width: 10%;">S.No</th>
                                        <th style="width: 70%;">Applicant Name</th>
                                        <th style="width: 20%;">Product Name</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($appDetail as $in)
                                        @if ($in->target_segment_id == '3')
                                            <tr>
                                                <td style="width: 10%;">{{ $sno++ }}</td>
                                                <td style="width: 70%;">{{ $in->name }}</td>
                                                <td style="width: 20%;">{{ $in->product}}</td>
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

<div class="modal fade" id="app4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <a data-dismiss="modal" class="float-right" style="margin-left: auto;"><i
                    class="fas fa-window-close"></i></a>
            <div class="modal-body">
                <div class="">
                    <div class="">


                        <div class="table-responsive">
                            <table style="width: 100%" class="table table-sm table-striped table-bordered table-hover" id="ts4">
                                <thead>
                                        <th colspan="3"  class="table-primary text-center bg-gradient-info">
                                            Applicants
                                        </th>
                                    <tr>
                                        <th style="width: 10%;">S.No</th>
                                        <th style="width: 70%;">Applicant Name</th>
                                        <th style="width: 20%;">Product Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($appDetail as $in)
                                        @if ($in->target_segment_id == '4')
                                            <tr>
                                                <td style="width: 10%;">{{ $sno++ }}</td>
                                                <td style="width: 70%;">{{ $in->name }}</td>
                                                <td style="width: 20%;">{{ $in->product}}</td>
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
        $(document).ready(function() {
            var t = $('#ts3').DataTable({
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
            var t = $('#ts4').DataTable({
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
