<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentParticulars extends Model
{
    protected $fillable = [
        'id',
        'name',
        'type',
        'status',
        'active',
    ];
}
