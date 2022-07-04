<?php

namespace App\Http\Controllers\Apis;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\Models\UserModel;

class UserController extends Controller
{
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
}
