<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminClaimIncentivTwentyPer extends Model
{
    protected $table = 'tbl_twenty_per_claim_incentive';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'user_id',
        'amount',
        'disbursement_date',
        'beneficiary_submission_date',
        'percentage',
        'remark',
        'admin_claim_inc_id'
    ];
}
