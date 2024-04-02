<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DvaDetails extends Model
{
    protected $fillable = [
        'id',
        'app_id',
        'sal_exp',
        'oth_exp',
        'non_orig',
        'tot_cost',
        'non_orig_raw',
        'non_orig_srv',
        'tot_a',
        'sales_rev',
        'dva',
        'man_dir',
        'man_desig'
    ];

    public function application()
    {
        return $this->belongsTo('App\ApplicationMast', 'app_id');
    }
}
