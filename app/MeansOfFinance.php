<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeansOfFinance extends Model
{
    protected $table = 'means_of_finance';
    protected $fillable = [
        'id',
        'qrr_id',
        'eAmount','eStatus','eRemarks',
        'iAmount','iStatus','iRemarks',
        'tAmount',
        'dAmount','dStatus','dRemarks','created_by'
    ];
}
