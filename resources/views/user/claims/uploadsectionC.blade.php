@extends('layouts.user.dashboard-master')

@section('title')
    Claim: Miscellaneous Document Upload
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"]{
            padding:1px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('claimdocumentupload.store','C') }}" id="application-create" role="form" method="POST"
                class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <input type="hidden" name="app_id" value="{{$apps->app_id}}">
                <input type="hidden" name="claim_id" value="{{$apps->claim_id}}">

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
                                        <table id="example" class="table table-sm table-striped table-bordered table-hover"
                                        id="dynamic_field">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">S.N</th>
                                                <th class="text-center">Miscellaneous Certificates Name</th>
                                                <th class="text-center">Upload PDF</th>
                                                <th class="text-center">Upload Excel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_1[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_1[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_1[doc][excel]" ></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_2[name]" id="doc" ></td>
                                                <td><input type="file" name="Misc_2[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_2[doc][excel]" ></td>

                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_3[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_3[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_3[doc][excel]" ></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_4[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_4[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_4[doc][excel]" ></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td ><input type="text" class="form-control form-control-sm"
                                                    name="Misc_5[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_5[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_5[doc][excel]" ></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_6[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_6[doc][pdf]" ></td>
                                                <td><input type="file" name="Misc_6[doc][excel]" ></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">7</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_7[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_7[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_7[doc][excel]"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">8</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_8[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_8[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_8[doc][excel]"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">9</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_9[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_9[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_9[doc][excel]"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">10</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_10[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_10[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_10[doc][excel]"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">11</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_11[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_11[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_11[doc][excel]"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">12</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                    name="Misc_12[name]" id="doc" value=""></td>
                                                <td><input type="file" name="Misc_12[doc][pdf]"></td>
                                                <td><input type="file" name="Misc_12[doc][excel]"></td>
                                            </tr>
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

                        <a href="{{ route('claimdocumentupload.create', ['B',$apps->claim_id]) }}"
                            class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa  fa-backward"></i>Document Section B</a>
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="submitshareper" >
                            <em class="fas fa-save"></em>Save as Draft
                        </button>
                    </div>
                    {{-- <div class="col-md-2 offset-md-3">
                        <a href="{{ route('claims.submit', $apps->claim_id) }}" id="finalSubmit"
                            class="btn btn-primary btn-sm form-control form-control-sm">
                            Final Submit <i class="fas fa-save"></i>
                        </a>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add').click(function() {
                i++;
                    $('#related').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td> <td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][period]" id="name" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][from_date]" id="from_date" class="form-control form-control-sm name_list1"></td> <td class="text-center"><input type="date" name=" GenCompDoc['+ (sn-1) +'][to_date]" id="to_date" class="form-control form-control-sm name_list1"></td><td class="text-center"><input type="file" name=" GenCompDoc['+ (sn-1) +'][doc]" id="to_date" class="form-control form-control-sm name_list1"></td><td></td><td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            $('#problem').on('change', function() {
                $('.display').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });
    </script>
@push('scripts')
<!-- {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimUploadCRequest', '#application-create') !!} -->
@endpush
@endpush
