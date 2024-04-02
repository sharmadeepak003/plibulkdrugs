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
            <form action='{{ route('raisecomp') }}' id="raisecomp" role="form" method="post" class='form-horizontal'
                files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                <div class="card card-info card-tabs">
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="grvTabContent" role="tabpanel"
                                aria-labelledby="appTabContent-tab">
                                <div class="card border-primary mt-2" id="Name">
                                    <div class="card-body p-0">
                                        <div class="card-header bg-gradient-info text-center  font-weight-light">
                                            <b style="font-size: 20px">Request</b>
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

                                                                            <th style="width: 40%" class='pl-4'>User Name
                                                                            </th>
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
                                                                            <th style="width: 40%" class='pl-4'> Request
                                                                                Type</th>
                                                                            <td style="width: 60%">{{ $req->type_desc }}
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
                                                            <th>Request Trail</th>
                                                            <td>
                                                                <table class="table table-sm table-bordered table-hover">
                                                                    <tbody>

                                                                        @foreach ($reqDets as $reqDet)
                                                                            {{-- {{dd($req->id )}} --}}
                                                                            @if ($reqDet->req_id == $req->id)
                                                                                <tr>
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Message</th>
                                                                                    <td style="width: 60%">
                                                                                        {{ $reqDet->msg }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    @if (Auth::user()->hasrole('ActiveUser'))
                                                                                        @if ($reqDet->created_by == Auth::user()->id)
                                                                                            <th style="width: 40%"
                                                                                                class='pl-4'>Submitted By
                                                                                            </th>
                                                                                            <td style="width: 60%">
                                                                                                {{ CompanyName($reqDet->created_by) }}
                                                                                            </td>
                                                                                        @else
                                                                                            <th style="width: 40%"
                                                                                                class='pl-4'>Replied By
                                                                                            </th>
                                                                                            <td style="width: 60%">
                                                                                                {{ CompanyName($reqDet->created_by) }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($reqDet->created_by == Auth::user()->id)
                                                                                            <th style="width: 40%"
                                                                                                class='pl-4'>Replied By
                                                                                            </th>
                                                                                            <td style="width: 60%">
                                                                                                {{ CompanyName($reqDet->created_by) }}
                                                                                            </td>
                                                                                        @else
                                                                                            <th style="width: 40%"
                                                                                                class='pl-4'>Submitted By
                                                                                            </th>
                                                                                            <td style="width: 60%">
                                                                                                {{ CompanyName($reqDet->created_by) }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endif

                                                                                </tr>
                                                                                <tr>
                                                                                    @if ($reqDet->created_by == Auth::user()->id)
                                                                                        <th style="width: 40%"
                                                                                            class='pl-4'>Submitted On</th>
                                                                                    @else
                                                                                        <th style="width: 40%"
                                                                                            class='pl-4'>Submitted On</th>
                                                                                    @endif
                                                                                    <td style="width: 60%">
                                                                                        {{ $reqDet->created_at }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                        Documents</th>
                                                                                    @if ($reqDet->doc_id)
                                                                                        <td>
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
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                                <tr style="background-color:#0400ff">
                                                                                    <th style="width: 40%" class='pl-4'>
                                                                                    </th>
                                                                                    <td></td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
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

                <div class="row pb-2">
                    <div class="col-md-2 offset-md-4">
                        <a href="javascript:void(0);" onclick="printPage();"
                            class="btn btn-warning btn-sm form-control form-control-sm">Print<i
                                class="fas fa-print"></i></a>
                    </div>
                    {{-- <div class="col-md-2 ">
                @foreach ($days as $day)
                @if ($req->cat_id == $day->cat_id && $req->cat_subtype == $day->cat_subtype)
                @if (Carbon\Carbon::parse($req->pending_since)->adddays(21) <= Carbon\Carbon::now() && Auth::user()->hasRole('ActiveUser') && empty($req->complaint_id))
                <input type="hidden" id="reqhd_id" name="reqhd_id" value="{{ $req->id }}">
                <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                        id="submitshareper"><i class="fas fa-save"></i>
                        Raise Complaint </button>
                @endif
                @endif
                @endforeach
            </div> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @include('user.partials.js.corres_show')
@endpush
