<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AndroidAppId extends Model
{
    use HasFactory;
    protected $table = 'androidappid';

    protected $fillable =[
        'user_id','app_key'
    ];
}
