<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimStatutoryAuditor extends Model
{
    protected $table = 'claim_statutory_auditors';
    protected $fillable = [
        'id',
        'app_id',
        'created_by',
        'claim_id',
        'firm_name',
        'date_of_appointment',
        'appointment_valid_up',
        'date_of_certificate',
        'udin',
        'partner_name',
        'mobile_signing_partner',
        'created_at',
        'certificate_detail',
        'updated_at'
    ];
}
