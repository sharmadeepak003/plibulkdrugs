@extends((Auth::user()->hasRole('Admin') or Auth::user()->hasRole('ViewOnlyUser') or Auth::user()->hasRole('Admin-Ministry') or Auth::user()->hasRole('Meity')) ? 'layouts.admin.master' : 'layouts.user.dashboard-master')


@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Current Application-->
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="text-center">Service Requests </h5>
                        </div>
                        @if (AUTH::user()->hasRole('Admin'))
                        <div class="col-md-2">
                            <a href="{{ route('reqcreate.create') }}"
                                class="btn btn-warning btn-sm form-control form-control-sm">
                                <i class="fas fa-user-plus"></i> New Request</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="userreq"
                                    class="table table-sm table-striped table-bordered table-hover width=100%"
                                    style="font-size:12px">
                                    <thead>
                                        <tr class="table-primary">
                                            <th style="width: 2%">Sr No</th>
                                            <th style="width: 10%">Initiated By </th>
                                            <th style="width: 15%">Initiates To</th>
                                            <th style="width: 10%">Date</th>
                                            <th style="width: 10%">Category</th>
                                            {{-- <th style="width: 20%">Type</th> --}}
                                            <th style="width: 15%">Request For</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 5%">Action</th>
                                            @if ($hasRole[0] == 'Admin')
                                                <th style="width: 12%">Visible To Ministry</th>
                                                <th style="width: 30%">Visible To Compliance</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reqs as $key => $req)
                                            {{-- {{ dd($req) }} --}}
                                            {{-- @if ($app->eligible_product == $prod->id) --}}
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                <td>{{ CompanyName($req->user_id) }}</td>
                                                <td>{{ CompanyName($req->raised_for_user) }}</td>

                                                <td>{{ Carbon\Carbon::parse($req->first_applied_dt)->format('Y-m-d') }}</td>
                                                <td>{{ $req->category_desc }}</td>
                                                <td>{{ $req->type_desc }}</td>
                                                {{-- <td>
                                                    @if ($req->req_id == Auth::User()->id)
                                                        Admin
                                                    @else
                                                        Applicant
                                                    @endif
                                                </td> --}}
                                                <td>

                                                    @if ($req->status == 'C')
                                                        Closed
                                                    @elseif ($req->status == 'R' || $hasRole[0] == $req->raise_by_role)
                                                        Reverted
                                                    @elseif ($req->status == 'R' || $hasRole[0] != $req->raise_by_role)
                                                        {{-- {{ dd($req->raise_by_role) }} --}}
                                                        Reverted
                                                    @elseif ($req->status == 'S')
                                                        Submitted
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- {{ dd($hasRole[0]) }} --}}
                                                    @if ($hasRole[0] == $req->pending_with && $req->status != 'C')
                                                        {{-- {{ dd($req->status) }} --}}
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                        </button>
                                                        {{-- @elseif ($req->pending_with == $hasRole[0])
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a> --}}
                                                    @elseif ($req->status == 'C')
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>
                                                    @else
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>
                                                    @endif

                                                    {{-- @if ($req->raised_for_user == Auth::User()->id && $req->pending_with == 'User')
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                        </button>
                                                    @elseif ($req->raised_for_user == Auth::User()->id && $req->raise_by_role == 'User' && $req->pending_with == 'Admin')
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                        </button>
                                                    @elseif ($req->raise_by_role == 'Admin-Ministry' && $req->pending_with == 'Admin')
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                        </button>
                                                    @elseif ($req->raise_by_role == 'Admin' && $req->pending_with == 'Admin' && $req->raised_for_user != Auth::User()->id)
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                        </button>
                                                    @else
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>
                                                    @endif --}}
                                                </td>
                                                @if ($hasRole[0] == 'Admin')
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            @if ($req->visible == 1) checked @endif
                                                            onclick="UpdateStatus(this.value)" value="{{ $req->id }}"
                                                            name='checked' style="width: 10%"
                                                            id="agree{{ $req->id }}">
                                                    </td>
                                                @endif
                                                @if ($hasRole[0] == 'Admin')
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            @if ($req->visible_com == 1) checked @endif
                                                            onclick="UpdateCom(this.value)" value="{{ $req->id }}"
                                                            name='checked' style="width: 10%" id="com{{ $req->id }}">
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('table').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                    "searchPlaceholder": "search",
                    "paginate": {
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>'
                    }
                }
            });
        });

        function UpdateStatus(Status) {

            var checkbox = document.getElementById('agree' + Status);
            if (checkbox.checked == true) {

                var checkedstatus = 1;

            } else {
                var checkedstatus = 0;

            }

            $(function() {
                $.ajax({
                    url: '/checksts/' + Status + '/' + checkedstatus,
                    data: "",
                    dataType: 'json'
                });

                // alert(url);

            });

        }

        function UpdateCom(Status) {

            var checkbox = document.getElementById('com' + Status);
            if (checkbox.checked == true) {

                var checkedstatus = 1;

            } else {
                var checkedstatus = 0;

            }

            $(function() {
                $.ajax({
                    url: '/visiblecom/' + Status + '/' + checkedstatus,
                    data: "",
                    dataType: 'json'
                });

                // alert(url);

            });

        }
    </script>
@endpush
