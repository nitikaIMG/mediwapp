<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'user_feedback';

    protected $fillable =[
        'user_id','user_feedback','del_status'
    ];
}
