<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentProduct extends Model
{
    use HasFactory;
    protected $table = 'recentview_products';
    protected $fillable = ['user_id','recent_product'];
}
