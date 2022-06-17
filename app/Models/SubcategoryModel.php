<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryModel extends Model
{
    use HasFactory;
    protected $table = 'subcategory';

    protected $fillable =[
        'subcategory_name','category_id','category_image','status'
    ];
}
