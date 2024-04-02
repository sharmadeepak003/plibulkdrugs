@extends('layouts.user.dashboard-master')

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
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-body">
                    <form action="{{ route('claimdocumentupload.store','R') }}" id="application-create" role="form" method="POST"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                        {{-- <input type="hidden" name="app_id" value="{{$apps->app_id}}"> --}}
                        <input type="hidden" name="claim_id" value="{{$claimId}}">
                        <!-- the result to be displayed apply here -->
                        <table id="example" class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                                <tr class="table-primary"class="table-primary">
                                    <th class="text-center">Sr. No</th>
                                    <th class="text-center">Document Name</th>
                                    <th class="text-center">PDF</th>
                                    <th class="text-center">Excel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doc_particular as $key => $docPart)
                                    <tr>
                                        <td class="text-center">{{ $docPart->serial_number }}
                                            <input type="hidden" name="data[{{ $key }}][prt_id]" value="{{$docPart->id}}" ></td>
                                            @if($docPart->subsetof_particular != 99)
                                                <td class="text-left">{{ $docPart->doc_name }}</td>
                                            @else
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="data[{{$key}}][mis]" placeholder="Enter Miscellaneous {{$key-10}}">
                                            </td>
                                            @endif
                                        <td class="text-center">
                                            <input type="file" name="data[{{ $key }}][pdf]" id=""
                                                class="form-control form-control-sm">
                                        </td>
                                        <td class="text-center">
                                            <input type="file" name="data[{{ $key }}][excel]" id=""
                                                class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row pb-2">
                            <div class="col-md-2">
                                <a href="{{ route('claims.index', $forRetuenBackId) }}"
                                    class="btn btn-warning btn-sm btn-block"><i class="fa fa-backward"></i> Back</a>
                            </div>
                            <div class="col-md-2 offset-md-3">
                                <button type="submit"
                                    class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                                    id="pre_event">
                                    <em class="fas fa-save"></em> Save as Draft
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimIncentiveDocument', '#application-create') !!}
<script>
     $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("pre_event");
                btn.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 20));
            });
        });
</script>
@endpush
