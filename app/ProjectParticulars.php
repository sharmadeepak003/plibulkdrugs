<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectParticulars extends Model
{
    protected $fillable = [
        'id',
        'name',
        'status',
        'active',
    ];
}
