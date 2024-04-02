<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrrDva extends Model
{
    protected $table = 'qrr_dva';
    protected $fillable = [
        'id',
        'qrr_id', 
        'EPprevquant',
        'EPprevsales',
        'EPprevamount',
        'EPcurrquant',
        'EPcurrsales',
        'EPcurramount',
        'totConprevquant',
        'totConprevsales',
        'totConprevamount',
        'totConcurrquant',
        'totConcurrsales',
        'totConcurramount',
        'matprevquant',
        'matprevsales',
        'matprevamount',
        'matcurrquant',
        'matcurrsales',
        'matcurramount',
        'serprevquant',
        'serprevsales',
        'serprevamount',
        'sercurrquant',
        'sercurrsales',
        'sercurramount',
        'prevDVATotal',
        'currDVATotal','created_by'
    ];
}
