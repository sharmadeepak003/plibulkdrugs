<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'comp_const',
        'bus_profile',
        'doi',
        'website',
        'listed',
        'stock_exchange',
        'corp_add',
        'corp_state',
        'corp_city',
        'corp_pin',
        'bankruptcy',
        'rbi_default',
        'wilful_default',
        'sebi_barred',
        'cibil_score',
        'case_pend',
        'created_by',
        'externalcreditrating'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
