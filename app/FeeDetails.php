<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'payment',
        'date',
        'urn',
        'bank_name',
        'amount'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
