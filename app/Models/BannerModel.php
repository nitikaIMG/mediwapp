<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory;
    protected $table = 'banner';

    protected $fillable =[
        'banner','banner_url','status','del_status','banner_type'
    ];
    protected $guarded = [];

}
