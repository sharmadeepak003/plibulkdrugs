@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
    QRR - Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; margin:0.3rem; place-content:center;">
                <h3>Select Date</h3>
                <select name="QrrMail" id="QrrMail" onchange="dropdown1()" class="1qrrval" style="margin:0.1rem 2rem;">
                    @php
                        use Carbon\Carbon;
                        $today = Carbon::now()->format('Y-m-d');
                    @endphp
                    @foreach ($date as $date)
                        <option class="text-center" value="" @if ($date->send_mail_date == $today)  @endif>Select</option>
                        <option value="{{ $date->send_mail_date }}">{{ $date->send_mail_date }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="appPhase1Content" role="tabpanel" aria-labelledby="appPhase1Content-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-body p-1 py-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover qrrsTables"
                                    id="MailLog" style="font-size: 13px">
                                    <thead class="appstable-head">
                                        <tr class="table-info">
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-auto p-3">Applicant Name</th>
                                            <th class="text-center w-auto p-3">Product</th>
                                            <th class="text-center w-auto p-3">Target Segment</th>
                                            <th class="text-center w-auto p-3">Email</th>
                                            <th class="text-center w-auto p-3">Quarter Name</th>
                                            <th class="text-center w-auto p-3">Mail Status</th>
                                            <th class="text-center w-auto p-3">Mail Send By(Admin Name)</th>
                                            <th class="text-center w-auto p-3">Mail Subject</th>
                                            <th class="text-center w-auto p-3">Send Mail Date</th>
                                            <th class="text-center w-auto p-3">CC Mail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="appstable-body">
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($MailData as $item)
                                            <tr>
                                                <td>{{ $key++ }}</td>
                                                <td>{{ $item->user_name }}</td>
                                                <td>{{ $item->product }}</td>
                                                <td>{{ $item->target_segment }}</td>
                                                <td>{{ $item->user_email }}</td>
                                                <td>{{ $item->month }}-{{ $item->year }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="text-success"><b>Success</b></span>
                                                    @else
                                                        <span class="text-primary"><b>Failed</b></span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->admin_name }}</td>
                                                <td>{{ $item->email_subject }}</td>
                                                <td>{{ $item->send_mail_date }}</td>
                                                <td>{{ $item->cc_email }}</td>
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
        function dropdown1() {
            window.location.href = '' + $('#QrrMail').val();
        }

        $(document).ready(function() {
            $('#MailLog').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });
    </script>
@endpush
