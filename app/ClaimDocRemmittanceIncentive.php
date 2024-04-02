<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimDocRemmittanceIncentive extends Model
{
    protected $table = 'claim_doc_remmittance_incentive';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'bank_name',
        'account_holder_name',
        'acc_type',
        'branch_name',
        'acc_no',
        'ifsc_code',
        'doc_id',
        'section',
        'prt_id',
        'upload_id'
    ];
}
