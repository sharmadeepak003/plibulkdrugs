<style>
    .modal-lg{
        max-width:180%  !important;
    }
    </style>
    <div class="modal fade" id="editModal{{ $app->qrr_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        data-backdrop="static" aria-hidden="true">
        
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    
            <div class="modal-content">
            <a data-dismiss="modal" class="float-right"><i class="fas fa-window-close"></i></a>
    
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title text-danger">Application Sections Overview</h5>
                </div>
                
                <div class="modal-body">
                    <div class="flex-parent">
                        <div class="input-flex-container">                            
                            @foreach ($qrrMast[$app->qrr_id] as $value) 
                            <a class="input" href="{{ route('qpr.edit',$app->qrr_id) }}">
                                @if(in_array(1,$value->qrrstages->where('qrr_id',$value->id)->pluck('stage')->toArray()))
                                <span data-year="Edit" data-info="QRR Details"></span>
                                @else
                                <span data-info="QRR Details">Application Sections Overview</span>
                                @endif
                            </a>
                            <a class="input" href="{{ route('revenue.edit',$app->qrr_id) }}">
                                @if(in_array(2,$value->qrrstages->where('qrr_id',$value->id)->pluck('stage')->toArray()))
                                <span data-year="Edit" data-info="Revenue"></span>
                                @else
                                <span data-info="Revenue"></span>
                                @endif
                            </a>
                            <a class="input" href="{{ route('projectprogress.edit',$app->qrr_id) }}">
                                @if(in_array(3,$value->qrrstages->where('qrr_id',$value->id)->pluck('stage')->toArray()))
                                <span data-year="Edit" data-info="Project Progress"></span>
                                @else
                                <span data-info="Project Progress"></span>
                                @endif
                            </a>
                            <a class="input" href="{{ route('uploads.edit',$app->qrr_id) }}">
                                @if(in_array(4,$value->qrrstages->where('qrr_id',$value->id)->pluck('stage')->toArray()))
                                <span data-year="Edit" data-info="Uploads"></span>
                                @else
                                <span data-info="Uploads"></span>
                                @endif
                            </a>
                            {{-- <a class="input" href="{{ route('app.preview',$app->id) }}">
                                <span data-info="Preview"></span>
                            </a> --}}

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    