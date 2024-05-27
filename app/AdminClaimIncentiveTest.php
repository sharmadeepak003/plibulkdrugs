<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminClaimIncentiveTest extends Model
{
    protected $table = 'admin_claim_incentive_test';
    protected $fillable = [
        'id',
        'user_id',
        'app_id',
        'claim_id',
        'claim_status',
        'claim_fy',
        'scheme_name',
        'company_name',
        'claim_duration',
        'incentive_amount',
        'claim_filing',
        'expsubdate_reportinfo',
        'expsubdate_reportmeitytopma',
        'daysbetween_submandreport',
        'daysbetween_dataandreport',
        'status',
        'appr_date',
        'appr_amount',
        'remarks',
        'system_remarks',
	    'created_by',
        'claim_fill_period',
        'claim_incentive_type'
    ];
}
