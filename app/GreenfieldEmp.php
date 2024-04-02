<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GreenfieldEmp extends Model
{
    protected $table = 'greenfield_emp';
    protected $fillable = [
        'id',
        'qrr_id',
        'laborPrevNo',
        'laborCurrNo',
        'empPrevNo',
        'empCurrNo',
        'conPrevNo',
        'conCurrNo',
        'appPrevNo',
        'appCurrNo',
        'totPrevNo','totCurrNo','created_by'
    ];
}
