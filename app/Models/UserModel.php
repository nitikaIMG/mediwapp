<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\wishlistModel;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table = 'user';

    protected $fillable =[
        'user_image','user_firstname','user_lastname','user_email','dob','gender','user_phonenumber','user_password','user_address','status','del_status'
    ];

    public function getFavrioutes(){
        return $this->hasone(wishlistModel::class,'user_id');
    }

   
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims() {
        return [];
    }    
}
