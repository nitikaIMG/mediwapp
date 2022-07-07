<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function myorders(Request $request){
        if($request->isMethod('get')){
            $user_id=
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
}