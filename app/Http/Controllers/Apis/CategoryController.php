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
      return ApiResponse::ok('Successfully Fetch data',$category);
   }
}
