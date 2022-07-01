<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;
use App\Models\ProductModel;
use Illuminate\Support\Carbon;
use App\Models\OrderModel;

class ProductController extends Controller
{
    use ValidationTrait;
    public function index(Request $request){
        $category=ProductModel::where('cat_status','1')->get();
        return ApiResponse::ok('Successfully Fetch data',$category);
    }

    public function discountedproduct(Request $request){
        if($request->isMethod('get')){
            $disc_prod=ProductModel::where('offer','!=','NULL')->whereDate('validate_date','>=',Carbon::today()->toDateString())->where('status',1)->get();
            $data=[];
            foreach($disc_prod as $key => $product){
                $data[] = $product;
            }
           return ApiResponse::ok('Discounted Products',$data);
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
    public function trendingproduct(Request $request){
        if($request->isMethod('get')){
            $productdata=OrderModel::pluck('product')->limit(10)->join(',');
            $order_p=explode(',',$productdata);
            $p_id=array_unique($order_p);
            $t_products=ProductModel::whereIn('id',$p_id)->where('status','1')->get();
           return ApiResponse::ok('Trending Products',$t_products);
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }
}
