@extends((Auth::user()->hasRole('Admin') or Auth::user()->hasRole('ViewOnlyUser') or Auth::user()->hasRole('Admin-Ministry') or Auth::user()->hasRole('Meity')) ? 'layouts.admin.master' : 'layouts.user.dashboard-master')

@section('title')
    Service Request Portal
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-tabs">
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="grvTabContent" role="tabpanel"
                            aria-labelledby="appTabContent-tab">
                            <div class="card border-primary mt-2" id="comp">
                                <div class="card-body p-0">
                                    <div class="card-header bg-gradient-primary">
                                        <b>Request Details</b>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover">
                                            @foreach ($reqs as $req)
                                                <tbody>
                                                    {{-- <tr>

                                                        <th style="width: 25%" class='pl-4'>Applicant Details</th>
                                                        <td style="width: 75%">
                                                            <table class="table table-sm table-bordered table-hover">
                                                                <tbody>
                                                                    <tr>

                                                                        <th style="width: 40%" class='pl-4'>User Name</th>
                                                                        <td style="width: 60%">{{ $req->name }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Registered Adddress</th>
                                                                        <td>{{ $req->reg_add }} ,
                                                                            {{ $req->regaddcity }},
                                                                            {{ $req->regaddstate }},
                                                                            {{ $req->regaddcountry }},
                                                                            {{ $req->regaddpin }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr> --}}

                                                    <tr>
                                                        <th>Request Details</th>
                                                        <td>
                                                            <table class="table table-sm table-bordered table-hover">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'> Initiated
                                                                            By
                                                                        </th>
                                                                        <td>{{ CompanyName($req->user_id) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'> Initiated
                                                                            To
                                                                        </th>
                                                                        <td>{{ CompanyName($req->raised_for_user) }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'> App
                                                                            No
                                                                        </th>
                                                                        <td>{{ $req->app_no }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'> Category
                                                                        </th>
                                                                        <td style="width: 60%">{{ $req->category_desc }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>

                                                                        <th style="width: 40%" class='pl-4'> Sub Type
                                                                        </th>
                                                                        <td style="width: 60%">{{ $req->subtype_desc }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'> Request Type
                                                                        </th>

                                                                        <td style="width: 60%">{{ $req->category_desc }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th style="width: 40%" class='pl-4'>
                                                                            Submittion Date
                                                                        </th>
                                                                        <td style="width: 60%">
                                                                            {{ $req->first_applied_dt }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Request</th>
                                                        <td>
                                                            @foreach ($reqDets as $reqDet)
                                                                <table class="table table-sm table-bordered table-hover">
                                                                    <tbody>



                                                                        @if ($reqDet->req_id == $req->id)
                                                                            <tr>
                                                                                <th style="width: 40%" class='pl-4'>
                                                                                    Message</th>
                                                                                <td style="width: 60%">{{ $reqDet->msg }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                @if ($reqDet->created_by == $req->user_id)
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Submitted By</th>
                                                                                    <td style="width: 60%">
                                                                                        {{ CompanyName($reqDet->created_by) }}
                                                                                    </td>
                                                                                @else
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Replied By</th>
                                                                                    <td style="width: 60%">
                                                                                        {{ CompanyName($reqDet->created_by) }}
                                                                                    </td>
                                                                                @endif

                                                                            </tr>
                                                                            <tr>
                                                                                @if ($reqDet->created_by == $req->user_id)
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Submitted On</th>
                                                                                @else
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Replied On</th>
                                                                                @endif
                                                                                <td style="width: 60%">
                                                                                    {{ $reqDet->created_at }}</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th style="width: 40%" class='pl-4'>
                                                                                    Documents</th>

                                                                                <td>
                                                                                    @if ($reqDet->doc_id)
                                                                                        @foreach ($reqDet->doc_id as $doc_id)
                                                                                            @foreach ($docs as $doc)
                                                                                                @if ($doc->id == $doc_id)
                                                                                                    <div></div>
                                                                                                    <a
                                                                                                        href="{{ route('req_download', $doc_id) }}"><i
                                                                                                            class="fa fa-eye "></i>{{ $doc->file_name }}</a>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr style="background-color:#0400ff">
                                                                                <th style="width: 40%" class='pl-4'>
                                                                                </th>
                                                                                <td></td>
                                                                            </tr>
                                                                        @endif

                                                                    </tbody>
                                                                </table>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endforeach

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form action='{{ route('reqcreate.update', $reqHd->id) }}' id="reqcreate" role="form" method="post"
                        class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        {!! method_field('patch') !!}
                        @csrf
                        <input type="hidden" id="reqhd_id" name="reqhd_id" value="{{ $reqHd->id }}">
                        {{-- <input type="hidden" id="qtr_name" name="qtr_name" value="{{ $qtr }}"> --}}

                        <div class="card border-primary p-0 m-10">
                            <div class="card-header bg-gradient-primary">
                                <b>Reply</b>
                            </div>

                            <div class="card-body">
                                @if (Auth::user()->id == $reqHd->user_id)
                                    <div class="form-group row col-md-8 offset-2 mt-2">
                                        <label
                                            class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                            Status</label>
                                        <div class="col-lg-9 col-12">
                                            <select class="custom-select" id="status" name="status"
                                                style="height:2.25rem;">
                                                <option value="R">Revert</option>
                                                <option value="C">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row col-md-8 offset-2 mt-2">
                                    <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                        Message *</label>
                                    <div class="col-lg-9 col-12">
                                        <div class="input-group input-group-prepend">
                                            <textarea id="msg" name="msg" class="form-control form-control-sm" rows="5" placeholder="Write your Message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row col-md-8 offset-2 mt-2">
                                    <label class="col-form-label text-lg-left text-left col-lg-3 col-12 col-form-label-sm ">
                                        Documents</label>
                                    <div class="col-lg-9 col-12">
                                        <div class="input-group input-group-prepend">
                                            {{-- <input type="file" id="reqdoc" name="reqdoc[]"
                                                class="form-control form-control-sm" multiple> --}}

                                            {{-- <input class="" type="file" id="input_file_id"
                                                onchange="fileList(event)" name="reqdoc[]" multiple>
                                            <div id="listfiles" class="view_list"></div> --}}
                                            <div id="dynamicTable">
                                                <div class="row pb-2">
                                                    <div class="col-md-8">
                                                        <div class="form">
                                                            {{-- <label class="bmd-label-floating">Product Image</label> --}}

                                                            <input type="file" id="reqdoc" name="reqdoc[]"
                                                                class="form-control form-control-sm" multiple>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form">
                                                            <button type="button" name="add" id="add"
                                                                class="btn btn-success"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-md-2 offset-md-5">
                                <button type="submit"
                                    class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                                    id="submitshareper"><i class="fas fa-save"></i>
                                    Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="row pb-2">
            <div class="col-md-2 offset-md-5">
                <div onclick="printPage();" class="btn btn-warning btn-sm form-control form-control-sm">
                    Print <i class="fas fa-print"></i>
                </div>

            </div>
        </div> --}}
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
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
    {{-- <script>
        function uploadFile(evt) {
            evt.preventDefault();
            $('#input_file_id').click();
        }

        count = 0;

        function fileList(e) {
            var files = $('#input_file_id').prop("files");
            var names = $.map(files, function(val) {
                return val.name;
            });

            for (n in names) {
                // alert(count);

                $("#listfiles").append("<div id=preload_" + count + " title='" + names[n] + "'>" + names[n] +
                    "<a  onclick=deleteFile(" + count + ")>  <i class='far fa-times-circle fa-lg'></i></a></div>");
                count++;
            }

        }

        function deleteFile(index) {
            filelistall = $('#input_file_id').prop("files");
            var fileBuffer = [];
            Array.prototype.push.apply(fileBuffer, filelistall);
            fileBuffer.splice(index, 1);
            const dT = new ClipboardEvent('').clipboardData || new DataTransfer();
            for (let file of fileBuffer) {
                dT.items.add(file);
            }
            filelistall = $('#input_file_id').prop("files", dT.files);
            $("#preload_" + index).remove()
        }
    </script> --}}
    <script src="{{ asset('js/jsvalidation.min.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#reqcreate') !!}
@endpush
