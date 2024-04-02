<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalsRequired extends Model
{
   protected $table = 'approvals_required';
        protected $fillable = [
            'id',
            'qrr_id',
            'reqapproval',
            'concernbody',
            'process',
            'dtexpected',
            'dtvalidity',
            'isapproval' ,
            'created_by'      
             ];
    
    
}
