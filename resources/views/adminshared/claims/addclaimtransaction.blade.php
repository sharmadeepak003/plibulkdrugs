<div class="modal fade " id="addtransict{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: 120% !important;">
            <div class="modal-header d-flex justify-content-center align-items-center bg-primary">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Add Transaction</strong></h5>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <input type="hidden" name="claim_id" value="{{ $data->claim_id }}">
                    <input type="hidden" name="app_id" value="{{ $data->app_id }}">
                    <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                    <div class="col-4">
                        <label>Name of Beneficiary</label>
                        <input type="text" class="form-control" value="{{ $data->company_name }}" readonly>
                    </div>
                    <div class="col-4">
                        <label>Financial Year</label>
                        <input type="text" class="form-control" value="{{ $data->claim_fy }}" readonly>
                    </div>
                    <div class="col-4">
                        <label>Product Name</label>
                        <input type="text" class="form-control" value="{{ $data->product_name }}" readonly>
                    </div>
                    <div class="col-4">
                        <label>Amount (in Cr.)</label>
                        <input type="number" class="form-control" name="twentyperamount">
                        <span class="d-none text-danger twentyperamount" ></span>
                    </div>
                    <div class="col-4">
                        <label>Claim Submission Date by Beneficiary</label>
                        <input type="date" class="form-control" name="date_of_submission_by_bene">
                        <span class="d-none text-danger date_of_submission_by_bene" ></span>
                    </div>

                    <div class="col-4">
                        <label>Disbursement Date</label>
                        <input type="date" class="form-control" name="twentyperdisbursementdate">
                        <span class="d-none text-danger twentyperdisbursementdate" ></span>
                    </div>
                    
                    <div class="col-4">
                        <label>Percentage</label>
                        <input type="number" class="form-control" name="percentage">
                        <span class="d-none text-danger percentage" ></span>
                    </div>
                    <div class="col-4">
                        <label>Remarks</label>
                        <textarea class="form-control" placeholder="Remarks ..." name="remark"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Close</button>
                <button type="button" name="btnAdd{{ $data->id }}" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
