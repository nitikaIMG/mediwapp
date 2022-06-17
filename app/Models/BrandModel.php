<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;
    protected $table = 'brand';
    protected $softDelete = true;

    protected $fillable =[
        'brand_name','category_id','subcategory_id','brand_image','status'
    ];
}
