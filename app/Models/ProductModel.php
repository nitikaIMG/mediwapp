<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable =[
        'product_name','product_image','category_id','subcategory_id','status','prod_desc','sale_price','purchase_price'
    ];
}

