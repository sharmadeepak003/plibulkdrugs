@extends('layouts.admin.master')

@section('title')
    Claim Correspondence Edit
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        .align_right tr td:not(:first-child) input {
            text-align: right !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.claims.updateCorres',encrypt($claim_id))}}" method="POST" id="form-create" role="form" class='form-horizontal' files=true
                enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                @method('PATCH')
                <div class="card border-primary p-0 m-10">
                    <div class="card-header bg-primary text-white">
                        <b>Claim Correspondence Edit </b>
                    </div>
                    @php
                        $i = 1;
                    @endphp
                    <div class="card-body">
                        <div class="offset-10 col-2">
                            <button type="button" id="addCorres"  class="btn btn-success ml-40">
                                Add <i class="fa fa-plus"></i>
                              </button>
                        </div>
                        @foreach($claim_corres as $val)
                        <div class="row">
                            
                            <input type="hidden" name="app_id" value="{{$val->app_id}}">
                            <input type="hidden" name="user_id" value="{{$val->user_id}}">
                            <input type="hidden" name="corres[{{$loop->iteration}}][doc_id]" value="{{$val->doc_id}}">
                            <input type="hidden" name="corres[{{$loop->iteration}}][id]" value="{{$val->id}}">
                            <div class="col-4">
                                <label >{{$loop->iteration}}. Query Raise Date</label>
                                <input type="date" class="form-control" value="{{$val->raise_date}}" name="corres[{{$loop->iteration}}][raise_date]">
                            </div>
                            <div class="col-4">
                                <label >Query Response Date</label>
                                <input type="date" class="form-control" value="{{$val->response_date}}" name="corres[{{$loop->iteration}}][response_date]">
                            </div>
                            <div class="col-4">
                                <label >Document</label>
                                @if($val->doc_id != null)
                                <a class="btn btn-success btn-sm" href="{{ route('doc.download', $val->doc_id) }}">View</a>
                                @endif
                                <input type="file" class="form-control" name="corres[{{$loop->iteration}}][image]">
                            </div>
                            <div class="col-12">
                                <label>Message</label>
                               
                                <textarea  class="form-control summernote" placeholder="Message" name="corres[{{$loop->iteration}}][message]">{!! $val->message !!}</textarea>
                            </div>
                        </div>
                        @endforeach
                        <div id="morecon"></div>

                    </div>
                    @php
                    $i++;
                @endphp
                 </div>

                 <div class="row pt-4">
                    <div class="col-md-2 offset-md-5">
                        <button type="submit" id="api_button"
                            class="btn btn-primary btn-sm form-control btn-block form-control-sm"><i class="fas fa-save"></i>
                            Update</button>
                            {{-- <a href=""  class="btn btn-primary btn-sm form-control btn-block form-control-sm">Proceed</a> --}}
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js></script>

    <script>
        $(document).ready(function() {
               var i = {{$claim_corres->count()}}
               
               
               $('#addCorres').on('click', function() {
              
               
              
                    i++;
                    $('#morecon').append('<div class="row" id="row'+i+'"><div class="col-4"><label >'+i+'. Query Raise Date</label><input type="date" class="form-control" name="corres['+ i +'][raise_date]"></div><div class="col-4"><label >Query Response Date</label><input type="date" class="form-control" name="corres['+ i +'][response_date]"></div><div class="col-4"><label >Document</label><input type="file" class="form-control" name="corres['+ i +'][image]"></div><div class="col-12"><label>Message</label><textarea id="" class="summernote form-control" placeholder="Message" name="corres['+ i +'][message]"></textarea></div><div class="offset-10 col-2"><button class="btn btn-danger btn_remove" type="button" id="'+i+'">Remove</button></div></div>');
                    $('.summernote').summernote();
                });
            });
            $(document).on('click', '.btn_remove', function() {
                var r_id = $(this).attr("id");
                $('#row' + r_id + '').remove();
            });
            $(function () {
    // Summernote
    $('.summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
    </script>
@endpush
