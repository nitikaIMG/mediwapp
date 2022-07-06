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
      $input['user_image'] = ($user_data->user_image != null)?asset('public/user_image').'/'.$user_data->user_image:"";
      $input['user_firstname'] = ($user_data->user_firstname!= null)?$user_data->user_firstname:"";
      $input['user_lastname'] = ($user_data->user_lastname!=null)?$user_data->user_lastname:"";
      $input['user_email'] = ($user_data->user_email!=null)?$user_data->user_email:"";
      $input['user_phonenumber'] = ($user_data->user_phonenumber!=null)?$user_data->user_phonenumber:"";
      $input['dob'] = ($user_data->dob!=null)?$user_data->dob:"";
      $input['gender'] = ($user_data->gender!=null)?$user_data->gender:"";
      $input['user_adress'] = ($user_data->user_adress!=null)?$user_data->user_adress:"";
      $input['status'] = ($user_data->status==1)?'Active':'Deactive';
      dd($input);
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
      return ApiResponse::ok("Address Added",$data);
   }

   public function  show_address(Request $request){
      $adddress_show =AddressModel::all();
      return ApiResponse::ok("User Address",$adddress_show);
   }
   public function edit_address(Request $request){
      if($request->isMethod('post')){
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
         }else{
            return ApiResponse::error('Unauthorise User');
         }
     
   } 

   public function edit_userprofile(Request $request){
      if($request->isMethod('post')){
      $validator = Validator::make($request->all(),[
          'user_firstname' => 'required',
          'user_phonenumber' => 'required|digits:10',
          'user_address' =>'required',
          'dob'=>'required',
          'gender' =>'required',
          'user_image' =>'required',
          'user_email'=>'required|email',
          ]);
          if($validator->fails()){
            return $this->validation_error_response($validator);
         }

          $user_data = $request->all();
          
          if($request->hasfile('user_image')){
           $image = $request->file('user_image');
           $name = $image->getClientOriginalName();
           $image->move('/user_image/', $name);
           $user_data['user_image'] = $name;
          }
         
          $user_id=auth('api')->user()->id;
          $user_data = UserModel::where('id',$user_id)->update($user_data);

          return ApiResponse::ok('Succesfully Edit Profile');
      }
      else{
         return ApiResponse::error('Unauthorise User');
      }
  }

}

  
