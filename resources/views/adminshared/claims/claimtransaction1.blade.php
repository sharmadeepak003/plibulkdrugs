 <div class="modal fade" id="viewtransict{{ $data->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content" style="margin-left: -96px;width: 150% !important;/* padding-left: 159px; */">
             <div class="modal-header d-flex justify-content-center align-items-center">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Edit Transaction</strong></h5>
             </div>

             <div class="modal-body">
                 <table class="table table-bordered" id="beneficiaries-table">
                     <thead>
                         <tr>
                             <th>Name of Beneficiary</th>
                             <th>Financial Year</th>
                             {{-- <th>Product Name</th> --}}
                             <th>Amount (in Cr.)</th>
                             <th>Disbursement Date</th>
                             <th>Claim Submission Date by Beneficiary</th>
                             <th>Percentage</th>
                             <th>Remark</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($getData->where('admin_claim_inc_id', $data->id) as $data)
                             <tr data-id="{{ $data->id }}">
                                 <td style="width=50%">{{ $data->company_name }}</td>
                                 <td>{{ $data->claim_fy }}</td>
                                 {{-- <td>{{ $getProductName }}</td> --}}
                                 <td>
                                    <input type="number" class="form-control" 
                                         name="id" value="{{$data->id}}">
                                 </td>
                                 <td>
                                     <input type="number" class="form-control" 
                                         name="twentyperamount" value="{{$data->amount}}">
                                 </td>
                                 <td>
                                     <input type="date" class="form-control" 
                                         name="twentyperdisbursementdate" value="{{$data->disbursement_date}}">
                                 </td>
                                 <td>
                                     <input type="date" class="form-control" 
                                         name="date_of_submission_by_bene" value="{{$data->beneficiary_submission_date}}">
                                 </td>
                                 <td>
                                     <input type="number" class="form-control" name="percentage" value="{{$data->percentage}}">
                                 </td>
                                 <td>
                                     <textarea class="form-control"  name="remark" placeholder="Remarks ...">{{$data->remark}}</textarea>
                                 </td>
                                 <td><a class="btn btn-sm btn-success save-btn" data-id="{{$data->id}}">Update</a></td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
     
 </div>



 <!-- Add more entries as needed -->

 

 