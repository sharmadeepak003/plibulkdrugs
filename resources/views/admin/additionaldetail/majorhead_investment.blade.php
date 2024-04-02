@extends('layouts.admin.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush


@section('title')
    Applications - Dashboard
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <br>
            <br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container ">
        <div class="row">
            <div class="col bg-mute text-center">
                <span style="color:#DC3545;font-size:20px"> <b> Application Name :</b></span><span
                    style="color:black;font-size:20px"> {{ $apps->name }}</p></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Application Number :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->app_no }}</span>
            </div>
            <div class="col-5 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Target Segment :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->target_segment }}</span>
            </div>
            <div class="col-3 text-center">
                <span style="color:#DC3545;font-size:16px"> <b> Product Name :</b></span><br><span
                    style="color:black;font-size:14px">{{ $apps->product }}</span>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.additionaldetail.update', $apps->id) }}" id="form-create" role="form" method="post"
        class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
        {!! method_field('patch') !!}
        @csrf
        <div class="card border-primary m-4 ">
            <input type="hidden" name="app_id" value="{{ $apps->id }}">
            <input type="hidden" name="task_id" value="{{ $task_id }}">
            <div class="card-header text-white bg-primary border-primary">
                <h5>Major Heads of committed Investment</h5>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                        <thead class="userstable-head">
                            <tr class="table-info">
                                <th class="w-20 text-center">S.N</th>
                                <th class="w-50 text-center">Major Heads</th>
                                <th class="w-30 text-center">Investmetn (₹ in crore )</th>
                                <th class="w-30 text-center">Investmetn New (₹ in crore )</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body">
                            @php
                                $sno = 1;
                            @endphp
                            @foreach ($particular_inv as $val)
                                @foreach ($inv_detail as $det)
                                    @if ($det->prt_id == $val->id)
                                        <tr>
                                            <td class="text-center">{{ $sno++ }}</td>
                                            <td>{{ $val->name }}
                                                <input type="hidden" name="val[{{ $loop->index }}][id]"
                                                    value='{{ $det->id }}'>
                                            </td>
                                            <td class="text-center">{{ number_format($det->amt, 2) }}</td>
                                            <td>
                                                @if ($det->prt_id != 17)
                                                    <input type="number" name="val[{{ $loop->index }}][amount]"
                                                        id="investparticular" value="{{ number_format($det->amt, 2) }}"
                                                        class="form-control form-control-sm text-center investparticular">
                                                @else
                                                    <input type="number" name="val[{{ $loop->index }}][amount]" id="total"
                                                        class="form-control text-center form-control-sm" readonly>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            <td colspan="2" class="text-center font-weight-bold">Remark</td>
                            <td colspan="2"> <input type="text" name="partremark" id="partremark"
                                    class="form-control form-control-sm"></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 offset-md-5">
                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                        class="fas fa-save"></i> Save</button>
            </div>
            <div class="col-md-1 offset-md-3.5">
                <a href="{{ route('admin.additionaldetail.create', $apps->id) }}"
                    class="btn btn-success btn-sm form-control form-control-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    @include('admin.partials.js.additionalsdetail-js')
    {!! JsValidator::formRequest('App\Http\Requests\admin\AdditionalsdetailRequest', '#form-create') !!}
@endpush
