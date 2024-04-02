<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminClaimIncentive extends Model
{
    protected $table = 'admin_claim_incentive';
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
	'created_by'
    ];
}
