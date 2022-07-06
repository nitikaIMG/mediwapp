<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcategoryModel;
use App\Traits\ValidationTrait;
use App\Api\ApiResponse;

class SubcategoryController extends Controller
{
    use ValidationTrait;
    public function index(Request $request){
        $category=SubcategoryModel::where('cat_status','1')->get();
        return ApiResponse::ok('Successfully Fetch data',$category);
     }
}