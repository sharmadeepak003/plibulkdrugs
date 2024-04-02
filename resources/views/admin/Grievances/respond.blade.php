@extends('layouts.admin.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
Grievances
@endsection

@section('content')
<div class="row p-1">
    <div class="col-md-12">


        <div class="card border-primary">
            <div class="card-header bg-gradient-info">
                <b>Complaint Details ({{$g_det->app_name}}) </b>
            </div>
            <div class="card-body">
                <!---------------------------->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                </ul>
                </div>
            @endif

                <table class="table table-sm table-bordered table-hover ">
                    <tbody>


                        <tr>
                            <td class="col-md-3"><b>Name :</b></td>
                            <td class="col-md-3">{{$g_det->name}}</td>
                            <td class="col-md-3"><b>Designation :</b></td>
                            <td class="col-md-3">{{$g_det->designation}}</td>
                        </tr>

                        <tr>
                            <td class="col-md-3"><b>Email :</b></td>
                            <td class="col-md-3">{{$g_det->email}}</td>
                            <td class="col-md-3"><b>Mobile :</b></td>
                            <td class="col-md-3">{{$g_det->mobile}}</td>
                        </tr>

                        <tr>
                            <td class="col-md-3"><b>Created At :</b></td>
                            <td class="col-md-3" colspan="3">{{ date('d-m-Y', strtotime($g_det->created_at)) }}</td>

                        </tr>

                        <tr>
                            <td class="col-md-3"> <b>Complaint Details :</b></td>
                            <td colspan="3" class="col-md-9">{{$g_det->compliant_det}}</td>
                        </tr>

                        <tr>
                            <td class="col-md-3"> <b>Documents :</b></td>
                            <td colspan="3" class="col-md-9">
                                @foreach( json_decode($g_det->complaint_doc) as $key => $id)
                                <a href="{{ route('admin.com_doc_down', $id) }}"  >
                                <button type="button " class="btn btn-sm btn-primary">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                                </a>
                                <br />
                                @endforeach
                                {{$g_det->file_name}}
                              
                            </td>
                        </tr>


                    </tbody>
                </table>

                <!---------------------------->
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.grievances_respond_store') }}" role="form" method="post" class='form-horizontal' 
                            enctype='multipart/form-data'  accept-charset="utf-8">
                            @csrf
                            <input type="hidden" id="qid" name="qid" value="{{$g_det->id}}">
                            <br>
                            <div class="col-md-3 offset-md-4 form-group ">
                                <label for="location" class="col-form-label col-form-label-sm"> Select Close Date:-
                                    <span class="text-danger">*</span></label>
                                <input type="date" name='close_date' class="form-control form-control-sm"
                                required
                                 min = "{{ date('Y-m-d', strtotime($g_det->created_at)) }}" max="<?php echo date("Y-m-d"); ?>" name="invoicedate">
                            </div>

                            <div class="form-group col-md-12 ">
                                <label>Remarks</label>
                                <textarea required id = "notee"class="form-control summernote" name='remarks' rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="col-md-2 offset-md-5">
                                <button type="submit" onclick="check(this.value)" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                    class="fas fa-save"></i>
                                    Close Query</button>
                                </div>
                                <a href="{{ route('admin.grievances_list') }}"
                                    class="btn btn-sm btn-warning" style="float:right;"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>
                                
                        </form>
                    </div>
                </div>

            </div>
        </div>


        </form>
    </div>
</div>




@endsection


@push('scripts')
<script>
    $(function () {
        $('.summernote').summernote()
    });

  function check()
  {
 
   
    if ($('#notee').summernote('isEmpty')) {

        $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Validation',
                subtitle: 'Remark',
                body: 'Remarks Field is Required',
                timer: 1000,
                showConfirmButton: false,
           })

    }

            

  }

   
</script>
@endpush