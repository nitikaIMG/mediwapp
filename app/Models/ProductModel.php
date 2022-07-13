<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable =[
        'product_name','min_quantity','product_image','category_id','subcategory_id','status','prod_desc','price','package_type','opening_quantity','brand_image','validate_date','offer','offer_type'
    ];
}

    