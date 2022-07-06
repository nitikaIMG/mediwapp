<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use App\Models\PrescriptionModel;
use App\Api\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
   use ValidationTrait;
    public function prescriptionupload(Request $request){
        $data = [];
        $validator = Validator::make($request->all(), 
        [
           'file' => 'required',
        ]);
        if($validator->fails()){
           return $this->validation_error_response($validator);
        }
     
        if($request->hasfile('file')){
           foreach($request->file('file') as $image){  
              $name=$image->getClientOriginalName();
              $image->move('public/priscription_image/', $name);  
              $data[] = $name;  
           }
        }
     $image_data = implode(",",$data);
     PrescriptionModel::create(['file'=>$image_data]);
     return ApiResponse::ok('Prescription Uploaded');
    }
}

