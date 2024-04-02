<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusOfLand extends Model
{
    protected $table = 'status_of_land';
    protected $fillable = [
        'id',
        'qrr_id','mid',
        'area','freeleash','acqusition','created_by'
    ];
}
