@extends('layouts.admin.master')

@section('title')
    Quarterly Review Report Summary
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        .align_right tr td:not(:first-child) input {
            text-align: right !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.Prayas')}}" method="POST" id="form-create" role="form" class='form-horizontal' files=true
                enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-primary text-white">
                        <b>Data </b>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-4 pt-1">
                                <label class="col-form-label col-form-label-sm">Project Code</label>
                                <select class="form-select form-control form-control-sm" id="codes" name="Project_Code" required
                                    aria-label="Default select example" onchange="getProjectCode(this.value)">
                                    <option value="" >Select Project Code</option>
                                    @foreach ($projectcode as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->project_code }}</option>
                                    @endforeach

                                </select>

                            </div>
                            <div class="form-group col-md-4" id="newcolumn">
                                <label class="col-form-label col-form-label-sm">Frequancy</label>
                                <input type="text" class="form-control form-control-sm" required name="freq_code"
                                    id="frequancy" value="" readonly>
                            </div>
                            <div class="form-group col-md-4" id="newcolumn">
                                <label class="col-form-label col-form-label-sm">Instance Code</label>
                                <input type="text" class="form-control form-control-sm" id="instance_code"
                                    name="Instance_Code" value="" readonly>
                            </div>
                            <div class="form-group col-md-4" id="newcolumn">
                                <label class="col-form-label col-form-label-sm">Sector Code</label>
                                <input type="text" class="form-control form-control-sm" id="sec_code" name="Sec_Code"
                                    value="" readonly>
                            </div>
                            <div class="form-group col-md-4" id="newcolumn">
                                <label class="col-form-label col-form-label-sm">Ministry Code</label>
                                <input type="text" class="form-control form-control-sm" id="min_code"
                                    name="Ministry_Code" value="" readonly>
                            </div>
                            <div class="form-group col-md-4" id="newcolumn">
                                <label class="col-form-label col-form-label-sm">Department Code</label>
                                <input type="text" class="form-control form-control-sm" id="dep_code" name="Dept_Code"
                                    value="" readonly>
                            </div>

                        </div>

                    </div>

                 </div>

                 <div class="row pt-4">
                    <div class="col-md-2 offset-md-5">
                        <button type="submit" id="api_button"
                            class="btn btn-primary btn-sm form-control btn-block form-control-sm"
                            data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-save"></i>
                            Proceed</button>
                            {{-- <a href=""  class="btn btn-primary btn-sm form-control btn-block form-control-sm">Proceed</a> --}}
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js></script>

    <script>
        function getProjectCode(val) {
            var token = $("input[name='_token']").val();
            $.ajax({
                url: '/admin/prayas/getcods/' + val,
                method: 'GET',
                
                success: function(data) {
                    console.log(data);
                    $('#frequancy').val('');
                    $('#frequancy').val(data[0].freq_name);
                    $('#instance_code').val(data[0].instance_code);
                    $('#sec_code').val(data[0].sec_code);
                    $('#min_code').val(data[0].ministry_code);
                    $('#dep_code').val(data[0].dept_code);
                    $('#api_button').prop('disabled', false);
                }
            });
        }
    </script>
@endpush
