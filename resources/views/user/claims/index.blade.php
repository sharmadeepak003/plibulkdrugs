@extends('layouts.user.dashboard-master')

@section('title')
    Claim Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    {{-- <div class="row">

    </div>
    <br> --}}
    <div class="col-md-12" style="padding: 5px">
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">

                <button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal"
                    data-target="#ClaimCreateModal">Fill Claim Form
                </button>
                @include('user.claims.partials.model.claimCreateModal')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 offset-md-3">
                            {{-- {{$id}} this is fy id value --}}
                            <label> Financial Year</label>
                        </div>
                        <div class="col-md-2">
                            <select name="fy_name" id="fy_name" class="form-control col-md-12">

                                {{-- {{-- @foreach ($fys as $fyname) --}}
                                {{-- <option  value="">2022-23</option> --}}
                                {{-- @endforeach --}}
                                @foreach ($fy as $fyname)
                                    <option value="{{ $fyname->id }}" {{ $fyname->id == $id ? 'selected' : '' }}>
                                        {{ $fyname->fy_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            {{-- <button id="filterData" class="btn btn-sm btn-block btn-primary text-white" style="pointer-events: none;">Filter</button> --}}
                            <button id="filterData" class="btn btn-sm btn-block btn-primary text-white">Filter</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pt-2">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">Sr. No</th>
                                            <th class="text-center">Applicant's Name</th>
                                            <th class="text-center">TS</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">FY</th>
                                            <th class="text-center">Claim Period</th>
                                            <th class="text-center">Quater</th>
                                            <!-- <th class="text-center" >Submission Date</th>
                                                    <th class="text-center" >Revision Date</th> -->
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Document for 20% Incentive</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($arr_claims)}} --}}
                                        {{-- {{dd($getSelectedFy->fy_name)}} --}}
                                        @if (count($arr_claims) > 0)
                                            @foreach ($arr_claims as $key => $cm_val)
                                                {{-- {{dd($arr_claims)}} --}}
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td class="text-center">{{ $cm_val->name }}</td>
                                                    <td class="text-center">{{ $cm_val->ts }}</td>
                                                    <td class="text-center">{{ $cm_val->product }}</td>

                                                    <td class="text-center">

                                                        {{ $fy->where('id', $cm_val->fy)->first()->fy_name }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($cm_val->claim_fill_period == 1)
                                                            Quarterly
                                                        @endif
                                                        @if ($cm_val->claim_fill_period == 2)
                                                            Half-Yearly
                                                        @endif
                                                        @if ($cm_val->claim_fill_period == 3)
                                                            Nine Months
                                                        @endif
                                                        @if ($cm_val->claim_fill_period == 4)
                                                            Annual
                                                        @endif
                                                    </td>
                                                    <td class="text-center" style="white-space: nowrap;">
                                                        {{ $cm_val->start_month . '-' . $cm_val->end_month }}
                                                    </td>


                                                    @if ($cm_val->status == 'D')
                                                        <td class="text-center" style="background-color: #f3cccc;">Draft
                                                        </td>
                                                    @elseif($cm_val->status == 'S')
                                                        <td class="text-center" style="background-color: #97f58a;">Submitted
                                                        </td>
                                                    @endif
                                                    <td>

                                                        @if ($getSelectedFy->fy_name == '2023-24')
                                                            @if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-12-31 23:59:00')))
                                                                @if ($cm_val->status == 'S')
                                                                    <a href="{{ route('claims.claimpreveiw', $cm_val->claim_id) }}"
                                                                        class="btn btn-success btn-sm btn-block">View</a>
                                                                @elseif($cm_val->status == 'D')
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-sm btn-block"
                                                                        data-toggle="modal"
                                                                        data-target="#editModal{{ $cm_val->claim_id }}">
                                                                        Edit
                                                                    </button>
                                                                    @include('user.claims.partials.model.claimEditModel')
                                                                @endif
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-block" disabled>
                                                                    !! The claim form has been closed. !!
                                                                </button>
                                                            @endif
                                                        @else
                                                            @if ($cm_val->status == 'S')
                                                                <a href="{{ route('claims.claimpreveiw', $cm_val->claim_id) }}"
                                                                    class="btn btn-success btn-sm btn-block">View</a>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-block" disabled>
                                                                    !! The claim form has been closed. !!
                                                                </button>
                                                            @endif
                                                        @endif





                                                    </td>

                                                    @php
                                                        if ($cm_val->claim_fill_period == 4) {
                                                            $date = $getSelectedFy->fy_name == '2023-24' ? Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-12-31 23:59:00')) : Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-02-31 23:59:00'));
                                                        } else {
                                                            $date = $getSelectedFy->fy_name == '2023-24' ? Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-12-31 23:59:00')) : Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-01-31 23:59:00'));
                                                        }
                                                    @endphp
                                                    <td>



                                                        @if (isset($incentive_map_data))
                                                            @if ($date)
                                                                @if ($incentive_map_data->where('claim_id', $cm_val->id)->first() == null)
                                                                    <a href="{{ route('claimdocumentupload.incentive', $cm_val->id) }}"
                                                                        class="btn btn-primary btn-sm btn-block"><i
                                                                            class="fa fa-plus"></i> Create
                                                                    @elseif ($incentive_map_data->where('claim_id', $cm_val->id)->first()->status == 'D')
                                                                        <a href="{{ route('claimdocumentupload.edit', [$cm_val->id, 'R']) }}"
                                                                            class="btn btn-warning btn-sm btn-block"><i
                                                                                class="fa fa-edit"></i> Draft
                                                                        @elseif ($incentive_map_data->where('claim_id', $cm_val->id)->first()->status == 'S')
                                                                            <a href="{{ route('claimdocumentupload.show', $cm_val->id) }}"
                                                                                class="btn btn-success btn-sm btn-block"><i
                                                                                    class="fa fa-eye"></i> Submitted
                                                                            </a>
                                                                @endif
                                                            @else
                                                                @php
                                                                    $data = $incentive_map_data->where('claim_id', $cm_val->id)->first();
                                                                @endphp
                                                                @if (isset($data))
                                                                    @if ($incentive_map_data->where('claim_id', $cm_val->id)->first()->status == 'S')
                                                                        <a href="{{ route('claimdocumentupload.show', $cm_val->id) }}"
                                                                            class="btn btn-success btn-sm btn-block"><i
                                                                                class="fa fa-eye"></i> Submitted
                                                                        </a>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm btn-block"
                                                                            disabled>
                                                                            !! The 20% incentive form has been closed. !!
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm btn-block" disabled>
                                                                        !! The 20% incentive form has not be yet start. !!
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm btn-block"
                                                                disabled>
                                                                !! The 20% incentive form has been closed. !!
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" style="color: red">No data found</td>
                                            </tr>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#filterData").click(function(event) {
                var fyId = $('#fy_name').val();
                var link = '/claims/index/' + fyId;
                window.location.href = link;
            });

            $("#smallButton").click(function() {
                // Get the value from the data attribute of the first modal's anchor tag
                var sharedValue = $(this).data("attr");

                // Set the value in the hidden input field inside the second modal
                $("#claim_id").val(sharedValue);
            });

            $("#close").click(function() {
                location.reload();
            });
        });
    </script>
@endpush
