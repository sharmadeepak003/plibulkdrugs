<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedParty extends Model
{
    protected $table='claim_related_party';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'nature_name',
        'related_prt_id',
        'fy_statement',
        '3CEB',
        'ceb_amount',
        '3CD',
        'tot_fy_statement',
        'tot_ceb',
        'tot_cd',
        'cd_type',
        'created_at',
        'updated_at',
    ];
}
