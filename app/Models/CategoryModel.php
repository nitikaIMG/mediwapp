<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable =[
        'category_name','subcategory_id','category_image','category_type','cat_desc','cat_status'
    ];

}
