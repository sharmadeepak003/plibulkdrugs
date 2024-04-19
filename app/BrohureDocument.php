<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class BrohureDocument extends Model
{
    //use SoftDeletes;
    protected $table = 'brochure_uploads';
    protected $fillable = [
        'id',
        'app_id',
        'target_segment_id',
        'product_id',
        'admin_id',
        'file_name',
        'mime',
        'file_size',
        'uploaded_file',
        'remarks',
        'created_at',
        'updated_at',
        'prod_category',
        'other_file_name',
        'other_mime',
        'other_file_size',
        'other_uploaded_file',
        'websitelink'
    ];
}
