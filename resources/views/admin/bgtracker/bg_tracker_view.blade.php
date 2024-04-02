@extends('layouts.admin.master')

@section('title')
    {{-- Applicant - {{Auth::$user->name }} --}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-8">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <b>
                                <div class="text-center" style="font-size: 20px;">Bank Guarantee</div>
                            </b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                @foreach ($bgview as $bg)
                                    {{-- @if ($bg->submit == 'Y') --}}

                                    <tbody>
                                        <tr>
                                            <th>Applicant Name</th>
                                            <td style="font-size: 16px;">{{ $bg->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Application No.</th>
                                            <td>{{ $bg->app_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Eligible Product & Target Segment</th>
                                            <td>
                                                <table class="sub-table" style="width: 100%">
                                                    <tr>
                                                        <th>Target Segment</th>
                                                        <th class="text-center">Product Name</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $bg->target_segment }}
                                                        <td class="text-center">{{ $bg->product }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Bank Details</th>
                                            <td>
                                                <table class="sub-table text-center " style="width: 100%">
                                                    <tr>
                                                        <th class="text-left ">Bank Name</th>
                                                        <th class="text-center ">Branch Address</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $bg->bank_name }}
                                                        <td class="text-center">{{ $bg->branch_address }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">BG No.</th>
                                            <td class="text-bold" style="font-size: 16px;">{{ $bg->bg_no }}
                                        </tr>
                                        <tr>
                                            <th class="text-left">BG Amount</th>
                                            <td>{{ $bg->bg_amount }}
                                        </tr>
                                        <tr>
                                            <th>Date Information</th>
                                            <td>
                                                <table class="sub-table text-center " style="width: 100%">
                                                    <tr>
                                                        <th class="text-center ">Issue Date</th>
                                                        <th class="text-center ">Expiry Date</th>
                                                        <th class="text-center ">Claim Date</th>
                                                    </tr>
                                                    @if ($date >= $bg->expiry_dt)
                                                        {{-- <td class="alert-danger text-center text-nowrap"> --}}
                                                        <tr class="alert-danger text-center text-nowrap">
                                                            <td>{{ $bg->issued_dt }}</td>
                                                            <td>{{ $bg->expiry_dt }}</td>
                                                            <td>{{ $bg->claim_dt }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ $bg->issued_dt }}</td>
                                                            <td>{{ $bg->expiry_dt }}</td>
                                                            <td>{{ $bg->claim_dt }}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">Status</th>
                                            @if ($date >= $bg->expiry_dt)
                                                <td class="alert-danger">
                                                    @if ($bg->bg_status == 'RO')
                                                        Roll Over
                                                    @elseif ($bg->bg_status == 'RE')
                                                        Release
                                                    @elseif ($bg->bg_status == 'IN')
                                                        Invoke
                                                    @elseif ($bg->bg_status == 'EX')
                                                        Existing
                                                    @endif
                                                </td>
                                            @else
                                                <td>
                                                    @if ($bg->bg_status == 'RO')
                                                        Roll Over
                                                    @elseif ($bg->bg_status == 'RE')
                                                        Release
                                                    @elseif ($bg->bg_status == 'IN')
                                                        Invoke
                                                    @elseif ($bg->bg_status == 'EX')
                                                        Existing
                                                    @endif
                                                </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <th class="text-left ">Remark</th>
                                            <td>{{ $bg->remark }}
                                        </tr>
                                        @if (AUTH::user()->hasRole('Admin'))
                                            <tr>
                                                <th class="text-left ">BG Document</th>
                                                <td class="text-center">
                                                    @if (in_array('28', $docids))
                                                        {{-- {{dd($upload_id)}} --}}
                                                        @foreach ($docs as $key => $doc)
                                                            @foreach ($upload_id as $id)
                                                                {{-- {{dd($id)}} --}}
                                                                @if ($key == '28' and $bg->bg_upload_id == $id)
                                                                    {{--<a href="{{ $doc }}" target="_blank"
                                                                        class="btn btn-success btn-sm float-center">
                                                                        View</a>--}}
                                                                    <a href="{{ $doc }}" target="_blank"
                                                                        download="{{ $bg->name }}_{{ $bg->bg_no }}.pdf"
                                                                        class="btn btn-success btn-sm float-center">
                                                                        Download</a>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    {{-- @endif --}}
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <a href="{{ route('admin.bgtracker.index') }}"
                        class="btn btn-primary btn-sm form-control form-control-sm">
                        <i class="fas fa-home"></i> Back</a>
                </div>
                @if (AUTH::user()->hasRole('Admin'))
                    {{-- @if ($today < $bg->expiry_dt) --}}
                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('admin.bgtracker.edit', ['bg_id' =>$bg->id, 'doc_id' =>encrypt($bg->bg_upload_id)]) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm"><i class="fas fa-edit"></i>
                                Edit</a>
                        </div>
                    {{-- @endif --}}
                @endif
            </div>
        </div>
    </div>
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <h5>Bank Guarantee</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover " id="users">
                            <thead class="userstable-head">
                                <tr class="table-info">
                                    <th class="w-65 text-center ">Sr No</th>
                                    <th class="w-65 text-center ">Applicant Name</th>
                                    <th class="w-65 text-center ">Target Segment</th>
                                    <th class="w-65 text-center ">Eligible Product</th>
                                    <th class="w-65 text-center ">BG No.</th>
                                    <th class="w-65 text-center ">BG Amount (in ₹)</th>
                                    <th class="w-65 text-center ">Issue Date</th>
                                    <th class="w-65 text-center ">Expiry Date</th>
                                    <th class="w-65 text-center ">Claim Date</th>
                                    <th class="w-65 text-center ">BG Status</th>
                                    <th class="w-65 text-center ">BG</th>
                                </tr>
                            </thead>
                            <tbody class="userstable-body">
                                @php
                                    $sno = 1;
                                @endphp
                                @foreach ($bgview1 as $app)
                                    {{-- @if ($app->submit == 'N') --}}
                                        <tr>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $sno++ }}
                                            </td>
                                            <td class="w-65 p-1 text-nowrap">
                                                {{ $app->name }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->target_segment }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->product }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->bg_no }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->bg_amount }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->issued_dt }}
                                            </td>
                                            @if ($date >= $app->expiry_dt && $app->expiry_dt != null)
                                                <td class="alert-danger text-center text-nowrap">
                                                    {{ $app->expiry_dt }}
                                                </td>
                                            @else
                                                <td class="w-65 p-1 text-center text-nowrap">
                                                    {{ $app->expiry_dt }}
                                                </td>
                                            @endif
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                {{ $app->claim_dt }}
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                @if ($today > $app->expiry_dt && $app->expiry_dt != null)
                                                    <p class="font-weight-bold text-danger">BG Expired</p>
                                                @elseif($app->bg_status == 'RO')
                                                    <p class="font-weight-bold text-success">Roll Over</p>
                                                @elseif($app->bg_status == 'RE')
                                                    <p class="font-weight-bold text-success">Release</p>
                                                @elseif($app->bg_status == 'IN')
                                                    <p class="font-weight-bold text-secondary">Invoke</p>
                                                @elseif($app->bg_status == 'EX')
                                                    <p class="font-weight-bold text-black ">Existing</p>
                                                 @else
                                                    <p class="text-info">Not Submit</p>
                                                @endif
                                            </td>
                                            <td class="w-65 p-1 text-center text-nowrap">
                                                <a href="{{ route('admin.bgtracker.show', ['app_id' =>$app->app_id, 'bg_id' => encrypt($app->bg_id)]) }}"
                                                    target="_blank" @if ($app->submit == 'N') class="btn btn-danger btn-sm btn-block" @else class="btn btn-primary btn-sm btn-block"@endif><i
                                                        class="right fas fa-eye"> View</i>
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
