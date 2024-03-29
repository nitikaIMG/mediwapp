<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\SubcategoryModel;
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
            ],[
                'product_id' =>'Product Id field Is Required..',
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            
            $user_id=auth('api')->user()->id;
            $data['user_id']=$user_id;
            $data['product_id']=$request->product_id;
            $data['product_qty']=1;
            $get_prod = CartModel::where('user_id',$user_id)->where('product_id',$request->product_id)->first();
            
            if($get_prod){
                $newqty['product_qty']  = $data['product_qty'] + $get_prod->product_qty;
                return ApiResponse::ok("Data already  Into Cart");
                CartModel::where('id',$get_prod->id)->update($newqty);
            }else{
                CartModel::create($data);
            }
            
            return ApiResponse::ok("Data Added Into Cart");
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }

  
    public function view_cart(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $data =[];
            $dataa =[];
            $card_data=CartModel::where('user_id',$user_id)->where('del_status',1)->get();
            if(!empty($card_data  && $card_data->isNotEmpty())){
            foreach($card_data as $card){
                    $user_id=$card->user_id;
                    $product_id=$card->product_id;
                    $product_qty=$card->product_qty;
                    $address_id=$card->address_id;
                    $cat_project=ProductModel::where('id',$product_id)->first();
                    if(!empty($cat_project)){
                        $category=CategoryModel::where('id',$product_id)->select('category_name')->first();
                        $subcat_name=SubcategoryModel::where('id',$product_id)->select('subcategory_name')->first();
                        $data['category_name']=((!empty($category))?(($category['category_name'] != Null)?$category['category_name']:""):"");
                        $data['product_id']=(!empty($product_id))?intval($product_id):"";
                        $data['product_name']=(!empty($cat_project['product_name']))?$cat_project['product_name']:"";
                        $data['product_image']=(!empty($cat_project['product_image']))?asset('public/product_image').'/'.$cat_project['product_image']:"";
                        $data['amount']=(!empty($cat_project['price']))?$cat_project['price']:"";
                        $data['offer']=(!empty($cat_project['offer']))?$cat_project['offer']:"";
                        $data['offer_type']=(!empty($cat_project['offer_type']))?$cat_project['offer_type']:"";
                        $data['product_qty']=intval($product_qty);
                        $dataa[] = $data;
                    }
                    
            }
            return ApiResponse::ok('Fetch Card Details',$dataa);
           }
           else{
            return ApiResponse::ok('No data in cart');
           }
            
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }

    public function add_remove(Request $request)
    {
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'product_id' => 'required',
                'type' => 'required',
                ]);
            if($validator->fails()){
            return $this->validation_error_response($validator);
            }
            $user_id=auth('api')->user()->id;
            $pid = $request->get('product_id');
            $cartdata = CartModel::where('user_id', $user_id)->where('product_id', $pid)->first();
            if(!empty($cartdata)){
                if($request->type == 'add'){
                    $newqnt = $cartdata->product_qty+1;
                }else{
                    if($cartdata->product_qty==1)
                    { 
                        CartModel::where('user_id',$user_id)->where('product_id',$pid)->delete();
                        
                        return ApiResponse::ok('Item remove form card succesfully');
                    }
                    else{
                        $newqnt = $cartdata->product_qty-1;
                    } 
                }
                CartModel::where('user_id', $user_id)->where('product_id', $pid)->update(['product_qty'=>$newqnt]);
                return ApiResponse::ok('Item  Update Successfully');
            }
            else{
                return ApiResponse::error('Product id invalid');
            }
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
   
}
