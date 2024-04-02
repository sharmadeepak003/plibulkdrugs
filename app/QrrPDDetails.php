<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrPDDetails extends Model
{
    protected $table = 'qrr_pd_details';
    protected $fillable = [
        'id',
        'qtr_id',
        'annual_capacity',
        'created_at',
        'updated_at',
        'created_by'
    ];
}
