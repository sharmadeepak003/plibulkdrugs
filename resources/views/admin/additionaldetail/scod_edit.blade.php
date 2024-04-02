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
        <input type="hidden" name="app_id" value="{{ $apps->id }}">
        <input type="hidden" name="task_id" value="{{ $task_id }}">
        @if($task_id == 5)
        <div class="card border-primary m-4 ">
           
            <div class="card-header bg-gradient-primary">
                <b>Status of Commercial Date</b>
            </div>
           
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th rowspan="2" class="text-center">Scheduled Date of Commercial Production</th>
                                        <th rowspan="1" class="text-center">Previous Date</th>
                                        <th rowspan="1" class="text-center">Change Date</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">{{  $propdetail->prod_date  }}</td>
                                        <td class="text-center"> <input type="date" name="prod_date"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Reason</th>
                                        <td class="text-center" colspan="2"> <input type="text" name="reason"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Document</th>
                                        <td class="text-center">@if($propdetail->scod_upload_id) <a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', $propdetail->scod_upload_id) }}">View</a> @endif</td>
                                        <td class="text-center" colspan="1"> <input type="file" name="scod_doc[1]"
                                            value="" class="form-control form-control-sm" style="padding:1px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        @elseif($task_id == 6)
        <div class="card border-primary m-4 ">
          
            <div class="card-header bg-gradient-primary">
                <b>Committed Capacity</b>
            </div>
           
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th  class="text-center" rowspan="2">Criteria</th>
                                        <th  class="text-center" rowspan="2">Weightage</th>
                                        <th  class="text-center" colspan=2>Quote by Aplicant</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Previous</th>
                                        <th class="text-center">Current</th>
                                    </tr>
                                    <tr>
                                        <th>Committed Annual Production capacity (in multiple of whole nos. of
                                            minimum annual production capacity for each eligible product, as given
                                            in Appendix B of the Scheme Guidelines)</th>
                                        <td class="text-center">35</td>
                                        <td class="text-center">{{$committed_inv->capacity}}</td>
                                        <td class="text-center"><input type="number" name="capacity"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Reason</th>
                                        <td class="text-center" colspan="3"> <input type="text" name="reason"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Document</th>
                                        <td class="text-center" colspan="1">@if($committed_inv->cc_upload_id) <a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', $committed_inv->cc_upload_id) }}">View</a> @endif</td>
                                        <td class="text-center" colspan="2"> <input type="file" name="cc_doc[1]"
                                            value="" class="form-control form-control-sm" style="padding:1px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        @elseif($task_id == 7)
        <div class="card border-primary m-4 ">
            <div class="card-header bg-gradient-primary">
                <b>Quoted Sales Price</b>
            </div>
           
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <table class="table table-sm table-striped table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th  class="text-center" rowspan="2">Criteria</th>
                                        <th  class="text-center" rowspan="2">Weightage</th>
                                        <th  class="text-center" colspan="2">Quote by Aplicant</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Previous</th>
                                        <th class="text-center">Current</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Quoted Sale Price of Eligible Product (₹ per kg)</th>
                                        <td class="text-center">65</td>
                                        <td class="text-center">{{$quoted_sp->price}}</td>
                                        <td class="text-center"> <input type="number" name="price"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Reason</th>
                                        <td class="text-center" colspan="3"> <input type="text" name="reason"
                                            value="" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Document</th>
                                        <td class="text-center" colspan="1">@if($quoted_sp->qsp_upload_id) <a class="mt-2 btn-sm btn-success" href="{{ route('doc.download', $quoted_sp->qsp_upload_id) }}">View</a> @endif</td>
                                        <td class="text-center" colspan="2"><input type="file" name="qsp_doc[1]"
                                            value="" class="form-control form-control-sm" style="padding:1px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        @endif
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
<script>
    $(document).ready(function () {
        $('#proCap').on('change', function () {
            if (this.value == 'yes') {
               $("#dateCO").prop("disabled", false);
               $("#expected_dt").prop("disabled", true);
            }else {
               $("#expected_dt").prop("disabled", false);
               $("#dateCO").prop("disabled", true);
            }
       });
   });
   </script>
    {!! JsValidator::formRequest('App\Http\Requests\admin\AdditionalsdetailRequest', '#form-create') !!}
@endpush
