<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\AddressModel;
use App\Models\UserFeedbackModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ValidationTrait;
use Svg\Tag\Rect;

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
         $input['dob'] = ($user_data->dob != null)?$user_data->dob:"";
         $input['gender'] = ($user_data->gender!=null)?$user_data->gender:"";
         $input['user_adress'] = !empty($user_data->user_address)?$user_data->user_address:"";
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
      'address_type'=>'required',
      'landmark' =>'required',
      'city' =>'required',
      'state'=>'required',
      ]);

      if($validator->fails()){
         return $this->validation_error_response($validator);
      }
      $user_id=auth('api')->user()->id;
      $address_data = $request->all();
      $address_data['user_id'] = $user_id;
      $data = AddressModel::create($address_data); 
      return ApiResponse::ok("Address Added",$data);
   }

   public function  show_address(Request $request){
      $user_id=auth('api')->user()->id;
      $adddress_show =AddressModel::where('user_id',$user_id)->get();
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
            $after_edit=UserModel::where('id',$user_id)->first();
            return ApiResponse::ok('Succesfully Address Edited',[$after_edit]);
         }else{
            return ApiResponse::error('Unauthorise User');
         }
     
   } 
   public function delete_address(Request $request){
      if($request->isMethod('post')){
         $validator = Validator::make($request->all(),[
            'id' => 'required',
            ]);
            if($validator->fails()){
               return $this->validation_error_response($validator);
            }
            $user_id=auth('api')->user()->id;
            AddressModel::where('id',$request->id)->where('user_id',$user_id)->delete();
         return ApiResponse::ok("Address Deleted");
      }else{
         return ApiResponse::error("Unauthorise Request");
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

     public function get_user_feedback(Request $request){
         $user_feedback = UserFeedbackModel::all();
         $user = UserModel::join('user_feedback','user_feedback.user_id','user.id',)->select('user.user_image','user.user_firstname','user_feedback.user_feedback')->get();
         // dd($user);
         $dataa=[];
         foreach($user as $user_data){
             $data['user_firstname']=$user_data['user_firstname'];
             $data['user_feedback']=$user_data['user_feedback'];
             $data['user_image']=($user_data->user_image != Null)?asset('public/product_image').'/'.$user_data->user_image:"";
             $dataa[] = $data;
         }
         return ApiResponse::ok("User FeedBack",$dataa);
      }

      public  function add_user_feedback(Request $request){
         if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'user_id' => 'required',
                'user_feedback' => 'required',
                ]);
            if($validator->fails()){
               return $this->validation_error_response($validator);
            }
               $add_user_feedback = $request->all();
               $data = UserFeedbackModel::create($add_user_feedback); 
               return ApiResponse::ok("Add User Feedback",$data);
            }
           
      }

      public  function update_profile(Request $request){
         if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'user_image' => 'required',
                ]);
            if($validator->fails()){
               return $this->validation_error_response($validator);
            }
            if($request->hasfile('user_image')){
               $image = $request->file('user_image');
               $name = $image->getClientOriginalName();
               $image->move('/user_image/', $name);
               $user_image = $name;
              }
               $user_id=auth('api')->user()->id;
               $data = UserModel::where('id',$user_id)->update(['user_image'=>$user_image]);
               return ApiResponse::ok("Update User Profile",$data);
            }
           
      }

   
}



  
