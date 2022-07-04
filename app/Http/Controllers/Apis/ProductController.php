<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;
use App\Models\ProductModel;
use Illuminate\Support\Carbon;
use App\Models\OrderModel;
use App\Models\wishlistModel;
use Illuminate\Support\Facades\Validator;

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
            $productdata=OrderModel::limit(10)->pluck('product')->join(',');
            $order_p=explode(',',$productdata);
            $p_id=array_unique($order_p);
            $t_products=ProductModel::whereIn('id',$p_id)->where('status','1')->get();
           return ApiResponse::ok('Trending Products',$t_products);
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }
    public function bestseller(Request $request){
        if($request->isMethod('get')){
            $productdata=OrderModel::limit(10)->pluck('product')->join(',');
            $order_p=explode(',',$productdata);
            $res = collect(array_count_values($order_p))->sortDesc()->all();
            $p_id=array_keys($res);
            $t_products=ProductModel::whereIn('id',$p_id)->take('15')->where('status','1')->get();
           return ApiResponse::ok('Best seller Products',$t_products);
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }

    public function add_wishlist_prod(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), 
            [
                'product_id' => ['required'],
            ],[
                'product_id' =>'Product field Is Required..',
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            $user_id=auth('api')->user()->id;
            if(!empty($user_id)){
                $data=[];
                $chk_user=wishlistModel::where('user_id',$user_id)->pluck('product_id')->toArray();
                $exp_prod=explode(',',$chk_user[0]);
                if(in_array($request['product_id'],$exp_prod) == "true"){
                    return ApiResponse::error('Products Already in wishlist');
                }else{
                    $data['user_id']=$user_id;
                    if(!$chk_user){
                        $data['product_id']=$request['product_id'];
                        wishlistModel::create($data);
                    }else{
                        $prod_data=array_push($chk_user,$request['product_id']);
                        $data=implode(',',$chk_user);
                        wishlistModel::where('user_id',$user_id)->update(['product_id'=>$data]);
                    }
                    return ApiResponse::ok('Products Added in wishlist');
                }
                    
            }else{
                return ApiResponse::error('User Not LoggedIn');
            }
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }
}
