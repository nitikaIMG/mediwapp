<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\AddressModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ValidationTrait;

class UserController extends Controller
{
   use ValidationTrait;

   public function userprofile(Request $request){
      $user_id=auth('api')->user()->id;
      if(!empty($user_id)){
      $user_data=UserModel::where('id',$user_id)->first();
      $input['id'] = $user_data->id ;
      $input['user_image'] = ($user_data->user_image != null)?$user_data->user_image:"";
      $input['user_firstname'] = ($user_data->user_firstname!= null)?$user_data->user_firstname:"";
      $input['user_lastname'] = ($user_data->user_lastname!=null)?$user_data->user_lastname:"";
      $input['user_email'] = ($user_data->user_email!=null)?$user_data->user_email:"";
      $input['user_phonenumber'] = ($user_data->user_phonenumber!=null)?$user_data->user_phonenumber:"";
      $input['status'] = ($user_data->status==1)?'Active':'Deactive';
      return ApiResponse::ok('userdata',$input);
      }else{
         return ApiResponse::error('User Not LoggedIn');
      }
   }

   public function add_address(Request $request){
      $validator = Validator::make($request->all(),[
      'name' => 'required',
      'mobile_no' => 'required|digits:10',
      'pincode' =>'required',
      'house_no'=>'required',
      'landmark' =>'required',
      'city' =>'required',
      'state'=>'required',
      ]);

      if($validator->fails()){
         return $this->validation_error_response($validator);
      }

      $address_data = $request->all();
      $data = AddressModel::create($address_data); 
      return['success' =>'Data Save Successfully','data'=>$data];
   }

   public function  show_address(Request $request){
      $adddress_show =AddressModel::all();
      return ApiResponse::ok("User Address",$adddress_show);
   }
   public function edit_address(Request $request){
      
      $validator = Validator::make($request->all(),[
         'name' => 'required',
         'mobile_no' => 'required|digits:10',
         'pincode' =>'required',
         'house_no'=>'required',
         'landmark' =>'required',
         'city' =>'required',
         'state'=>'required',
         ]);
         if($validator->fails()){
            return $this->validation_error_response($validator);
         }
         $address_data = $request->all();
         $user_id=auth('api')->user()->id;
         $update_address = AddressModel::where('id',$user_id)->update([
            'name'=>$address_data['name'],'mobile_no'=>$address_data['mobile_no'],'pincode'=>$address_data['pincode'],
            'house_no'=>$address_data['house_no'],'landmark'=>$address_data['landmark'],'city'=>$address_data['city'],
            'state'=>$address_data['state']
         ]);
         return ApiResponse::ok('Succesfully Address Edited');
   } 


   public function Image(Request $request){
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
            $image->move(public_path().'/files/', $name);  
            $data[] = $name;  
         }
      }
   $image_data = implode(",",$data);
   DB::table('multiple_images')->insert(['image'=>$image_data]);
   return ["success" =>"File Uplode Successfully"];
  }
}
