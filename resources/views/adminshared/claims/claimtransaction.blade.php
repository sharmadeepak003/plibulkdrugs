 <div class="modal fade" id="viewtransict{{ $data->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content" style="margin-left: -96px;width: 150% !important;/* padding-left: 159px; */">
             <div class="modal-header d-flex justify-content-center align-items-center bg-primary">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Edit Transaction</strong></h5>
             </div>

             <div class="modal-body">
                 <table class="table table-bordered">
                     <thead>
                         <tr>
                             <th>Name of Beneficiary</th>
                             <th>Financial Year</th>
                             <th>Product Name</th>
                             <th>Amount (in Cr.)</th>
                             <th>Claim Submission Date by Beneficiary</th>
                             <th>Disbursement Date</th>
                             <th>Percentage</th>
                             <th>Remark</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>

                         @foreach ($getData->where('admin_claim_inc_id', $data->id) as $data)
                             <tr data-id="{{ $data->id }}">
                                 <input type="hidden" class="form-control" name="id" value="{{ $data->id }}">
                                 <td style="width=50%">{{ $data->company_name }}</td>
                                 <td>{{ $data->claim_fy }}</td>
                                 <td></td>

                                 <td>
                                     <input type="number" class="form-control"
                                         name="twentyperamount{{ $data->id }}" value="{{ $data->amount }}">
                                        <span class=" text-danger" id="twentyperamount{{ $data->id }}"></span>
                                 </td>
                                 <td>
                                    <input type="date" class="form-control"
                                        name="date_of_submission_by_bene{{ $data->id }}"
                                        value="{{ $data->beneficiary_submission_date }}">
                                        <span class=" text-danger" id="date_of_submission_by_bene{{ $data->id }}"></span>
                                </td>

                                 <td>
                                     <input type="date" class="form-control"
                                         name="twentyperdisbursementdate{{ $data->id }}"
                                         value="{{ $data->disbursement_date }}">
                                         <span class=" text-danger" id="twentyperdisbursementdate{{ $data->id }}"></span>
                                 </td>
                                 
                                 <td>
                                     <input type="number" class="form-control" name="percentage{{ $data->id }}"
                                         value="{{ $data->percentage }}">
                                         <span class=" text-danger" id="percentage{{ $data->id }}"></span>
                                 </td>
                                 <td>
                                     <textarea class="form-control" name="remark{{ $data->id }}" placeholder="Remarks ...">{{ $data->remark }}</textarea>
                                 </td>
                                 <td><button class="btn btn-sm btn-success save-btn" type="button"
                                         name="btnUpd{{ $data->id }}">Update</button></td>
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
