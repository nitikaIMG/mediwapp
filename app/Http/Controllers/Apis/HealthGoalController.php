<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\HeathGoalModel;
use Illuminate\Http\Request;

class HealthGoalController extends Controller
{
    public function healthgoal(Request $request){
        if($request->isMethod('get')){
            $all_goals=HeathGoalModel::all();
            $data = [];
            foreach ($all_goals as $gole_key => $goal) {
                $products = $goal->products;
                $data[$gole_key] = $goal;
                $arr = ['created_at'];
                $data[$gole_key]['products'] = $products;
            }
            return ApiResponse::ok('Goals products',$data);
        }else{
            return ApiResponse::error('Unaauthorise Request');
        }
    }
}
