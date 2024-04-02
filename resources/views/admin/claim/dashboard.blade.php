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
            {{-- @php $a= '2023-24'; @endphp --}}
           
            <form method="post" action="{{ route('admin.claimyearwise') }}">
                @csrf
            <div class="row">
                <div class="col-md-4" style="margin-left: 10%">
                    <label>Financial Year for which details are to be filled in</label>
                </div>
                <div class="col-md-3">
                    <select name="fy_name" id="fy_name" class="form-control col-md-12">
                        @foreach($fy as $financial_year)
                        <option value="{{ $financial_year->id }}" {{ $financial_year->fy_name === $getFy ? 'selected' : '' }}>{{ $financial_year->fy_name }}</option>

                        {{-- <option value="2023-2024" {{ $fy === '2023-2024' ? 'selected' : '' }}>2023-24</option> --}}
                    @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="filterData" class="btn btn-sm btn-block btn-primary text-white">
                        Filter</button>
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
                        {{-- <table class="table table-sm table-striped table-bordered table-hover" id="apps"> --}}
                        <table class="table table-sm  table-bordered table-hover" id="apps" style="width: 100%">
                            <thead class="appstable-head">
                                <tr class="table-info">
                                    <th class="text-center">Sr. No</th>
                                    <th class="text-left">Applicant's Name</th>
                                    <th class="text-center" style="width:5%">TS</th>
                                    <th class="text-left">Product</th>
                                    <th class="text-center" style="width:7%">FY</th>
                                    <th class="text-center">Claim Period</th>
                                    <th class="text-center">Quater</th>
                                    <th class="text-left" style="width:10%">Status</th>
                                    <!-- <th class="text-center">Documents</th> -->
                                    <th class="text-center">Submission Date</th>
                                    <th class="text-center">Revision Date</th>
                                    <th class="text-center">View</th>
                                    <th class="text-center">Document for 20% Incentive</th>
                                </tr>
                            </thead>
                            <tbody class="appstable-body">

                                @foreach ($appData as $key => $app)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-left">{{ $app->name }}</td>
                                        <td class="text-center">TS-{{ $app->target_segment_id }}</td>
                                        <td class="text-left">{{ $app->product }}</td>
                                        <td class="text-center">
                                            
                                            @php 
                                                $fiscalYear = $fy->where('id', $app->fy)->first();

                                                $fyName = optional($fiscalYear)->fy_name;
                                            @endphp
                                            {{$fyName}}
                                        </td>
                                        <td class="text-center" style="white-space: nowrap;">
                                            @if($app->claim_fill_period==1) Quarterly @endif
                                             @if($app->claim_fill_period==2) Half-Yearly @endif
                                             @if($app->claim_fill_period==3) Nine Months @endif
                                             @if($app->claim_fill_period==4) Annual @endif
                                        </td>
                                        <td class="text-center" style="white-space: nowrap;">{{ $app->start_month }}-{{ $app->month }}</td>
                                        <td class="text-left">
                                            @if (isset($app->claim_status) && trim($app->claim_status) == 'S')
                                                <span class="text-success"><b>Submitted</b></span>
                                            @elseif(isset($app->claim_status) && trim($app->claim_status) == 'D')
                                                <span class="text-primary"><b>Draft</b></span>
                                            @else
                                                <span class="text-danger"><b>Not Created</b></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (isset($app->claim_status) && trim($app->claim_status) == 'S')
                                                {{ isset($app->submitted_at) ? date('d-M-Y', strtotime($app->submitted_at)) : '' }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ isset($app->revision_dt) ? date('d-M-Y', strtotime($app->revision_dt)) : '' }}
                                        </td>

                                        @if ($app->claim_status == 'S')
                                            <td class="text-center">
                                                <a href="{{ route('claims.claimpreveiw', $app->claim_id) }}"
                                                    class="btn btn-info btn-sm btn-block">
                                                    <i class="right fas fa-eye"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <a href="" class="btn btn-info btn-sm btn-block disabled">
                                                    <i class="right fas fa-eye"></i>
                                                </a>
                                            </td>
                                        @endif
                                        {{-- {{dd($app)}} --}}
                                        <td>
                                            @if ($incentive_map_data->where('claim_id',$app->claim_id)->first()==Null)

                                            @elseif ($incentive_map_data->where('claim_id',$app->claim_id)->first()->status=='D')
                                            <button href="" disabled
                                                class="btn btn-warning btn-sm btn-block"> Draft</button>
                                                @elseif ($incentive_map_data->where('claim_id',$app->claim_id)->first()->status=='S')
                                                <a href="{{ route('claimdocumentupload.show', $app->claim_id) }}"
                                                    class="btn btn-success btn-sm btn-block"><i class="fa fa-eye"></i> Submitted
                                                @endif
                                            </a>
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
