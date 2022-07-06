<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use Illuminate\Http\Request;
use App\Api\ApiResponse;
use App\Traits\ValidationTrait;

class BrandController extends Controller
{
    use ValidationTrait;
    public function index(Request $request){
        $category=BrandModel::where('cat_status','1')->get();
        return ApiResponse::ok('Successfully Fetch data',$category);
    }
}
