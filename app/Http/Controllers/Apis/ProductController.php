<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\CartModel;
use Illuminate\Support\Carbon;
use App\Models\OrderModel;
use App\Models\RecentProduct;
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
            $dataa=[];
            $product_fav="";
            foreach($disc_prod as $key => $product){
                if($product['product_fav'] ==0){
                    $product_fav="No";
                }else{
                    $product_fav="Yes";
                }
                $category_id=$product['category_id'];
                $subcategory_id=$product['subcategory_id'];
                $category=CategoryModel::where('id',$category_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$subcategory_id)->select('subcategory_name')->first();
                $data['product_id']=$product['id'];
                $data['product_image'] = asset('public/product_image').'/'.$product['product_image'];
                $data['product_name'] = (!empty($product['product_name']))?$product['product_name']:"";
                $data['category_name'] = (!empty($product['category_name']))?$product['category_name']:"";
                $data['description']=(!empty($product['prod_desc']))?$product['prod_desc']:"";
                $data['product_rating']=(!empty($product['product_rating']))?$product['product_rating']:"";
                $data['product_fav'] = $product_fav;
                $data['price'] = (!empty($product['price']))?$product['price']:"";
                $data['offer'] = (!empty($product['offer']))?$product['offer']:"";
                $dataa[]=$data;
            }
           return ApiResponse::ok('Discounted Products',$dataa);
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
            $product_fav="";
            if(!empty($t_products)){
                foreach($t_products as $pro){
                   
                    if($pro->product_fav ==0){
                        $product_fav="No";
                    }else{
                        $product_fav="Yes";
                    }
    
                    $cat_id=$pro->category_id;
                    $subcat_id=$pro->subcategory_id;
                    $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                    $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                    $data['category_name']=$cat_name['category_name'];
                    $data['product_id']=$pro->id;
                    $data['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                    $data['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                    $data['price']=($pro->price != Null)?$pro->price:"";
                    $data['description']=($pro->prod_desc != Null)?$pro->prod_desc:"";
                    $data['product_rating']=($pro->product_rating != Null)?$pro->product_rating:"";
                    $data['product_fav']=$product_fav;
                    $data['offer']=($pro->offer != Null)?$pro->offer:"";
                    $data['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                    $dataa[] = $data;
                }
               return ApiResponse::ok('Trending Products',$dataa);
            }else{
                return ApiResponse::ok('No Data');
            }
            
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
            $product_fav="";
            foreach($t_products as $pro){
                if($pro->product_fav ==0){
                    $product_fav="No";
                }else{
                    $product_fav="Yes";
                }
                $cat_id=$pro->category_id;
                $subcat_id=$pro->subcategory_id;
                $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                $data['category_name']=$cat_name['category_name'];
                $data['product_id']=($pro->id != Null)?$pro->id:"";
                $data['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                $data['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                $data['price']=($pro->price != Null)?$pro->price:"";
                $data['description']=($pro->prod_desc != Null)?$pro->prod_desc:"";
                $data['product_rating']=($pro->product_rating != Null)?$pro->product_rating:"";
                $data['product_fav']=$product_fav;
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
                'status' => ['required'],
            ],[
                'product_id' =>'Product field Is Required..',
                'status' =>'Status field Is Required..',
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            
            $user_id=auth('api')->user()->id;
            if(!empty($user_id)){
                $data=[];
                $chk_user=wishlistModel::where('user_id',$user_id)->pluck('product_id')->first();
                
                if(!empty($chk_user) && $chk_user !=""){
                    $exp_prod=explode(',',$chk_user);
                    if($request->status=="1"){
                        $data['user_id']=$user_id;
                        $exp_prod = explode(",",$chk_user);

                        if(in_array($request['product_id'],$exp_prod) == "true"){
                            return ApiResponse::ok('Products Already in wishlist');
                        }

                        if(!$chk_user){
                            $data['product_id']=$request['product_id'];
                            wishlistModel::create($data);
                        }else{
                            $dd=explode(',',$chk_user);
                            array_push($dd,$request['product_id']);
                            $data=implode(',',$dd);
                            wishlistModel::where('user_id',$user_id)->update(['product_id'=>$data]);
                        } 
                        return ApiResponse::ok('Products Added in wishlist');
                    }else{
                        $data=explode(',',$chk_user);
                        foreach (array_keys($data, $request['product_id']) as $key) {
                            unset($data[$key]);
                        }
                        $implode_array=implode(',',$data);
                        wishlistModel::where('user_id',$user_id)->update(['product_id'=>$implode_array]);
                        return ApiResponse::ok('Products Removed from wishlist');
                    }
                   
                }else{
                    if($request->status="1"){
                        $data['product_id']=$request['product_id'];
                        $data['user_id']=$user_id;
                        wishlistModel::create($data);
                        return ApiResponse::ok('Products Added In Wishlist');
                    }else{
                        return ApiResponse::ok('No Products In Wishlist');
                    }
                }
            }else{
                return ApiResponse::ok('User Not LoggedIn');
            }
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }

    public function update_wishlist(Request $request){
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
            $get_wishlist_prod=wishlistModel::where('user_id',$user_id)->first();
            $userProducts = explode(',',$get_wishlist_prod->product_id);
            // dump($userProducts);
            unset($userProducts[array_search($request->product_id,$userProducts)]);
            $remProducts = implode(',',array_values($userProducts));
            wishlistModel::where('user_id',$user_id)->update(['product_id'=>$remProducts]);
            // dd();
            return ApiResponse::ok('Product Removed From Wishlist...');
        }else{
            return ApiResponse::error('Unauthorise Request...');
        }
    }

    public function show_wishlist(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $get_prod=wishlistModel::where('user_id',$user_id)->pluck('product_id');
            if($get_prod->isNotEmpty()){
                $explode_ids = $get_prod->toarray();
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
            return ApiResponse::ok('No products are in wishlist');
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
            $dataa=[];
            $product_id=$request->product_id;
            if(ProductModel::where('id',$product_id)->exists()){
                if(!empty($product_id)){
                    $user_id=auth('api')->user()->id;
                    $getmaxprod = RecentProduct::where('user_id',$user_id)->get();
                    if(count($getmaxprod)>=5){
                        RecentProduct::where('user_id',$user_id)->where('id',$getmaxprod[0]['id'])->delete();
                        RecentProduct::insert(['user_id'=>$user_id,'recent_product'=>$product_id]);
                    }else{
                        RecentProduct::insert(['user_id'=>$user_id,'recent_product'=>$product_id]);
                    }
                    $product_fav2='';
                    $get_product=ProductModel::where('id',$product_id)->first();
                    if(!empty($get_product)){
                        if($get_product['product_fav'] ==0){
                            $product_fav2="No";
                        }else{
                            $product_fav2="Yes";
                        }
                    }else{
                        $product_fav2="No";
                    }
                    $category_id=$get_product['category_id'];
                    $subcategory_id=$get_product['subcategory_id'];
                    $category=CategoryModel::where('id',$category_id)->select('category_name')->first();
                    $subcat_name=SubcategoryModel::where('id',$subcategory_id)->select('subcategory_name')->first();
                    $product_qty=CartModel::where('user_id',$user_id)->where('product_id',$product_id)->first();
                    $image_arr = explode(",",$get_product['product_image']);
                    $pro_qty="";
                    if($product_qty == NULL){
                        $pro_qty=0;
                    }else{
                        $pro_qty=$product_qty['product_qty'];
                    }
                    $product_image=[];
                    foreach( $image_arr as $image){
                    $product_image[] =($image != Null)?asset('public/product_image').'/'.$image:"";
                    }
                    $data['singledata']['product_image'] = $product_image;
                    $data['singledata']['product_name']=($get_product['product_name'] != Null)?$get_product['product_name']:"";
                    $data['singledata']['product_id']=($get_product['id'] != Null)?$get_product['id']:"";
                    $data['singledata']['price']=($get_product['price'] != Null)?$get_product['price']:"";
                    $data['singledata']['offer']=($get_product['offer'] != Null)?$get_product['offer']:"";
                    $data['singledata']['product_qty']=$pro_qty;
                    $data['singledata']['product_rating']=($get_product['product_rating'] != Null)?$get_product['product_rating']:"";
                    $data['singledata']['prod_desc']=($get_product['prod_desc'] != Null)?$get_product['prod_desc']:"";
                    $data['singledata']['offer']=($get_product['offer'] != Null)?$get_product['offer']:"";
                    $data['singledata']['category_name']=((!empty($category))?(($category['category_name'] != Null)?$category['category_name']:""):"");
                    // dd('s');

                    $data['singledata']['product_fav']=$product_fav2;
        
                    $similiar_prod=ProductModel::where('category_id',$category_id)->limit(10)->get();
                    foreach($similiar_prod as $dd){
                        if($dd->product_fav ==0){
                            $product_fav1="No";
                        }else{
                            $product_fav1="Yes";
                        }
                        $cat_name=CategoryModel::where('id',$category_id)->select('category_name')->first();
                        $dataa['category_name']=((!empty($cat_name))?(($cat_name['category_name'] != Null)?$cat_name['category_name']:""):"");
                        $dataa['product_image']=($dd['product_image'] != Null)?asset('public/product_image').'/'.$dd['product_image']:"";
                        $dataa['product_id']=($dd['product_id'] != Null)?$dd['product_id']:"";
                        $dataa['product_name']=($dd['product_name'] != Null)?$dd['product_name']:"";
                        $dataa['price']=($dd['price'] != Null)?$dd['price']:"";
                        $dataa['prod_desc']=($dd['prod_desc'] != Null)?$dd['prod_desc']:"";
                        $dataa['product_rating']=($dd['product_rating'] != Null)?$dd['product_rating']:"";
                        $dataa['offer']=($dd['offer'] != Null)?$dd['offer']:"";
                        $dataa['product_fav']=$product_fav1;
                        $data['similar_prod'][] = $dataa;
                    }

                    $productdata=OrderModel::limit(10)->pluck('product')->join(',');
                    $order_p=explode(',',$productdata);
                    $res = collect(array_count_values($order_p))->sortDesc()->all();
                    $p_id=array_keys($res);
                    
                    $t_products=ProductModel::whereIn('id',$p_id)->take('15')->where('status','1')->where('del_status','1')->get();
                    foreach($t_products as $pro){
                        if($pro->product_fav ==0){
                            $product_fav="No";
                        }else{
                            $product_fav="Yes";
                        }
                        $cat_id=$pro->category_id;
                        $subcat_id=$pro->subcategory_id;
                        $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                        $subcat_name=SubcategoryModel::where('id',$subcat_id)->select('subcategory_name')->first();
                        $dataaaaa['product_id']=($pro->id != Null)?$pro->id:"";
                        $dataaaaa['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                        $dataaaaa['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                        $dataaaaa['price']=($pro->price != Null)?$pro->price:"";
                        $dataaaaa['description']=($pro->prod_desc != Null)?$pro->prod_desc:"";
                        $dataaaaa['product_rating']=($pro->product_rating != Null)?$pro->product_rating:"";
                        $dataaaaa['product_fav']=$product_fav;
                        $dataaaaa['min_quantity']=($pro->min_quantity != Null)?$pro->min_quantity:"";
                        $dataaaaa['opening_quantity']=($pro->opening_quantity != Null)?$pro->opening_quantity:"";
                        $dataaaaa['offer']=($pro->offer != Null)?$pro->offer:"";
                        $dataaaaa['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                        $data['frequent_prod'][] = $dataaaaa;
                    }
                        return ApiResponse::ok('Success Fetched Data',[$data]);
                }else{
                    return ApiResponse::ok('Invalid Product ID',$dataa);
                }
            }else{
                return ApiResponse::ok('Invalid Product ID',$dataa);
            }
           
        }else{
            return ApiResponse::error('Unauthorise Request');
        } 
    }

    public function categoryproduct(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'category_id' => 'required',
                ]);
            if($validator->fails()){
               return $this->validation_error_response($validator);
            }
            $t_products=ProductModel::where('category_id',$request->category_id)->take('15')->where('status','1')->where('del_status','1')->get();
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
                $data['product_id']=$pro->id;
                $data['min_quantity']=($pro->min_quantity != Null)?$pro->min_quantity:"";
                $data['opening_quantity']=($pro->opening_quantity != Null)?$pro->opening_quantity:"";
                $data['offer']=($pro->offer != Null)?$pro->offer:"";
                $data['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                $dataa[] = $data;
            }
           return ApiResponse::ok('Categorized Products',$dataa);
        }else{           
            return ApiResponse::error('Unauthorise Request');
        }
    }
    public function recent_view(Request $request){
        if($request->isMethod('get')){
            $user_id=auth('api')->user()->id;
            $get_prod_id=RecentProduct::where('user_id',$user_id)->pluck('recent_product')->toArray();
            if(!empty($get_prod_id)){
                $recent_prod=ProductModel::whereIn('id',$get_prod_id)->get();
                if(!empty($recent_prod)){
                    foreach($recent_prod as $pro){
                        $cat_id=$pro->category_id;
                        $cat_name=CategoryModel::where('id',$cat_id)->select('category_name')->first();
                        $data['category_name']=!empty($cat_name)?$cat_name->category_name:'';
                        $data['product_name']=($pro->product_name != Null)?$pro->product_name:"";
                        $data['product_image']=($pro->product_image != Null)?asset('public/product_image').'/'.$pro->product_image:"";
                        $data['price']=($pro->price != Null)?$pro->price:"";
                        $data['product_id']=$pro->id;
                        $data['min_quantity']=($pro->min_quantity != Null)?$pro->min_quantity:"";
                        $data['opening_quantity']=($pro->opening_quantity != Null)?$pro->opening_quantity:"";
                        $data['offer']=($pro->offer != Null)?$pro->offer:"";
                        $data['offer_type']=($pro->offer_type != Null)?$pro->offer_type:"";
                        $dataa[] = $data;
                    }
                    return ApiResponse::ok('Categorized Products',$dataa);
                }
            }else{
                return ApiResponse::ok('No Recents Viewed Products...');
            }
        }else{
            return ApiResponse::error('Unauthorise Request');
        }
    }
}
