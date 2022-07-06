<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    use HasFactory;
    protected $table = 'prescription';

    protected $fillable =[
        'user_id','file'
    ];
}
