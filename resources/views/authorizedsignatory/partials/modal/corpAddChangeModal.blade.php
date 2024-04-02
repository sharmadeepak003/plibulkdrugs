<style>
    .modal-lg{
        max-width:180%  !important;
        overflow: inherit !important;;
    }
</style>
    <div class="modal fade" id="corpAddCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <div class="col-md-11">
                        <h5 class="modal-title text-danger text-center">Details</h5>
                        </div>
                        <div class="col-md-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="">
                            <div class="table-responsive pt-2">
                                <table  cellspacing="0" width="100%" class="table table-sm table-bordered table-hover" id="ProjectedDvaAb">
                                    <thead>
                                        {{-- <tr>
                                            <th colspan="6" width="100%" class="table-primary text-center bg-gradient-info">
                                                Applicants
                                            </th>
                                        </tr> --}}
                                        <tr class="table-primary">
                                            <th class="text-center" >Sr No</th>
                                            <th class="text-center" style="width: 30%">Target Segment</th>
                                            <th class="text-center" >Application No</th>
                                            <th class="text-center" >Round</th>
                                            <th class="text-center" >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registered_add as $key => $user)
                                            
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td>{{ $user->target_segment }}</td>
                                                        <td class="text-center">{{ $user->app_no }}</td>
                                                        <td class="text-center">{{$user->product}}</td>  
                                                        <td>
                                                        <a href="{{ route('admin.authoriseSignatory',['R',$user->app_id]) }}"
                                                                class="btn btn-success btn-sm btn-block">Edit</a>
                                                        </td>
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
