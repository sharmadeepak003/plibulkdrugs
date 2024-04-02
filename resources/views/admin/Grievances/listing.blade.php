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
                <b>Listing</b>
            </div>
            <div class="card-body">
                <!-- ---------------------- -->
                
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered dataTable">
                        <thead class="userstable-head">
                            <tr class="table-info">
                                <th class="text-center" style="width: 5%">Sr No</th>
                                <th class="text-center" style="width: 25%">Applicant Name</th>
                                <th class="text-center" style="width: 20%">Grievance by</th>
                                <th class="text-center" style="width: 10%">Designation.</th>
                                <th class="text-center" style="width: 10%">Email</th>
                                <th class="text-center" style="width: 10%">Mobile</th>
                              
                                <th class="text-center" style="width: 10%">Submit Date
                                <br>
                               </th>
                               <th class="text-center" style="width: 15%">Closing Date
                                <br>
                               </th>
                                <th class="text-center" style="width: 5%">Action/Status</th>
                            </tr>
                        </thead>
                        <tbody class="userstable-body">
                        @foreach ($g_det as $g_val)
                          <tr>
                            <td>{{$loop->index + 1 }}</td>
                            <td>{{$g_val->app_name}}</td>
                            <td>{{$g_val->name}}</td>
                            <td>{{$g_val->designation}}</td>
                            <td>{{$g_val->email}}</td>
                            <td>{{$g_val->mobile}}</td>
                            <!-- <td>{{$g_val->compliant_det}}</td> -->
                            <td>{{ date('d-m-Y', strtotime($g_val->created_at)) }}</td>
                            <td >
                            @if (isset($g_val->closing_date))
                            {{ date('d-m-Y', strtotime($g_val->closing_date)) }}
                           @else
                             --/--/----
                           @endif
                            </td>
                            <td>
                           @if ($g_val->status == 0)
                           <a href="{{ route('admin.grievances_respond',$g_val->id) }}" class="nav-link">
                              <button type="button" class="btn btn-warning btn-sm">Respond</button>
                            </a>
                           @else

                           <a href="{{ route('admin.grievances_respond_view',$g_val->id) }}" class="nav-link">
                              <button type="button" class="btn btn-info btn-sm">View</button>
                            </a>

            
                           

                 
                           @endif
                           
                        
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- --------------------------------->
            </div>
        </div>


        </form>
    </div>
</div>



<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>



          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input id='gid' type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection



