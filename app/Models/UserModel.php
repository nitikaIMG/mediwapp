<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'user';

    protected $fillable =[
        'user_image','user_firstname','user_lastname','user_email','user_phonenumber','user_password','user_address','status','del_status'
    ];
}
