<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    use HasFactory;
    protected $table = 'useraddress';

    protected $fillable =[
        'name','mobile_no','pincode','house_no','landmark','city','state'
    ];
}
