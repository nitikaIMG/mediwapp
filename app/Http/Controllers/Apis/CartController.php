<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ValidationTrait;


class CartController extends Controller
{
    use ValidationTrait;
    public function addcart(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), 
            [
                'product_id' => ['required'],
                'product_qty' => ['required'],
            ],[
                'product_id' =>'Product Id field Is Required..',
                'product_qty' =>'Product Quantity Is Required..',
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            $user_id=auth('api')->user()->id;
            $data['user_id']=$user_id;
            $data['product_id']=$request->product_id;
            $data['product_qty']=$request->product_qty;
            CartModel::create($data);
            return ApiResponse::ok("Data Added Into Cart");
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
}
