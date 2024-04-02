<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimDvaOther extends Model
{
    protected $table = 'claim_dva_other';
    protected $fillable = [
            'app_id',
            'claim_id',
            'created_by',
            'prt_id',
            'quantity',
            'amount',
            'goods_amt',
            'created_at',
            'update_at',
    ];

    public function application()
    {
        return $this->belongsTo('App\ClaimMaster', 'claim_id');
    }
}
