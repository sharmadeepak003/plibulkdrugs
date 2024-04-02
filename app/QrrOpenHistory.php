<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrOpenHistory extends Model
{
    protected $table = 'qrr_open_history';
    protected $fillable = [
        'id',
        'qrr_id',
        'qtr_id',
        'app_id',
        'updated_by',
        'satatus',
        'created_at',
        'updated_at',
    ];
}
