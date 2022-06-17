<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable =[
        'user_id','order_id','product','order_status','payment_status','prescription','address','payment_id','status','del_status'
    ];
}
