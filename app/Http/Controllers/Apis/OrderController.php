<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;
use App\Models\CategoryModel;
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
            $user_id=auth('api')->user()->id;
            $get_all_order=OrderModel::where('user_id',$user_id)->get();
            foreach($get_all_order as $dat){
                if($dat['order_status']=='1'){
                    $order_status="Create";
                }else if($dat['order_status']=='2'){
                    $order_status="pending";
                }else if($dat['order_status']=='3'){
                    $order_status="Dispatch";
                }else if($dat['order_status']=='4'){
                    $order_status="Delivered";
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
//prod_data
                $prod_id=explode(',',$dat['product']);
                $get_prod_data=ProductModel::whereIn('id',$prod_id)->get();
                foreach($get_prod_data as $pro_data){
                    $category=CategoryModel::where('id',$pro_data['category_id'])->select('category_name')->first();
                    $pro_dat['product_id']=$pro_data['id'];
                    $pro_dat['product_image']=(!empty($pro_data['product_image']))?$pro_data['product_image']:"";
                    $pro_dat['price']=(!empty($pro_data['price']))?$pro_data['price']:"";
                    $pro_dat['offer']=(!empty($pro_data['offer']))?$pro_data['offer']:"";
                    $pro_dat['product_description']=(!empty($pro_data['product_description']))?$pro_data['product_description']:"";
                    $pro_dat['product_rating']=(!empty($pro_data['product_rating']))?$pro_data['product_rating']:"";
                    $pro_dat['category']=(!empty($category['category_name']))?$category['category_name']:"";
                    $data['product_data']=$pro_dat;
                }
//order_data
                $dataa['order_id']=(!empty($dat['order_id']))?$dat['order_id']:"";
                $dataa['order_price']=(!empty($dat['order_price']))?$dat['order_price']:"";
                $dataa['payment_id']=(!empty($dat['payment_id']))?$dat['payment_id']:"";
                $dataa['payment_status']=(!empty($payement_status))?$payement_status:"";
                $dataa['user_address']=!empty($dat['user_address'])?$dat['user_address']:"";
                $dataa['created_at']=!empty($dat['created_at'])?$dat['created_at']:"";
                $dataa['order_status']=!empty($order_status)?$order_status:"";
                $data['myorder']=$dataa;
            }
            if(!empty($get_all_order->toArray())){
                return ApiResponse::ok("Succesfully Fetched Orders Data",[$data]);
            }else{
                return ApiResponse::ok("No Orders For This User");
            }
        }
        else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
}