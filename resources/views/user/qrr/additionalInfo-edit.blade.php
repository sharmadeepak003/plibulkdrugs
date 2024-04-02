@extends('layouts.user.dashboard-master')

@section('title')
QRR Dashboard
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <form action='{{ route('qrradditionalinfo.update',$qrrMast->id) }}' id="qrr-create" role="form" method="post"
            class='form-horizontal prevent_multiple_submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $apps->id }}">
            <input type="hidden" id="qtr_name" name="qtr_name" value="{{ $qtr }}">
            <input type="hidden" id="qrrId" name="qrrId" value="{{ $qrrMast->id }}">


            <div class="card border-primary p-0 m-10">
                <div class="card-header bg-gradient-primary">
                    <b>Approval Required Details</b>
                    <button type="button" id="addApprovals" name="addApprovals"
                        class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered table-hover" id="tablePrevMat">
                            <thead class="table-primary">
                                <th class="w-40" style=" width: 29%;">Approvals/Certification Required</th>
                                <th class="w-30">Concerned Authority/Body</th>
                                <th class="w-5">Availability of Approval (Yes/No)</th>
                                <th class="w-5">Validity of approval (If Available)</th>
                                <th class="w-5">Expected Date of Approval (if not available)</th>
                                <th class="w-15"> Inputs on any specific handholding required for any approval process
                                </th>
                                <th></th>
                                <thead>

                                <tbody>
                                    @foreach ($approvalsDetails as $key=> $item)
                                    <tr>
                                        <input type="hidden" name="approvals[{{$key}}][id]" value='{{ $item->id }}'>

                                        <td><input type="text" name="approvals[{{$key}}][reqapproval]"
                                                value="{{$item->reqapproval}}" class="form-control form-control-sm">
                                        </td>
                                        <td><input type="text" name="approvals[{{$key}}][concernbody]"
                                                value="{{$item->concernbody}}" class="form-control form-control-sm">
                                        </td>
                                        <td><select name="approvals[{{$key}}][isapproval]"
                                                class="form-control form-control-sm">
                                                <option @if($item->isapproval=='Y') selected @endif value="Y" >YES
                                                </option>
                                                <option @if($item->isapproval=='N') selected @endif value="N" >NO
                                                </option>
                                            </select></td>
                                        <td><input type="date" name="approvals[{{$key}}][dtvalidity]"
                                                value="{{$item->dtvalidity}}" class="form-control form-control-sm"></td>
                                        <td><input type="date" name="approvals[{{$key}}][dtexpected]"
                                                value="{{$item->dtexpected}}" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="approvals[{{$key}}][process]"
                                                value="{{$item->process}}" class="form-control form-control-sm"></td>
                                        <td><a href="{{ route('qrradditionalinfo.deleteapproval',$item->id) }}"
                                                class="btn btn-danger btn-sm float-right remove-prom"
                                                onclick="return confirm('Confirm Delete?')">Remove</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row pb-2">
                <div class="col-md-2 offset-md-0">
                    <a href="{{ route('uploads.create',['id' => $apps->id , 'qrr' => $qrrMast->id]) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm">
                        <i class="fas fa-angle-double-left"></i>Uploads</a>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                        id="submitshareper"><i class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                @if(count($tot_stage)==5)
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('qpr.show', $qrrMast->id) }}"
                        class="btn btn-success btn-sm form-control form-control-sm">Preview</a>
                    <!-- <a href="{{ route('qpr.submit',$qrrMast->id) }}" 
                    class="btn btn-success btn-sm form-control form-control-sm">
                    <i class="fas fa-angle-double-right"></i>Submit</a> -->
                </div>
                @endif
            </div>


        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var appr = $('input[name^="approvals"]').length / 6;
    $('#addApprovals').click(function() {
        $("#tablePrevMat").append(
            '<tr>' +
            '<td><input type="text"  name="approvals[' + appr +
            '][reqapproval]" class="form-control form-control-sm"></td>' +
            '<td><input type="text" name="approvals[' + appr +
            '][concernbody]" class="form-control form-control-sm"></td>' +
            '<td>  <select name="approvals[' + appr +
            '][isapproval]" class="form-control form-control-sm"><option value="Y">YES</option><option value="N">NO</option></select></td>' +
            '<td><input type="date" name="approvals[' + appr +
            '][dtvalidity]" class="form-control form-control-sm mattprevAmount"></td>' +
            '<td><input type="date" name="approvals[' + appr +
            '][dtexpected]" class="form-control form-control-sm mattprevAmount"></td>' +
            '<td><input type="text" name="approvals[' + appr +
            '][process]" class="form-control form-control-sm mattprevAmount"></td>' +
            '<td class="pr-1"><button type="button" class="btn btn-danger btn-sm float-right remove-apprvl">Remove</button></td></tr>'
        );
        appr++;

        $(document).on('click', '.remove-apprvl', function() {

            $(this).closest('tr').remove();


        });


    });
});
</script>
@include('user.partials.js.prevent_multiple_submit')
@include('user.partials.js.create-qrr')
{!! JsValidator::formRequest('App\Http\Requests\ApprovalsRequiredStore','#qrr-create') !!}
@endpush