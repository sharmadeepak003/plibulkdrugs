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
                    <form action="{{ route('claimdocumentupload.update', 'R') }}" id="application-create" role="form"
                        method="post" class='form-horizontal prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="claim_id" value="{{ $claim_id }}">
                        <table id="example" class="table table-sm table-striped table-bordered table-hover">
                            <thead>
                                <tr class="table-primary"class="table-primary">
                                    <th class="text-center">Sr. No</th>
                                    <th class="text-center">Document Name</th>
                                    <th class="text-center">PDF</th>
                                    <th class="text-center">PDF View</th>
                                    <th class="text-center">Excel</th>
                                    <th class="text-center">Excel View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doc_particular as $key => $docPart)
                                    @foreach ($doc_map as $key => $map_data)
                                        @if ($docPart->id == $map_data->prt_id)
                                            <tr>
                                                <td class="text-center">{{ $docPart->serial_number }}
                                                    <input type="hidden" name="data[{{ $key }}][prt_id]"
                                                        value="{{ $docPart->id }}">
                                                    <input type="hidden" name="data[{{ $key }}][id]"
                                                        value="{{ $map_data->id }}">
                                                    <input type="hidden" name="data[{{ $key }}][pdf_upload_id]"
                                                        value="{{ $map_data->pdf_upload_id }}">
                                                    <input type="hidden" name="data[{{ $key }}][excel_upload_id]"
                                                        value="{{ $map_data->excel_upload_id }}">
                                                </td>
                                                {{-- <td class="text-left">{{ $docPart->doc_name }}</td> --}}
                                                @if($docPart->subsetof_particular != 99)
                                                <td class="text-left">{{ $docPart->doc_name }}</td>
                                            @else
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="data[{{$key}}][mis]" placeholder="Enter Miscellaneous {{$key-9}}" value="{{$map_data->file_name}}">
                                            </td>
                                            @endif
                                                <td class="text-center">
                                                    <input type="file" name="data[{{ $key }}][pdf]"
                                                        id="" class="form-control form-control-sm">
                                                </td>
                                                @if ($map_data->pdf_upload_id)
                                                <td class="text-center"><a class="btn btn-success btn-sm"
                                                        href="{{ route('doc.down', $map_data->pdf_upload_id) }}"><i
                                                            class="fa fa-download"></i> View</a>
                                                </td>
                                                @else
                                                <td class="text-center"></td>
                                                @endif
                                                <td class="text-center">
                                                    <input type="file" name="data[{{ $key }}][excel]"
                                                        id="" class="form-control form-control-sm">
                                                </td>
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
                        <div class="row pb-2">
                            <div class="col-md-2 offset-md-1">
                                
                                    <a href="{{ route('claims.index', 1) }}"
                                    class="btn btn-warning btn-sm btn-block"><i class="fa fa-backward"></i> Back</a>
                            </div>
                            <div class="col-md-2 offset-md-2">
                                <button type="submit"
                                    class="btn btn-primary btn-sm form-control form-control-sm submitshareper"
                                    id="pre_event">
                                    <em class="fas fa-save"></em> Update
                                </button>
                            </div>
                            @php
                            if($period == 4){

                                // only for annual claim filling users
                                $date = Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2023-12-31 23:59:00'));
                            }
                            else{
                                // for quaterly, half yearly and 9 month claim filling users
                                $date = Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2024-01-31 23:59:00'));

                            }    
                            @endphp  
                             @if ($date)
                             <a href="{{ route('claimdocumentupload.status', $claim_id) }}"
                                 class="btn btn-success btn-sm btn-block" style="width: 20%;margin-left:10%;" id="submit">
                                 <i class="fa fa-check"></i> Submit
                             </a>
                         @else
                             <button type="button" class="btn btn-danger btn-sm btn-block" disabled>
                                 !! The 20% Incentive form has been closed. !!
                             </button>
                         @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimIncentiveDocumentEdit', '#application-create') !!}
    <script>
        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("pre_event");
                btn.disabled = true;
                setTimeout(function() {
                    btn.disabled = false;
                }, (1000 * 20));
            });

            $('#submit').click(function(event) {
            event.preventDefault(); // Prevents the default form submission

            var link = $(this).attr('href');
            swal({
                title: "Are you sure you want to submit the Claim Incentive document form?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            }).then((value) => {
                if (value) {
                    window.location.href = link;
                }
            });
        });
        });
    </script>
@endpush
