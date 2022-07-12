<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;
use App\Models\CategoryModel;
use App\Models\CartModel;
use App\Models\ProductModel;
use Illuminate\Support\Carbon;
use App\Models\OrderModel;
use App\Models\SubcategoryModel;
use App\Models\wishlistModel;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ValidationTrait;

    public function myorders(Request $request){
        if($request->isMethod('get')){
            $data=[];
            $products_list = array();
            $dataa = array();
            $user_id=auth('api')->user()->id;
            $get_all_order=OrderModel::where('user_id',$user_id)->whereIn('order_status',['1','2','4'])->get();

            foreach($get_all_order as $dat){
                if($dat['order_status']=='1'){
                    $order_status="Approved";
                }else if($dat['order_status']=='2'){
                    $order_status="pending";
                }else if($dat['order_status']=='3'){
                    $order_status="Dispatch";
                }else if($dat['order_status']=='4'){
                    $order_status="Completed";
                }else if($dat['order_status']=='5'){
                    $order_status="Denied";
                }else if($dat['order_status']=='6'){
                    $order_status="Cancel";
                }else{
                    $order_status="Return";
                }

                if($dat['payment_status']=='1'){
                    $payement_status="Successfull";
                }else{
                    $payement_status="Pending";
                }

                $prod_id=explode(',',$dat['product']);

                $dataa['order_id']=(!empty($dat['order_id']))?$dat['order_id']:"";
                $dataa['order_price']=(!empty($dat['order_price']))?$dat['order_price']:"";
                $dataa['payment_id']=(!empty($dat['payment_id']))?$dat['payment_id']:"";
                $dataa['payment_status']=(!empty($payement_status))?$payement_status:"";
                $dataa['user_address']=!empty($dat['user_address'])?$dat['user_address']:"";
                $dataa['created_at']=!empty($dat['created_at'])?$dat['created_at']:"";
                $dataa['delivery_address']=!empty($dat['address'])?$dat['address']:"";
                $dataa['order_status']=!empty($order_status)?$order_status:"";
                $products_list = array();
                $get_prod_data=ProductModel::whereIn('id',$prod_id)->get();
                if(!empty($get_prod_data)){
                    foreach($get_prod_data as $pro_data){
                        $category=CategoryModel::where('id',$pro_data['category_id'])->select('category_name')->first();
                        $pro_dat['product_id']=$pro_data['id'];
                        $pro_dat['product_name']=(!empty($pro_data['product_name']))?$pro_data['product_name']:"";
                        $pro_dat['product_image']=(!empty($pro_data['product_image']))? asset('public/product_image').'/'.$pro_data['product_image']:"";
                        $pro_dat['price']=(!empty($pro_data['price']))?$pro_data['price']:"";
                        $pro_dat['offer']=(!empty($pro_data['offer']))?$pro_data['offer']:"";
                        $pro_dat['prod_qty']=(!empty($pro_data['prod_qty']))?$pro_data['prod_qty']:"";
                        $pro_dat['coupon']=(!empty($pro_data['coupon']))?$pro_data['coupon']:"";
                        $pro_dat['product_description']=(!empty($pro_data['product_description']))?$pro_data['product_description']:"";
                        $pro_dat['product_rating']=(!empty($pro_data['product_rating']))?$pro_data['product_rating']:"";
                        $pro_dat['category']=(!empty($category['category_name']))?$category['category_name']:"";
                        $products_list[]=$pro_dat;
                    }
                    $dataa['products_list'] = $products_list;
                    $data[]=$dataa;
                }else{
                    return ApiResponse::ok("No products found");
                }
            }
            if(!empty($get_all_order->toArray())){
                return ApiResponse::ok("Succesfully Fetched Orders Data",$data);
            }else{
                return ApiResponse::ok("No Orders For This User");
            }
        }
        else{
            return ApiResponse::error('Unauthorise Request');
        }
    }

    public function get_orderby_status(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $data = array();

            $ostatus = [1=>'Approved',2=>'Pending',4=>'Delivered'];

            $order_data = OrderModel::where('user_id',$user_id)->whereIn('order_status',['1','2','4'])->get();
            //get ordered product list
            $orderedProducts = collect(explode(',',$order_data->pluck('product')->join(',')))->unique()->all();

            $products = ProductModel::whereIn('id',$orderedProducts)->get();

            $orderBystatus = $order_data->groupBy('order_status')->all();

            foreach($orderBystatus as $okey=>$orderdata){

                $ps = $orderdata->map(function($item,$index) use($okey,$products,$ostatus){

                    $pids = explode(',',$item->product);

                    if(isset($ostatus[$okey])){

                        $data1[$ostatus[$okey]][$index] =$item; 

                        $data1[$ostatus[$okey]][$index]['product'] =$products->whereIn('id',$pids)->values();
                        
                        return $data1;
                    }
                    
                })->first();

                $data[]= $ps;
            }
            // return ApiResponse::ok('Fetch Order Details',[call_user_func_array('array_merge', $data)]);
            return ApiResponse::ok('Fetch Order Details',$data);
        }else{
            return ApiResponse::ok("No Orders For This User");
        }
    }

    public function cart_checkout(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), 
            [
                'product_id' => ['required'],
            ],[
                'product_id' =>'Product Id field Is Required..',
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }

            $user_id=auth('api')->user()->id;
            if(!empty($user_id)){
                    $implode_prd_id=implode(",",$request['product_id']);
                    $data['user_id']=$user_id;
                    $data['order_id']='MED'.random_int(100000, 999999);
                    $data['product']=$user_id;
                    $data['order_status']='2';
                    $data['payment_status']='0';
                    $data['order_amount']="1000";
                    OrderModel::create($data);
                    return ApiResponse::ok("Your order is in pending list wait untill admin will approve...");
            }else{
                return ApiResponse::ok("User Not logged In");
            }
            
            

        }else{
            return ApiResponse::error("Unauthorise Request");
        }
    }
}