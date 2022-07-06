<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeathGoalModel extends Model
{
    use HasFactory;
    protected $table = 'healthgoal';

    protected $fillable =[
        'health_goals'
    ];

    public function products(){
        return $this->hasMany(ProductModel::class,'health_goal');
    }
}
