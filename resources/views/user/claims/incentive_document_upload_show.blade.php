@extends(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry') ? 'layouts.admin.master' : 'layouts.user.dashboard-master')


@section('title')
    Claim: Incentive Document Upload
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
        <div class="col-4 offset-9">
            @if(Auth::user()->hasRole('Admin'))
            {{-- <a onclick="return confirm('Are you sure?')" href="{{ url('/admin/claims/twenty_percentage_incentive_editmode/' . $claim_id) }}" class="btn btn-warning  btn-block mb-2" id="" >Open 20% Incentive In Edit Mode</a> --}}
            <a  href="{{ url('/admin/claims/twenty_percentage_incentive_editmode/' . $claim_id) }}" class="btn btn-warning  btn-sm mb-2"  id="" >Open 20% Incentive In Edit Mode</a>
            @endif
        </div>
        <div class="col-md-12">

            <div class="card border-primary">
                <div class="card-body">
                        <table id="example" class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                                <tr class="table-primary"class="table-primary">
                                    <th class="text-center">Sr. No</th>
                                    <th class="text-center">Document Name</th>
                                    <th class="text-center">PDF View</th>
                                    <th class="text-center">Excel View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doc_particular as $key => $docPart)
                                    @foreach ($doc_map as $key => $map_data)
                                        @if ($docPart->id == $map_data->prt_id)
                                            <tr>
                                                <td class="text-center">{{ $docPart->serial_number }}
                                                </td>
                                                @if ($docPart->subsetof_particular == 99)
                                                <td class="text-left">{{ $map_data->file_name }}</td>
                                                @else
                                                <td class="text-left">{{ $docPart->doc_name }}</td>
                                                @endif
                                                @if ($map_data->pdf_upload_id)
                                                <td class="text-center"><a class="btn btn-success btn-sm"
                                                        href="{{ route('doc.down', $map_data->pdf_upload_id) }}"><i
                                                            class="fa fa-download"></i> View</a>
                                                </td>
                                                @else
                                                <td class="text-center"></td>
                                                @endif

                                                @if ($map_data->excel_upload_id)
                                                <td class="text-center"><a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', $map_data->excel_upload_id) }}"><i
                                                        class="fa fa-download"></i> View</a>
                                                </td>
                                                @else
                                                <td class="text-center"></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row m-2">
                            @if(Auth::user()->hasRole('Admin'))
                            <div class="col-md-2 offset-md-5">
                                <a href="{{ route('admin.claim.claimdashboard') }}"
                                    class="btn btn-warning btn-sm btn-block"><i class="fa fa-backward"></i> Back</a>
                            </div>
                            @elseif(Auth::user()->hasRole('ActiveUser'))
                            <div class="col-md-2 offset-md-5">
                                <a href="{{ route('claims.index', '1') }}"
                                    class="btn btn-warning btn-sm btn-block"><i class="fa fa-backward"></i> Back</a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
