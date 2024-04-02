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
                <h5>Projected Sales</h5>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                        <thead class="userstable-head">
                            <tr class="table-info">
                                <th class="text-center" colspan="11">Old Data</th>
                            </tr>
                            <tr class="table-info">
                                <th class="w-20 text-center">Particulars (₹ in INR)</th>
                                <th class="w-8 text-center">FY 2020-21</th>
                                <th class="w-8 text-center">FY 2021-22</th>
                                <th class="w-8 text-center">FY 2022-23</th>
                                <th class="w-8 text-center">FY 2023-24</th>
                                <th class="w-8 text-center">FY 2024-25</th>
                                <th class="w-8 text-center">FY 2025-26</th>
                                <th class="w-8 text-center">FY 2026-27</th>
                                <th class="w-8 text-center">FY 2027-28</th>
                                <th class="w-8 text-center">FY 2028-29</th>
                                <th class="w-8 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body" style="font-size:12px">
                            @foreach ($revenue as $rev)
                                <tr>
                                    <th>Export Sales</th>
                                    <td class="text-center">{{ number_format($rev->expfy20, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy21, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy22, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy23, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy24, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy25, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy26, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy27, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->expfy28, 2) }}</td>
                                    <td><input type="text" style="width: 120px" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy20 + $rev->expfy21 + $rev->expfy22 + $rev->expfy23 + $rev->expfy24 + $rev->expfy25 + $rev->expfy26 + $rev->expfy27 + $rev->expfy28, 2) }}"
                                            disabled></td>
                                </tr>
                                <tr>
                                    <th>Domestic Sales</th>
                                    <td class="text-center">{{ number_format($rev->domfy20, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy21, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy22, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy23, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy24, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy25, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy26, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy27, 2) }}</td>
                                    <td class="text-center">{{ number_format($rev->domfy28, 2) }}</td>
                                    <td><input type="text" style="width: 120px" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->domfy20 + $rev->domfy21 + $rev->domfy22 + $rev->domfy23 + $rev->domfy24 + $rev->domfy25 + $rev->domfy26 + $rev->domfy27 + $rev->domfy28, 2) }}"
                                            disabled></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy20 + $rev->domfy20, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy21 + $rev->domfy21, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy22 + $rev->domfy22, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy23 + $rev->domfy23, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy24 + $rev->domfy24, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy25 + $rev->domfy25, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy26 + $rev->domfy26, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy27 + $rev->domfy27, 2) }}" disabled></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"
                                            value="{{ number_format($rev->expfy28 + $rev->domfy28, 2) }}" disabled></td>
                                </tr>
                            @break
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="users1">
                        <thead class="userstable-head">
                            <tr class="table-info">
                                <th class="text-center" colspan="11">New Data</th>
                            </tr>
                            <tr class="table-info">
                                <th class="text-center">Particulars (₹ in INR)</th>
                                <th class="text-center">FY 2020-21</th>
                                <th class="text-center">FY 2021-22</th>
                                <th class="text-center">FY 2022-23</th>
                                <th class="text-center">FY 2023-24</th>
                                <th class="text-center">FY 2024-25</th>
                                <th class="text-center">FY 2025-26</th>
                                <th class="text-center">FY 2026-27</th>
                                <th class="text-center">FY 2027-28</th>
                                <th class="text-center">FY 2028-29</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body" style="font-size:12px">
                            @foreach ($revenue as $rev)
                                <tr>
                                    <th>Export Sales</th>
                                    <td><input type="number" name="expfy20" id="expfy20" value="{{$rev->expfy20}}"
                                            class="form-control form-control-sm export exp"></td>
                                    <td><input type="number" name="expfy21" id="expfy21" value="{{$rev->expfy21}}"
                                            class="form-control form-control-sm export exp1"></td>
                                    <td><input type="number" name="expfy22" id="expfy22" value="{{$rev->expfy22}}"
                                            class="form-control form-control-sm export exp2"></td>
                                    <td><input type="number" name="expfy23" id="expfy23" value="{{$rev->expfy23}}"
                                            class="form-control form-control-sm export exp3"></td>
                                    <td><input type="number" name="expfy24" id="expfy24" value="{{$rev->expfy24}}"
                                            class="form-control form-control-sm export exp4"></td>
                                    <td><input type="number" name="expfy25" id="expfy25" value="{{$rev->expfy25}}"
                                            class="form-control form-control-sm export exp5"></td>
                                    <td><input type="number" name="expfy26" id="expfy26" value="{{$rev->expfy26}}"
                                            class="form-control form-control-sm export exp6"></td>
                                    <td><input type="number" name="expfy27" id="expfy27" value="{{$rev->expfy27}}"
                                            class="form-control form-control-sm export exp7"></td>
                                    <td><input type="number" name="expfy28" id="expfy28" value="{{$rev->expfy28}}"
                                            class="form-control form-control-sm export exp8"></td>
                                    <td><input type="text" name="totalexp" id="totalexp"
                                            class="form-control form-control-sm" style="width: 120px" value="{{ number_format($rev->expfy20 + $rev->expfy21 + $rev->expfy22 + $rev->expfy23 + $rev->expfy24 + $rev->expfy25 + $rev->expfy26 + $rev->expfy27 + $rev->expfy28, 2) }}"
                                            disabled></td>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Domestic Sales</th>
                                    <td><input type="number" name="domfy20" id="domfy20" value="{{$rev->domfy20}}"
                                            class="form-control form-control-sm domestic exp"></td>
                                    <td><input type="number" name="domfy21" id="domfy21" value="{{$rev->domfy21}}"
                                            class="form-control form-control-sm domestic exp1"></td>
                                    <td><input type="number" name="domfy22" id="domfy22" value="{{$rev->domfy22}}"
                                            class="form-control form-control-sm domestic exp2"></td>
                                    <td><input type="number" name="domfy23" id="domfy23" value="{{$rev->domfy23}}"
                                            class="form-control form-control-sm domestic exp3"></td>
                                    <td><input type="number" name="domfy24" id="domfy24" value="{{$rev->domfy24}}"
                                            class="form-control form-control-sm domestic exp4"></td>
                                    <td><input type="number" name="domfy25" id="domfy25" value="{{$rev->domfy25}}"
                                            class="form-control form-control-sm domestic exp5"></td>
                                    <td><input type="number" name="domfy26" id="domfy26" value="{{$rev->domfy26}}"
                                            class="form-control form-control-sm domestic exp6"></td>
                                    <td><input type="number" name="domfy27" id="domfy27" value="{{$rev->domfy27}}"
                                            class="form-control form-control-sm domestic exp7"></td>
                                    <td><input type="number" name="domfy28" id="domfy28" value="{{$rev->domfy28}}"
                                            class="form-control form-control-sm domestic exp8"></td>
                                    <td><input type="text" class="text-center form-control form-control-sm"  name="totaldom" id="totaldom" style="width: 120px"
                                        value="{{ number_format($rev->domfy20 + $rev->domfy21 + $rev->domfy22 + $rev->domfy23 + $rev->domfy24 + $rev->domfy25 + $rev->domfy26 + $rev->domfy27 + $rev->domfy28, 2) }}"
                                        disabled></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><input type="text" id="totalfy20"  class="form-control form-control-sm" value="{{ number_format($rev->expfy20 + $rev->domfy20, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy21"  class="form-control form-control-sm" value="{{ number_format($rev->expfy21 + $rev->domfy21, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy22"  class="form-control form-control-sm" value="{{ number_format($rev->expfy22 + $rev->domfy22, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy23"  class="form-control form-control-sm" value="{{ number_format($rev->expfy23 + $rev->domfy23, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy24"  class="form-control form-control-sm" value="{{ number_format($rev->expfy24 + $rev->domfy24, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy25"  class="form-control form-control-sm" value="{{ number_format($rev->expfy25 + $rev->domfy25, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy26"  class="form-control form-control-sm" value="{{ number_format($rev->expfy26 + $rev->domfy26, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy27"  class="form-control form-control-sm" value="{{ number_format($rev->expfy27 + $rev->domfy27, 2) }}"  disabled>
                                    </td>
                                    <td><input type="text" id="totalfy28"  class="form-control form-control-sm" value="{{ number_format($rev->expfy28 + $rev->domfy28, 2) }}"  disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Remark</th>
                                    <td colspan="9"><input type="text" name="revremark" id="revremark"  class="form-control form-control-sm"></td>
                                </tr>
                            @break
                            @endforeach
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
