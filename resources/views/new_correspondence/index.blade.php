@extends((Auth::user()->hasRole('Admin') or Auth::user()->hasRole('ViewOnlyUser') or Auth::user()->hasRole('Admin-Ministry') or Auth::user()->hasRole('Meity')) ? 'layouts.admin.master' : 'layouts.user.dashboard-master')


@section('title')
    Dashboard
@endsection

@section('content')
    @if (Auth::user()->hasRole('Admin') or Auth::user()->hasRole('ViewOnlyUser'))
        @if (!isset($claim_id))
            <form id="correspondenceFilterForm" action="{{ route('admin.correspondence_filter') }}" method="GET">
                @csrf
                <div class="row m-3">
                    <div class="col-md-3 offset-md-1">
                        <label>Company Name</label>
                        <select class="form-control" id="company_id" name="company_id" required>
                            <option value="">Choose Option</option>
                            <option value="all" {{ isset($company_id) && $company_id == 'all' ? 'selected' : '' }}>All
                            </option>
                            @foreach ($users as $value)
                                {{-- <option value="{{ $value->id }}">{{ $value->name }}</option> --}}
                                <option value="{{ $value->id }}"
                                    {{ isset($company_id) && $company_id == $value->id ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Category</label>
                        <select class="form-control" id="category_type" name="category_type" required>
                            <option value="">Choose Option</option>
                            <option value="all" {{ isset($category_type) && $category_type == 'all' ? 'selected' : '' }}>
                                All</option>
                            @foreach ($moduleRows as $moduleRow)
                                <option value="{{ $moduleRow->id }}"
                                    {{ isset($category_type) && $category_type == $moduleRow->id ? 'selected' : '' }}>
                                    {{ $moduleRow->category_desc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                            id="submitshareper" style="margin-top: 9px">
                            <b>Filter</b></button>
                    </div>
                </div>
            </form>
        @endif
    @endif
    <div class="row">

        <div class="col-md-12">
            <!-- Current Application-->
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="text-center">Service Requests</h5>
                        </div>
                        {{-- @if (AUTH::user()->hasRole('Admin')) --}}

                        {{-- @if ($hasRole[0] != 'Admin-Ministry')
                            @if (!isset($claim_id))
                                <div class="col-md-2">
                                    <a href="{{ route('reqcreate.create') }}"
                                        class="btn btn-warning btn-sm form-control form-control-sm">
                                        <i class="fas fa-user-plus"></i> New Request</a>
                                </div>
                            @endif
                        @endif --}}
                        @if(in_array("CorresReply", $hasRole) || in_array("Applicant", $hasRole) )
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
                                            {{-- <th style="width: 10%">Company Name</th> --}}
                                            <th style="width: 10%">Initiated By </th>
                                            <th style="width: 15%">Initiates To</th>
                                            <th style="width: 15%">App No</th>
                                            <th style="width: 10%">Date</th>
                                            <th style="width: 10%">Category</th>
                                            {{-- <th style="width: 20%">Type</th> --}}
                                            <th style="width: 15%">Request For</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 5%">Action</th>
                                            @if ($hasRole[0] == 'Admin')
                                                @if (!isset($claim_id))
                                                    <th style="width: 12%">Visible To Ministry</th>
                                                    <th style="width: 30%">Visible To Compliance</th>
                                                @endif
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="filter-data">

                                        @foreach ($reqs as $key => $req)
                                            {{-- {{ dd($req) }} --}}
                                            {{-- @if ($app->eligible_product == $prod->id) --}}
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- <td class="text-center">{{ $req->name }}</td> --}}

                                                <td>{{ CompanyName($req->user_id) }}</td>
                                                <td>{{ CompanyName($req->raised_for_user) }}</td>
                                                <td>{{ $req->app_no }}</td>
                                                <td>{{ Carbon\Carbon::parse($req->first_applied_dt)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $req->category_desc }}</td>
                                                <td>{{ $req->type_desc }}</td>
                                                <td>

                                                    @if ($req->status == 'C')
                                                        Closed
                                                    @elseif ($req->status == 'R' || $hasRole[0] == $req->raise_by_role)
                                                        Reverted
                                                    @elseif ($req->status == 'R' || $hasRole[0] != $req->raise_by_role)
                                                        Reverted
                                                    @elseif ($req->status == 'S')
                                                        Submitted
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($hasRole[0] == $req->pending_with && $req->status != 'C')
                                                    
                                                    @if(in_array("CorresReply", $hasRole) || in_array("Applicant", $hasRole) )
                                                        <a href="{{ route('reqcreate.edit', ['id' => $req->id]) }}"
                                                            class="btn btn-warning btn-sm btn-block">Reply</a>

                                                    @else
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>

                                                    @endif
                                                    @elseif ($req->status == 'C')
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>
                                                    @else
                                                        <a href="{{ route('reqcreate.show', $req->id) }}"
                                                            class="btn btn-success btn-sm btn-block">View</a>
                                                    @endif

                                                </td>
                                                @if ($hasRole[0] == 'Admin')
                                                    @if (!isset($claim_id))
                                                        <td>
                                                            <input type="checkbox" class="form-check-input"
                                                                @if ($req->visible == 1) checked @endif
                                                                onclick="UpdateStatus(this.value)"
                                                                value="{{ $req->id }}" name='checked'
                                                                style="width: 10%" id="agree{{ $req->id }}">
                                                        </td>
                                                    @endif
                                                @endif
                                                @if ($hasRole[0] == 'Admin')
                                                    @if (!isset($claim_id))
                                                        <td>
                                                            <input type="checkbox" class="form-check-input"
                                                                @if ($req->visible_com == 1) checked @endif
                                                                onclick="UpdateCom(this.value)" value="{{ $req->id }}"
                                                                name='checked' style="width: 10%"
                                                                id="com{{ $req->id }}">
                                                        </td>
                                                    @endif
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

    {{-- <script>
        $(document).ready(function() {
            // Set CSRF token for all jQuery AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submitshareper').on('click', function(e) {
                e.preventDefault();
                var formData = {
                    company_id: $('#company_id').val(),
                    category_type: $('#category_type').val(),

                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route('correspondence_filter') }}',
                    data: formData,
                    success: function(response) {
                        $('#filter-data').empty();
                        var data = JSON.parse(response);
                        data.forEach(function(item) {
                            var newRow = '<tr>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '</tr>';
                            $('#filter-data').append(newRow);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle errors here
                    }
                });
            });
        });
    </script> --}}
@endpush
