<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimSalesDoc extends Model
{
    protected $table='claim_sales_doc';
    protected $fillable = [
        'id',
        'app_id',
        'claim_id',
        'created_by',
        'ques_id',
        'response',
        'doc_id',
        'upload_id',
    ];
}
