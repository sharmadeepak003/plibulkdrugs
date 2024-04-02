<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimApplicantDetails extends Model
{
    protected $table = 'claim_applicant_details';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'hsn',
        'committed_capacity',
        'quoted_sales',
        'incentive_from_date',
        'incentive_to_date',
        'claim_fill_period',
        'created_at',
        'updated_at'
    ];
}
