<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimDvaKeyMaterial extends Model
{
    protected $table = 'claim_dva_key_material';
    protected $fillable = [
            'app_id',
            'claim_id',
            'created_by',
            'raw_material',
            'country_origin',
            'supplier_name',
            'goods_amt',
            'quantity',
            'amount' ,
            'created_at',
            'update_at',
    ];

    public function application()
    {
        return $this->belongsTo('App\ClaimMaster', 'claim_id');
    }
}
