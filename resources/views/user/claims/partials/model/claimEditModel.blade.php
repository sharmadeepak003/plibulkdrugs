<style>
    .modal-lg{
        max-width:180%  !important;
        overflow: inherit !important;;
    }
</style>
    <div class="modal fade" id="editModal{{ $cm_val->claim_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <a data-dismiss="modal" class="float-right"><em class="fas fa-window-close"></em></a>
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title text-danger">Claim Sections Overview </h5>
                </div>
                
               <div class="modal-body">
                    <div class="flex-parent">
                        <div class="input-flex-container">
                            {{-- <a class="input" href="{{ route('claims.claimsapplicantdetail', ['claim_id' => $cm_val->claim_id, 'fy_id' => $id]) }}"> --}}
                                <a class="input" href="{{route('claims.claimsapplicantdetail',['id'=>$cm_val->claim_id])}}">

                                <span data-info="Application Detail">Application Detail </span>
                                
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','1')->first()->stages))
                                @if(in_array('1', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','1')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Application Detail"></span>
                                @endif
                                @endif
                            </a>
                          
                            <a class="input" href="{{route('claimsalesdetail.create',['id'=>$cm_val->claim_id])}}">
                                <span data-info="Sales Details">Sales Details</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','2')->first()->stages))
                                @if(in_array('2', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','2')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Sales Details"></span>
                                @endif
                                @endif
                            </a>
                            
                            <a class="input" href="{{route('claimsalesdetail.claimsalesdva',['id'=>$cm_val->claim_id])}}">
                                <span data-info="DVA">DVA</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','3')->first()->stages))
                                @if(in_array('3', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','3')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="DVA"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('claiminvestmentdetail.create',['id'=>$cm_val->claim_id])}}">
                                <span data-info="Investment Summary">Investment Summary</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','4')->first()->stages))
                                @if(in_array('4', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','4')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Investment Summary"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('claimprojectdetail.create',['id'=>$cm_val->claim_id])}}">
                                <span data-info="Project Details">Project Details</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','5')->first()->stages))
                                @if(in_array('5', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','5')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Project Details"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('relatedpartytransaction.create',['id'=>$cm_val->claim_id])}}">
                                <span data-info="Related Party">Related Party</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','6')->first()->stages))
                                @if(in_array('6', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','6')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Related Party"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('claimdocumentupload.create',['A','id'=>$cm_val->claim_id])}}">
                                <span data-info="Documents Upload A">Documents Upload A</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','7')->first()->stages))
                                @if(in_array('7', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','7')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Documents Upload A"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('claimdocumentupload.create',['B','id'=>$cm_val->claim_id])}}">
                                <span data-info="Documents Upload B">Documents Upload B</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','8')->first()->stages))
                                @if(in_array('8', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','8')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Documents Upload B"></span>
                                @endif
                                @endif
                            </a>
                            <a class="input" href="{{route('claimdocumentupload.create',['C','id'=>$cm_val->claim_id])}}">
                                <span data-info="Miscellaneous">Miscellaneous</span>
                                @if(isset($claimStage->where('claim_id',$cm_val->claim_id)->where('stages','9')->first()->stages))
                                @if(in_array('9', $claimStage->where('claim_id',$cm_val->claim_id)->where('stages','9')->pluck('stages')->toArray()))
                                    <span data-year="Edit" data-info="Miscellaneous"></span>
                                @endif
                                @endif
                            </a>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
