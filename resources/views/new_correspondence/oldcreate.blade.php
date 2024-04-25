@extends((Auth::user()->hasRole('Admin') or Auth::user()->hasRole('ViewOnlyUser') or Auth::user()->hasRole('Admin-Ministry') or Auth::user()->hasRole('Meity')) ? 'layouts.admin.master' : 'layouts.user.dashboard-master')

@section('title')
    Service Request Form
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action='{{ route('reqcreate.store') }}' id="reqcreate" role="form" method="post" class='form-horizontal prevent_multiple_submit'
                files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                {{-- <input type="hidden" id="app_id" name="app_id" value="{{ $apps->id }}">
            <input type="hidden" id="qtr_name" name="qtr_name" value="{{ $qtr }}"> --}}

                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-gradient-primary">
                        <b>Request Details</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                From </label>
                            <div class="col-lg-9 col-12">
                                <input type="text" class="form-control form-control-sm" value="{{ Auth::user()->name }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                To </label>
                            <div class="col-lg-9 col-12">
                                <select class="form-control" name="user_type" id="user_type">
                                    <option value="">Select</option>
                                    @foreach ($valid_roles as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(AUTH::user()->hasRole('Applicant'))
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                User</label>

                            <div class="col-lg-9 col-12">
                                {{-- <select class="custom-select" name="request_to" id="userlist" style="height:2.25rem;"> --}}
                                <select class="form-control" name="request_to" id="userlist" style="height:2.25rem;">
                                </select>

                            </div>
                        </div>
                        @else
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Applicant List</label>

                            <div class="col-lg-9 col-12">
                                {{-- <select class="custom-select" name="request_to" id="userlist" style="height:2.25rem;"> --}}
                                <select class="form-control" name="request_to" id="userlist" style="height:2.25rem;">
                                </select>

                            </div>
                        </div>

                        @endif

                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Application No</label>

                            <div class="col-lg-9 col-12">
                                <select class="form-control" name="application_number" id="application_number" style="height:2.25rem;">
                                </select>

                            </div>
                        </div>


                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Category</label>
                            <div class="col-lg-9 col-12">
                                <select class="form-control" id="category" name="related_to">
                                    <option value="">Select</option>
                                    @foreach ($moduleRows as $moduleRow)
                                        <option value="{{ $moduleRow->id }}">{{ $moduleRow->category_desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Sub Category</label>
                            <div class="col-lg-9 col-12">
                                {{-- <select class="custom-select" id="catsubtype" name="catsubtype" style="height:2.25rem;"> --}}
                                <select class="form-control" id="catsubtype" name="catsubtype" style="height:2.25rem;">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Type Of Request</label>
                            <div class="col-lg-9 col-12">
                                {{-- <select class="custom-select" id="reqtype" name="reqtype" style="height:2.25rem;"> --}}
                                <select class="form-control" id="reqtype" name="reqtype" style="height:2.25rem;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Message *</label>
                            <div class="col-lg-9 col-12">
                                <div class="input-group input-group-prepend">
                                    <textarea id="msg" name="msg" class="form-control form-control-sm" rows="5"
                                        placeholder="Type your message"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row col-md-8 offset-2 mt-2">
                            <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                Documents</label>
                            <div class="col-lg-9 col-12">
                                {{-- <div class="input-group input-group-prepend">
                                    <input type="file" id="reqdoc" name="reqdoc[]"
                                        class="form-control form-control-sm" multiple>

                                </div> --}}

                                {{-- <div class="files float-left ms-5" id="files1">
                                    <span class="row btn btn-file">
                                        <input type="file" id="input_file_id" name="files1" multiple />Browse </span>
                                    <ul class="fileList ms-5"></ul>
                                </div> --}}

                                <div class="files float-left ms-5">
                                    {{-- <span class="row btn btn-file"
                                        onclick="uploadFile(event)>
                                       <input class="hidden"
                                        type="file" id="input_file_id" onchange="fileList(event)" name="files[]"
                                        multiple> Browse </span>
                                    <ul class="fileList ms-5"></ul> --}}

                                    {{-- <button onclick="uploadFile(event)">Upload files</button> --}}

                                    {{-- <input class="hidden" type="file" id="input_file_id" onchange="fileList(event)"
                                        name="reqdoc[]" multiple>
                                    <div id="listfiles" class="view_list"></div> --}}


                                    <div id="dynamicTable">
                                        <div class="row pb-2">
                                            <div class="col-md-8">
                                                <div class="form">
                                                    {{-- <label class="bmd-label-floating">Product Image</label> --}}

                                                    <input type="file" id="reqdoc" name="reqdoc[]"
                                                        class="form-control form-control-sm" multiple>


                                                    {{-- <input type="file" id="reqdoc" name="reqdoc"
                                                        class="form-control form-control-sm" onchange="getFileData(this);"> --}}

                                                    {{-- <input type="file" name="file" id="file" multiple
                                                        onchange="javascript:updateList()" />
                                                    <br />Selected files:
                                                    <div id="fileList"></div> --}}



                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form">
                                                    <button type="button" name="add" id="add"
                                                        class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-md-0">
                        <a href="{{ URL::previous() }}" class="btn btn-warning btn-sm form-control form-control-sm"><em class="fas fa-angle-double-left"></em> Back</a>
                       
                    </div>
                    <div class="col-md-2 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"
                            id="submitshareper"><i class="fas fa-save"></i>
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("change", "#category", function() {
                // dd('pk1');
                var category = $(this).val();
                //    alert('/category/' + category);
                if (category) {
                    $.ajax({
                        url: '/category/' + category,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // alert(category);
                            if (category == 3) {
                                $("#compNmLabel").show();
                                $("#company_nm").show();
                                $("#pan").hide();
                                $("#panLabel").hide();
                                $("#dp_folio").hide();
                                $("#dpLabel").hide();
                                $("#emp_id").hide();
                                $("#empIdLabel").hide()
                                $("#desig").hide();
                                $("#desigLabel").hide();
                            } else {
                                if (category == 4) {
                                    $("#emp_id").show();
                                    $("#empIdLabel").show();
                                    $("#desig").show();
                                    $("#desigLabel").show();
                                    $("#pan").hide();
                                    $("#panLabel").hide();
                                    $("#dp_folio").hide();
                                    $("#dpLabel").hide();
                                    $("#compNmLabel").hide();
                                    $("#company_nm").hide();
                                } else {
                                    $("#emp_id").hide();
                                    $("#empIdLabel").hide();
                                    $("#desig").hide();
                                    $("#desigLabel").hide();
                                    $("#compNmLabel").hide();
                                    $("#company_nm").hide();
                                    $("#pan").show();
                                    $("#panLabel").show();
                                    $("#dp_folio").show();
                                    $("#dpLabel").show();
                                }
                            }
                            $('#catsubtype').empty();
                            $('#catsubtype').append(
                                '<option value="">Please Choose..</option>');
                            $.each(data, function(key, value) {
                                $('#catsubtype').append(
                                    '<option value="' + value + '">' + key +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#catsubtype').empty();
                }

                $(document).on("change", "#catsubtype", function() {
                    // dd('pk1');
                    var catsubtype = $(this).val();
                    // alert(catsubtype);
                    if (category) {
                        $.ajax({
                            url: '/reqtype/' + category + '/' + catsubtype,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                // alert(category);
                                $('#reqtype').empty();
                                $('#reqtype').append(
                                    '<option value="">Please Choose..</option>');
                                $.each(data, function(key, value) {
                                    $('#reqtype').append(
                                        '<option value="' + value + '">' +
                                        key +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        $('#reqtype').empty();
                    }
                });
            });
        });


        var i = 0;
        $("#add").click(function() {
            ++i;
            $("#dynamicTable").append(
                '<div class="row pb-2"><div class="col-md-8 "><div class="form"><input type="file" name="reqdoc[]" class="form-control" multiple></div></div><div class="col-md-2"><div class="form"><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-minus"></i></button></div></div></div>'
            );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).closest(".row").remove();
        });
    </script>
    <script>
        updateList = function() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');

            output.innerHTML = '<ul>';
            for (var i = 0; i < input.files.length; ++i) {
                output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
            }
            output.innerHTML += '</ul>';
        }
    </script>

    <script>
        $(document).ready(function() {
            const btn_modal = document.getElementById("submitshareper");

            $('.prevent_multiple_submit').on('submit', function() {
                $(".prevent_multiple_submit").parent().append(
                    '<div class="offset-md-4 msg"><span class="text-danger text-sm text-center">Please wait while your request is being processed. &nbsp&nbsp&nbsp<i class="fa fa-spinner fa-spin" style="font-size:24px;color:black"></i></span></div>'
                    );

              
                btn_modal.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 50));
                setTimeout(function() {
                    btn_modal.disabled = false;
                }, (1000 * 50));
                setTimeout(function() {
                    $(".msg").hide()
                }, (1000 * 50));
            });

        });
    </script>


    <script src="{{ asset('js/jsvalidation.min.js') }}"></script>

    @include('new_correspondence.js.correspondence_request')
    {!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#reqcreate') !!}
@endpush
