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

class ProductController extends Controller
{
    use ValidationTrait;
    public function index(Request $request){
        $category=ProductModel::where('cat_status','1')->where('del_status',1)->get();
        return ApiResponse::ok('Successfully Fetch data',$category);
    }

    public function discountedproduct(Request $request){
        if($request->isMethod('get')){
            $disc_prod=ProductModel::where('offer','!=','NULL')->whereDate('validate_date','>=',Carbon::today()->toDateString())->where('status',1)->where('del_status',1)->get();
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
            $t_products=ProductModel::whereIn('id',$p_id)->where('status','1')->where('del_status',1)->get();
            $dataa=[];
            foreach($t_products as $pro){
                $cat_id=$pro->category_id;
                $subcat_id=$pro->subcategory_id;
                $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                $data['category_name']=$cat_name['category_name'];
                $data['subcategory_name']=$subcat_name['subcategory_name'];
                $data['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                $data['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                $data['price']=($pro->price != Null)?$pro->price:"";
                $data['min_quantity']=($pro->min_quantity != Null)?$pro->min_quantity:"";
                $data['opening_quantity']=($pro->opening_quantity != Null)?$pro->opening_quantity:"";
                $data['offer']=($pro->offer != Null)?$pro->offer:"";
                $data['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                $dataa[] = $data;
            }
           return ApiResponse::ok('Trending Products',$dataa);
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
            $t_products=ProductModel::whereIn('id',$p_id)->take('15')->where('status','1')->where('del_status','1')->get();
            $dataa=[];
            foreach($t_products as $pro){
                $cat_id=$pro->category_id;
                $subcat_id=$pro->subcategory_id;
                $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                $data['category_name']=$cat_name['category_name'];
                $data['subcategory_name']=$subcat_name['subcategory_name'];
                $data['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                $data['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                $data['price']=($pro->price != Null)?$pro->price:"";
                $data['min_quantity']=($pro->min_quantity != Null)?$pro->min_quantity:"";
                $data['opening_quantity']=($pro->opening_quantity != Null)?$pro->opening_quantity:"";
                $data['offer']=($pro->offer != Null)?$pro->offer:"";
                $data['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                $dataa[] = $data;
            }
           return ApiResponse::ok('Best seller Products',$dataa);
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
                if(!empty($chk_user)){
                    $exp_prod=explode(',',$chk_user[0]);
                    if(in_array($request['product_id'],$exp_prod) == "true"){
                        return ApiResponse::error('Products Already in wishlist');
                    }
                }
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
                    
            }else{
                return ApiResponse::error('User Not LoggedIn');
            }
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }

    public function show_wishlist(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $get_prod=wishlistModel::where('user_id',$user_id)->pluck('product_id');
            $get_prod_id=$get_prod[0];
            if(!empty($get_prod_id)){
                $explode_ids=explode(',',$get_prod_id);
                $get_wishlist_prod=ProductModel::whereIn('id',$explode_ids)->get();
                $dataa=[];
                foreach($get_wishlist_prod as $prod){
                    $cat_id=$prod->category_id;
                    $subcat_id=$prod->subcategory_id;
                    $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                    $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                    $data['category_name']=(!empty($cat_name['category_name']))?$cat_name['category_name']:"";
                    $data['subcategory_name']=(!empty($subcat_name['subcategory_name']))?$subcat_name['subcategory_name']:"";
                    $data['prodduct_name']=($prod->product_name != Null)?$prod->product_name:"";
                    $data['price']=($prod->price != Null)?$prod->price:"";
                    $data['min_quantity']=($prod->min_quantity != Null)?$prod->min_quantity:"";
                    $data['opening_quantity']=($prod->opening_quantity != Null)?$prod->opening_quantity:"";
                    $data['offer']=($prod->offer != Null)?$prod->offer:"";
                    $data['offer_type']=($prod->offer_type != Null)?$prod->offer_type:"";
                    $dataa[] = $data;
                }

                return ApiResponse::ok('Succesfully Fetchd Data',$dataa);
            }else{
            return ApiResponse::error('No products are in wishlist');
            }
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
    public function single_product(Request $request){
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
            $product_id=$request->product_id;
            if(!empty($product_id)){
                $get_product=ProductModel::where('id',$product_id)->first();
                $category_id=$get_product['category_id'];
                $subcategory_id=$get_product['subcategory_id'];
                $category=CategoryModel::where('id',$category_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$subcategory_id)->select('subcategory_name')->first();
                $data['product_image']=($get_product['product_image'] != Null)?$get_product['product_image']:"";
                $data['product_name']=($get_product['product_name'] != Null)?$get_product['product_name']:"";
                $data['price']=($get_product['price'] != Null)?$get_product['price']:"";
                $data['prod_desc']=($get_product['prod_desc'] != Null)?$get_product['prod_desc']:"";
                $data['offer']=($get_product['offer'] != Null)?$get_product['offer']:"";
                $data['offer_type']=($get_product['offer_type'] != Null)?$get_product['offer']:"";
                $data['category_name']=($category['category_name'] != Null)?$category['category_name']:"";
                $data['subcategory_name']=($subcat_name['subcategory_name'] != Null)?$subcat_name['subcategory_name']:"";
                return ApiResponse::ok('Success Fetched Data',$data);
            }
           
        }else{
            return ApiResponse::error('Unauthorise Request');
        } 
    }
}
