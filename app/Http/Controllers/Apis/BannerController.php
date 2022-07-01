<?php

namespace App\Http\Controllers\Apis;
use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerModel;

class BannerController extends Controller
{
   public function banner(Request $request){
    if ($request->isMethod('get')){
        $banner_data=BannerModel::select('banner_url','banner')->get();
        $data=$banner_data->map(function($item, $key){
            return collect($item->attributesToArray())->map(function($value, $index){
                return (!empty($value))?$value:'';  
            });
            return $item;
        });
        return ApiResponse::ok('Succefully fetched adata',$data);
    }else{
        return ApiResponse::error('Unauthorise Request');
    }
   }
}
