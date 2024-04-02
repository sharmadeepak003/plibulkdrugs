<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufactureProductCapacity extends Model
{
    protected $fillable = [
        'id',
        'm_id',
        'product',
        'capacity',
        'created_by'
    ];
}
