<style>
    .modal-lg{
        max-width:180%  !important;
        overflow: inherit !important;;
    }
</style>
<div class="modal fade" id="editModal{{ $val->app_id.'a_a'.$val->product_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-0 offset-md-3">
                            <span  style="color:#DC3545;font-size:17px"> <b> Company Name : </b> </span>
                        </div>
                        <div class="col-md-0" style="font-size:17px">{{$val->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-0 offset-md-3">
                            <span  style="color:#DC3545;font-size:17px"> <b> Target Segment : </b> </span>
                        </div>
                        <div class="col-md-0" style="font-size:17px">  TS - {{ $val->target_segment }} </div>
                    </div>
                    <div class="row">
                        <div class="col-md-0 offset-md-3">
                            <span  style="color:#DC3545;font-size:17px"> <b>Product Name: </b> </span>
                        </div>
                        <div class="col-md-0" style="font-size:17px">{{$val->product}}</div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-0 offset-md-3">
                            <span  style="color:#DC3545;font-size:17px"> <b>websitelink: </b> </span>
                        </div>
                        <div class="col-md-0" style="font-size:17px">{{$val->websitelink}}</div>
                    </div> --}}
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
                                    <tr class="table-primary">
                                        <th class="text-center">Sr No</th>
                                        {{-- <th class="text-center">websitelink</th> --}}
                                      
                                        <th class="text-center">Brochure</th>
                                        <th class="w-5 text-center">Techno Commercial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($arr_brochure_product[$val->app_id.'@_@'.$val->product_id]))
                                        @foreach ($arr_brochure_product[$val->app_id.'@_@'.$val->product_id] as $vkey => $b_val)
                                            <tr>
                                                <td class="text-center">{{ $vkey + 1 }}</td>
                                                {{-- <td class="text-center">{{$b_val->websitelink}}</td>   --}}
                                                
                                                <td class="text-center">
                                                    @if(isset($b_val->id))
                                                        <a href="{{ route('brochure_download_doc', encrypt($b_val->id)) }}" 
                                                            class="btn btn-success btn-sm float-centre">
                                                            Download</a>
                                                    @endif    
                                                </td>
                                                <td class="text-center"> 
                                                    @if(isset($b_val->other_file_name))
                                                        <a href="{{ route('other_brochure_dow_doc', encrypt($b_val->broch_doc_id)) }}" 
                                                        class="btn btn-success btn-sm float-centre">
                                                        Download</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
