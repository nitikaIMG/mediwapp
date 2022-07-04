<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use App\Api\ApiResponse;


class CategoryController extends Controller
{
   use ValidationTrait;
   public function index(Request $request){
      $category=CategoryModel::where('cat_status','1')->get();
      $data = [];
      foreach($category as $kry => $cat){
         $catdata['id'] = ($cat->id!=null)?$cat->id:"";
         $catdata['category_name'] = ($cat->category_name!=null)?$cat->category_name:"";
         $catdata['category_image'] = ($cat->category_image!=null)?$cat->category_image:"";
         $catdata['cat_status'] = ($cat->cat_status!=null)?$cat->cat_status:"";
         $catdata['banner'] = ($cat->banner!=null)?$cat->banner:"";
         $data[] = $catdata;
      }
      return ApiResponse::ok('Successfully Fetch data',$data);
   }
}
