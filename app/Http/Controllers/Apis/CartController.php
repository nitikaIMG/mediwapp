<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
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

    public function showcart(Request $request){
        if($request->isMethod('get')){
            $card_data = CartModel::all();
            $dataa=[];
            foreach($card_data as $card){
               
                $user_id=$card->user_id;
                $product_id=$card->product_id;
                $product_qty=$card->product_qty;
                $address_id=$card->address_id;
                $category=CategoryModel::where('id',$product_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$product_id)->select('subcategory_name')->first();
                $cat_project=ProductModel::where('id',$product_id)->first();
                
                $data['category_name']=((!empty($category))?(($category['category_name'] != Null)?$category['category_name']:""):"");
                $data['subcategory_name']=$subcat_name['subcategory_name'];
                $data['product_name']=($cat_project['product_name'] != Null)?$cat_project['product_name']:"";
                $data['product_image']=($cat_project['product_image'] != Null)?asset('public/product_image').'/'.$cat_project['product_image']:"";
                $data['amount']=($cat_project['price'] != Null)?$cat_project['price']:"";
                $data['min_quantity']=($cat_project['min_quantity'] != Null)?$cat_project['min_quantity']:"";
                $data['opening_quantity']=($cat_project['opening_quantity'] != Null)?$cat_project['opening_quantity']:"";
                $data['offer']=($cat_project['offer'] != Null)?$cat_project['offer']:"";
                $data['offer_type']=($cat_project['offer_type'] != Null)?$cat_project['offer_type']:"";
                $dataa[] = $data;
                // $cat_name=ProductModel::where('id',$card->product_id)->first();
            
            }
           return ApiResponse::ok('Fetch Card Details',$dataa);
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }

    }

    public function view_cart(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $card_data=CartModel::where('user_id',$user_id)->where('del_status',1)->get();
            foreach($card_data as $card){
                $user_id=$card->user_id;
                $product_id=$card->product_id;
                $product_qty=$card->product_qty;
                $address_id=$card->address_id;
                $category=CategoryModel::where('id',$product_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$product_id)->select('subcategory_name')->first();
                $cat_project=ProductModel::where('id',$product_id)->first();
                
                $data['category_name']=((!empty($category))?(($category['category_name'] != Null)?$category['category_name']:""):"");
                $data['product_name']=($cat_project['product_name'] != Null)?$cat_project['product_name']:"";
                $data['product_image']=($cat_project['product_image'] != Null)?asset('public/product_image').'/'.$cat_project['product_image']:"";
                $data['amount']=($cat_project['price'] != Null)?$cat_project['price']:"";
                $data['min_quantity']=($cat_project['min_quantity'] != Null)?$cat_project['min_quantity']:"";
                $data['opening_quantity']=($cat_project['opening_quantity'] != Null)?$cat_project['opening_quantity']:"";
                $data['offer']=($cat_project['offer'] != Null)?$cat_project['offer']:"";
                $data['offer_type']=($cat_project['offer_type'] != Null)?$cat_project['offer_type']:"";
                $dataa[] = $data;
            }
            return ApiResponse::ok('Fetch Card Details',$dataa);

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
                    if($cartdata->product_qty<=0)
                    { 
                        return ApiResponse::ok('Product QTY is not less then zero');
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
            
        }else{
            return ApiResponse::error("Unauthorise Request");
        }
    }
}
