@extends('layouts.user.dashboard-master')

@section('title')
    Claim: Miscellaneous Document Upload
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"] {
            padding: 1px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimdocumentupload.update', 'C') }}" id="application-create" role="form" method="POST"
                class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                @method('patch')
                <input type="hidden" name="app_id" value="{{ $apps->app_id }}">
                <input type="hidden" name="claim_id" value="{{ $apps->claim_id }}">


                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-info">
                        <strong>Miscellaneous(Optional)</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="card border-primary p-0 m-10">
                                <div class="card-header bg-gradient-info">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example"
                                            class="table table-sm table-striped table-bordered table-hover"
                                            id="dynamic_field">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-center">S.N</th>
                                                    <th class="text-center">Miscellaneous Certificates Name</th>
                                                    <th class="text-center">Upload pdf</th>
                                                    <th class="text-center">View Pdf</th>
                                                    <th class="text-center">Upload excel</th>
                                                    <th class="text-center">View Excel</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($doc_data) > 0)
                                                    @foreach ($doc_data as $k => $data)
                                                        <tr>
                                                            <td class="text-center">{{ $k + 1 }}</td>
                                                            <input type="hidden" value="{{ $data->upload_id }}"
                                                                name="Misc_{{ $k + 1 }}[id]">
                                                            <input type="hidden" value="{{ $data->id }}"
                                                                name="Misc_{{ $k + 1 }}[info_id]">
                                                            <td><input type="text" class="form-control form-control-sm"
                                                                    name="Misc_{{ $k + 1 }}[name]" id="doc"
                                                                    value="{{ $data->file_name }}"></td>
                                                            <td><input type="file"
                                                                    name="Misc_{{ $k + 1 }}[doc][pdf]"></td>

                                                            <td class="text-center p-2 ">
                                                                @if ($data->upload_id)
                                                                    <a class=" mt-2 btn-sm btn-success"
                                                                        href="{{ route('doc.down', $data->upload_id) }}">
                                                                        View</a>
                                                                @endif
                                                            </td>
                                                            <td><input type="file"
                                                                    name="Misc_{{ $k + 1 }}[doc][excel]"></td>
                                                            <td class="text-center p-2 ">
                                                                @if ($data->upload_id_excel)
                                                                    <a class=" mt-2 btn-sm btn-success"
                                                                        href="{{ route('doc.down', $data->upload_id_excel) }}">
                                                                        View</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if ($tot_misc != 0)
                                                    @for ($i = 1; $i <= $tot_misc; $i++)
                                                        <tr>
                                                            <td class="text-center">{{ sizeof($doc_data) + $i }}</td>
                                                            <td><input type="text" class="form-control form-control-sm"
                                                                    name="Misc_{{ sizeof($doc_data) + $i }}[name]"
                                                                    id="doc" value=""></td>
                                                            <td><input type="file"
                                                                    name="Misc_{{ sizeof($doc_data) + $i }}[doc][pdf]"></td>
                                                            <td></td>
                                                            <td><input type="file"
                                                                    name="Misc_{{ sizeof($doc_data) + $i }}[doc][excel]">
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    @endfor
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row pb-2">
                    <div class="col-md-2 offset-md-0">

                        <a href="{{ route('claimdocumentupload.create', ['B', $apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i>Document Section B</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="submitshareper">
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        @if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-12-31 23:59:00')))
                            <a href="{{ route('claims.submit', $apps->claim_id) }}" id="finalSubmit"
                                class="btn btn-primary btn-sm form-control form-control-sm">
                                Final Submit <i class="fas fa-save"></i>
                            </a>
                        @else
                            <button type="button" class="btn btn-danger btn-sm btn-block" disabled>
                                !! The claim form has been closed. !!
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @push('scripts')
        <!-- {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadCRequest', '#application-create') !!} -->
    @endpush
@endpush
