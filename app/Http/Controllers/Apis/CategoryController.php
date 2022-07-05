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


class CategoryController extends Controller
{
   use ValidationTrait;
   public function index(Request $request){
      if($request->isMethod('get')){
         $category=CategoryModel::where('cat_status','1')->get();
      $data = [];
      $status="";
      foreach($category as $kry => $cat){
         if($cat->cat_status == "1"){
            $status="Enable";
         }else{
            $status="Disable";
         }
         $catdata['id'] = ($cat->id!=null)?$cat->id:"";
         $catdata['category_name'] = ($cat->category_name!=null)?$cat->category_name:"";
         $catdata['category_image'] = ($cat->category_image!=null)?$cat->category_image:"";
         $catdata['cat_status'] = ($status!=null)?$status:"";
         $catdata['banner'] = ($cat->banner!=null)?$cat->banner:"";
         $data[] = $catdata;
      }
      return ApiResponse::ok('Successfully Fetch data',$data);
      }else{
         return ApiResponse::error('Unauthorise Request');
      }
      
   }
}
