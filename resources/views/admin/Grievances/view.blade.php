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
                            <td class="col-md-3"><b>Submit Date :</b></td>
                            <td class="col-md-3" >{{ date('d-m-Y', strtotime($g_det->created_at)) }}</td>
                            <td class="col-md-3"><b>Closing Date :</b></td>
                            <td class="col-md-3" >{{ date('d-m-Y', strtotime($g_det->closing_date)) }}</td>
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

                        <tr>
                            <td class="col-md-3"> <b>Closing Remark :</b></td>
                            <td colspan="3" class="col-md-9">{{strip_tags($g_det->closing_remark)}}</td>
                        </tr>

                        


                    </tbody>
                </table>
                
                <!---------------------------->
              

            </div>
            
        </div>
        <a href="{{ route('admin.grievances_list') }}"
                                    class="btn btn-sm btn-warning" style="float:left;"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Back</a>

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