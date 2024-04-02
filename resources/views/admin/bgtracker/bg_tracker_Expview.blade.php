@extends('layouts.admin.master')

@section('title')
    {{-- Applicant - {{Auth::$user->name }} --}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="row py-4">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <b>
                                <div class="text-center" style="font-size: 20px;">Expired Bank Gaurentee</div>
                            </b>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th>Applicant Name</th>
                                        <td style="font-size: 20px;">{{ $expbgview->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Application No.</th>
                                        <td>{{ $expbgview->app_no }}</td>
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
                                                    <td>{{ $expbgview->target_segment }}
                                                    <td class="text-center">{{ $expbgview->product }}</td>
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
                                                    <td>{{ $expbgview->bank_name }}
                                                    <td class="text-center">{{ $expbgview->branch_address }}</td>
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
                                        <td class="text-bold" style="font-size: 18px;">{{ $expbgview->bg_no }}
                                    </tr>
                                    <tr>
                                        <th class="text-left">BG Amount</th>
                                        <td>{{ $expbgview->bg_amount }}
                                    </tr>
                                    <tr>
                                        <th>Date Information</th>
                                        <td>
                                            <table class="sub-table text-center " style="width: 100%">
                                                <tr>
                                                    <th class="text-left ">Issue Date</th>
                                                    <th class="text-center ">Expiry Date</th>
                                                    <th class="text-center ">Claim Date</th>
                                                </tr>
                                                <tr>
                                                    <td>{{ $expbgview->issued_dt }}</td>
                                                    <td>{{ $expbgview->expiry_dt }}</td>
                                                    <td>{{ $expbgview->claim_dt }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left ">Status</th>
                                        <td class="text-justify text-bold " style="color: red">
                                            @if ($expbgview->bg_status == 'RO' || $expbgview->bg_status == 'RE' || $expbgview->bg_status == 'IN' || $expbgview->bg_status == 'EX')
                                                Expired BG
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th class="text-left ">Remark</th>
                                        <td class="text-justify text-bold " style="color:red">Update New BG.....</td>
                                    </tr>
                                    @if (AUTH::user()->hasRole('Admin'))
                                        <tr>
                                            <th class="text-left ">BG Document</th>
                                            <td class="text-center" style="color:red">
                                                @if (in_array('28', $docids))
                                                    @foreach ($docs as $key => $doc)
                                                        @if ($key == '28')
                                                            <a href="{{ $doc }}" target="_blank"
                                                                class="btn btn-success btn-sm float-center">
                                                                View</a>
                                                            <a href="{{ $doc }}" target="_blank"
                                                                download="{{ $expbgview->name }}-BG.pdf"
                                                                class="btn btn-success btn-sm float-center">
                                                                Download</a>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
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
                    <div class="col-md-2 offset-md-3">
                        <a href="{{ route('admin.bgtracker.edit', $expbgview->app_id) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm"><i class="fas fa-edit"></i>
                            Edit</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
