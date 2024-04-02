@extends('layouts.admin.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/apps.css') }}">
@endpush

@section('title')
Application Remarking -- Dashboard
@endsection

@section('content')

<div class="container  py-4 px-2 col-lg-12">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('admin.appstatus.update', $appMast->id) }}" id="form-create" role="form" method="post"
            class='form-horizontal' files=true enctype='multipart/form-data' accept-charset="utf-8">
                @csrf
                @method('patch')
                <input type="hidden" name="app_id" value="{{$appMast->id}}">
                <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Applicant Details</b>
                        </div>
                        <div class="card-body py-0 px-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row p-1 m-1 p-2">
                                            <div class="col-md-6 py-2">
                                                <label for="name">Applicant Name</label>
                                                    <input type="text" name="name" id="name" value="{{ $appMast->name }}" class="form-control form-control-sm" disabled>
                                            </div>
                                            <div class="col-md-6 py-2">
                                                <label for="app_num">Application No.</label>
                                                                <input type="text" name="app_num" id="app_num" value="{{  $appMast->app_no }}" class="form-control form-control-sm" disabled>
                                            </div>
                                            <div class="col-md-4 py-2">
                                                <label for="app_target_segment">Target Segment</label>
                                                                <input type="text" name="app_target_segment" id="app_target_segment" value="{{ $appMast->target_segment }}" class="form-control form-control-sm" disabled>
                                            </div>
                                            <div class="col-md-2 py-2">
                                                <label for="app_product">Product Name</label>
                                                                <input type="text" name="app_product" id="app_product" value="{{  $appMast->product }}" class="form-control form-control-sm" disabled>
                                            </div>

                                            <div class="col-md-3 py-2 ">
                                                <label for="flage_id">Select Status</label>
                                                <select name="flage_id" id="flage_id" class="form-control form-control-sm">
                                                    <option value="" selected disabled>{{$appMast->flag_name}}</option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Withdrawn</option>
                                                    <option value="3">Ineligible</option>
                                                    <option value="4">Waitlist</option>
                                                    <option value="5">Lower in Ranking</option>
                                                </select>
                                            </div>
                                            {{--by shakiv ali--}}
                                           
                                            <div class="col-md-2 py-2 flag_approved">
                                                <div class="status_sec">
                                                    @if (!empty($appMast->approval_dt))
                                                        <label for="approval_dt">Approval Date</label><div><input type="date" name="approval_dt" id="approval_dt" value="{{date('Y-m-d', strtotime($appMast->approval_dt))}}" class="form-control form-control-sm approved_date" style="width:110px;"></div>
                                                    @elseif(!empty($appMast->remarks)) 
                                                        <label for="withdrawn">Reason of withdrawn</label><div><input type="input" name="withdrawn" id="remarks" value="{{$appMast->remarks}}" class="form-control form-control-sm"  style="width:110px;"></div>
                                                    @endif
                                                </div>
                                            </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 offset-md-5">
                           <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" ><i class="fas fa-save"></i> Update</button>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('admin.appstatus.index') }}"
                            class="btn btn-success btn-sm form-control form-control-sm">
                            <i class="fas fa-backword right fas fa-home"></i> Back</a>
                        </div>
                    </div>
             </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\admin\ApplicationStatusRequest', '#form-create') !!}
   <!-- by shakiv ali -->
   <script type="text/javascript">
    $(document).ready(function() {
        var date_app = <?php echo json_encode($appMast->approval_dt) ?>;       
        $('#flage_id').on('change',function(){
            var flag_input_field = this.value;
            $('div').remove('.status_sec');
            if(flag_input_field == 1){
                $('div').remove('.withdrawn');
                var data = '<div class="app_date"><label for="approval_dt">Approved Date</label><div><input type="date" name="approval_dt" id="approval_dt" value="" class="form-control form-control-sm" style="width:110px;"></div></div>'; 
                $(".flag_approved").append(data);
            }
            else if(flag_input_field == 2){
                $('div').remove('.app_date');
                var data = '<div class="withdrawn"><label for="withdrawn">Reason withdrawn</label><div><input type="input" name="remarks" id="remarks" value="" class="form-control form-control-sm" style="width:110px;"></div></div>';
                $(".flag_approved").append(data);
            }else{
                $('div').remove('.withdrawn');
                $('div').remove('.app_date');
            }
        })
    });
</script>
@endpush