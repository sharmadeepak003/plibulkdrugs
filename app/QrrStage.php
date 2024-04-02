<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrStage extends Model
{
    protected $table = 'qrr_stage';

    protected $fillable = [
        'id',
        'qrr_id',
        'stage',
        'status'
    ];

    public function qrrapplication()
    {
        return $this->belongsTo('App\QrrMasters', 'qrr_id');
    }
}
