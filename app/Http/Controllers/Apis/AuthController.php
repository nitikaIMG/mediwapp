<?php

namespace App\Http\Controllers\Apis;
use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use App\Models\Tempuser;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\JWTGuard;
class AuthController extends Controller
{
    use ValidationTrait;
    public function tempuser(Request $request){
        if($request->isMethod('post')){
            $input=$request->all();
            $validator = Validator::make($request->all(), 
            [
                'name' => 'required|max:255',
                'email' => 'required',
                'mobile_number' => 'required',
                'password' => 'required',
                'confirm_password' => 'required',
            ],[
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'mobile.required' => 'The mobile field is required',
                'password.required' => 'The passsword field is required',
                'confirm_password.required' => 'The confirm password type field is required.',
            ]);

            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            try {
                DB::beginTransaction();

                $input = $request->except('_token','confirm_password');
                // $input['code'] = rand(0000,9999);
                $input['password'] = Hash::make($request->password);
                $input['code'] = $this->getOTP(1);
                $tempuser = Tempuser::create($input);
                $data['tempuser'] = serializeID($tempuser->id);
                $data['mobile_number'] = $tempuser->mobile_number;
                DB::commit();
                return ApiResponse::ok('Otp sent to mobile number,check and verify',$data);
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
            return ApiResponse::ok('user Created',[]);
        }
        
    }
    public function otpfetch(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'code' => 'required',
            ],[]);
        try{
            $tempid = unserializeID($request->tempuser);
                $validated = Tempuser::where('id',$tempid)->where('code',$request->code)->first();
                if($validated){
                    $user= UserModel::where('user_phonenumber', $validated->mobile_number)->first();

                    if(empty($user)){
                        $user = UserModel::create([
                            'user_phonenumber'     => $validated->mobile_number,
                            'status'  => 1,
                        ]); 
                        
                    }
                    // dd();
                    if(! $token = JWTAuth::fromUser($user)){
                        // return ApiResponse::unauthorized('Bad Credentials');
                        throw new \Exception('JWT could not generate token: 3309');
                    }
                    $user->auth_key = $token;
                    $user->code = NULL;
                    $user->save();
                        # Return Resonse with Token
                        return ApiResponse::ok(
                            'Registered Successfully & Logged In', 
                            [
                                'userdata'=>$user,
                                'token'=>$token
                            ]
                        );
                }else{
                    return ApiResponse::error(
                        'User already existing'
                    );
                }
                
        }catch (\Exception $e) {
            return $e->getMessage().' - '.$e->getFile().' - '.$e->getLine();
        }
    }
}
