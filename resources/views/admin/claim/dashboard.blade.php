@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush


@section('title')
    Claim - Dashboard
@endsection

@section('content')
    <div class="">
        <div class="card-body">
            <form method="get" action="{{ route('admin.claim.claimdashboard', ['fy' => $fy]) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12" style="margin-left: 10%">
                        <label>Financial Year for which details are to be filled in</label>
                    </div>
                    <div class="col-md-2" style="margin-left: 30%">
                        <select name="fy_name" id="fy_name" class="form-control col-md-12">
                            <option value="2022-2023" {{ $fy === '2022-2023' ? 'selected' : '' }}>2022-23</option>
                            <option value="2023-2024" {{ $fy === '2023-2024' ? 'selected' : '' }}>2023-24</option>

                           
                        </select>

                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-block btn-primary text-white">
                            Filter
                        </button>
                    </div>


                </div>
            </form>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                            <thead class="appstable-head">
                                <tr class="table-info">
                                    <th class="text-center">Sr. No</th>
                                    <th class="text-center">Applicant's Name</th>
                                    <th class="text-center">Target Segment</th>
                                    <th class="text-center">Round</th>
                                    <th class="text-center" style="width:7%">FY</th>
                                    <th class="text-center">Claim Period</th>
                                    <th class="text-center">Quarter</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Submission Date</th>
                                    <th class="text-center">Revision Date</th>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Document for 20% Incentive</th>
                                    <th class="text-center">Correspondence</th>
                                </tr>
                            </thead>
                            <tbody class="appstable-body">
                                {{-- {{dd(!empty($appData), count($appData))}} --}}
                                @if (count($appData) > 0)
                                    @foreach ($appData as $key => $app)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $app->name }}</td>
                                            <td class="text-center">TS-{{ $app->target_segment }}</td>
                                            <td class="text-center">{{ $app->round }}</td>
                                            {{-- <td class="text-center">{{ $fy->where('id', $app->fy)->first()->fy_name }}</td> --}}
                                            <td class="text-center">
                                                @php
                                                    $fiscalYear = $fy->where('id', $app->fy)->first();
                                                @endphp
                                                @if ($fiscalYear)
                                                    {{ $fiscalYear->fy_name }}
                                                @else
                                                    
                                                @endif
                                            </td>
                                            
                                            <td class="text-center">
                                                @if ($app->claim_period == 1)
                                                    Quarterly
                                                @endif
                                                @if ($app->claim_period == 2)
                                                    Half-Yearly
                                                @endif
                                                @if ($app->claim_period == 3)
                                                    Nine Months
                                                @endif
                                                @if ($app->claim_period == 4)
                                                    Annual
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $app->start_month }}-{{ $app->end_month }}</td>
                                            <td class="text-center">
                                                @if (isset($app->claim_status) && trim($app->claim_status) == 'S')
                                                    <span class="text-success"><b>Submitted</b></span>
                                                @elseif(isset($app->claim_status) && trim($app->claim_status) == 'D')
                                                    <span class="text-primary"><b>Draft</b></span>
                                                @else
                                                    <span class="text-danger"><b>Not Created</b></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ isset($app->submitted_at) ? date('d-M-Y', strtotime($app->submitted_at)) : '' }}
                                            </td>
                                            <td class="text-center">
                                                {{ isset($app->revision_dt) ? date('d-M-Y', strtotime($app->revision_dt)) : '' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($app->claim_status == 'S')
                                                    <a href="{{ route('claims.claimpreview', $app->claim_id) }}"
                                                        class="btn btn-info btn-sm btn-block">
                                                        <i class="right fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-info btn-sm btn-block disabled">
                                                        <i class="right fas fa-eye"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $incentive_map = $incentive_map_data
                                                        ->where('claim_id', $app->claim_id)
                                                        ->first();
                                                @endphp
                                                @if ($incentive_map)
                                                    @if ($incentive_map->status == 'D')
                                                        <button class="btn btn-warning btn-sm btn-block"
                                                            disabled>Draft</button>
                                                    @elseif($incentive_map->status == 'S')
                                                        <a href="{{ route('claimdocumentupload.show', $app->claim_id) }}"
                                                            class="btn btn-success btn-sm btn-block"><i
                                                                class="fa fa-eye"></i> Submitted</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td> <a href="{{ url('claimcorrespondence', $app->claim_id) }}"
                                                class="btn btn-success btn-sm btn-block"><i
                                                    class="fa fa-eye"></i> View</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{-- {{dd('ddd')}} --}}
                                    <tr>
                                        <td colspan="12">
                                            <p style="200px; clear:both;"></p>
                                            <center><p style="color: red;">No Data Found!</p></center>
                                        </td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                    Note:<br>
                    TS-1 = A. Cancer care / Radiotherapy Medical / Devices <br>
                    TS-2 = B. Radiology & Imaging Medical Devices (both ionizing & non-ionizing radiation products) and
                    Nuclear Imaging Devices <br>
                    TS-3 = C. Anesthetics & Cardio-Respiratory Medical Devices including Catheters of Cardio Respiratory
                    Category & Renal Care Medical Devices <br>
                    TS-4 = D. All Implants including implantable electronic Devices
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            // $("#filterData").click(function (event) {
            //     var fyId= $('#fy_name').val();
            //     var link='/shared/claims/list/'+fyId;
            //     window.location.href = link;
            // });

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

            t.on('order.dt search.dt', function () {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


        });
    </script>
@endpush
