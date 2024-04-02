<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QRRMasters extends Model
{
    protected $table = 'qrr_master';
    protected $fillable = [
        'id',
        'status',
        'app_id',
        'qtr_id','revision_dt'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    } 
    public function qrrstages()
    {
        return $this->hasMany('App\QrrStage', 'qrr_id');
    }
}
