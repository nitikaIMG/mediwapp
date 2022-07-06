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
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\JWTGuard;
use App\Models\AndroidAppId;

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
                // $data['tempuser2'] = $tempuser->id;
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
                'mobile_number'=>'required',
            ],[]);
        try{
            if($request->has('tempuser') && $request->tempuser){
                $tempid = unserializeID($request->tempuser);
                $validated = Tempuser::where('id',$tempid)->where('code',$request->code)->first();
                if($validated){
                    $user= UserModel::where('user_phonenumber', $validated->mobile_number)->first();

                    if(empty($user)){
                        $user = UserModel::create([
                            'user_phonenumber'      => $validated->mobile_number,
                            'user_firstname'        => $validated->name,
                            'user_email'            => $validated->email,
                            'user_password'         => $validated->password,
                            'status'  => 1,
                        ]); 
                        
                    }
                    // dd();
                    if(! $token = JWTAuth::fromUser($user)){
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
            }else{
                $user=UserModel::where('user_phonenumber',$request->mobile_number)->where('code',$request->code)->first();
                if($user){

                    DB::beginTransaction();
                    if(! $token = JWTAuth::fromUser($user)){
                        throw new \Exception('JWT could not generate token: 3309');
                    }
                    $user->auth_key = $token;
                    $user->code = NULL;
                    $user->save();
                    DB::commit();
                        # Return Resonse with Token
                    return ApiResponse::ok(
                        'Logged In Successfully', 
                        [
                            'userdata'=>$user,
                            'token'=>$token
                        ]
                    );
                }else{
                    return ApiResponse::error(
                        'Invalid User'
                    );
                }
            }
            
                
        }catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage().' - '.$e->getFile().' - '.$e->getLine();
        }
    }
    public function userlogin(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'mobile_number' => ['required','digits:10','exists:user,user_phonenumber'],
            ],[
                'mobile_number.exists' =>'This mobile number is not Exists..',
            ]);
        if($validator->fails()){
            return $this->validation_error_response($validator);
        }
        try{
            $validate=UserModel::where('user_phonenumber',$request->mobile_number)->first();
            if($validate){
                DB::beginTransaction();
                $code = $this->getOTP(1);
                UserModel::where('user_phonenumber',$request->mobile_number)->update(['code'=>$code]);

                $json['tempuser'] = '';
                $json['mobile_number'] = $request->mobile_number;

                DB::commit();
                return ApiResponse::ok('Otp sent to mobile number',$json);
            }else{
                return ApiResponse::error(
                    'Invalid User'
                );
            }
        }catch (\Exception $e) {
            return $e->getMessage().' - '.$e->getFile().' - '.$e->getLine();
        }
        
    }

    public function socialauthentication(Request $request){
        if($request->isMethod('post')){
            $email=$request->get('email');
            if(empty($email)){
                return ApiResponse::error(
                    'Email is required'
                );
            }else{
                if ($request->get('image')) {
                    if ($request->get('image') != "") {
                        $image = $request->get('image');
                    }
                }
                $newmailaddress=$this->getnewmail($email);
                $findlogin = UserModel::where(function ($q) use ($newmailaddress, $email) {
                    $q->where('user_email', $newmailaddress)->orWhere('user_email', $email);
                })->first();
                if(!empty($findlogin)){
                    $user_status=UserModel::where('id',$findlogin->id)->first();
                    if($user_status->status=='1'){
                        LOG::info($request->get('appid'));
                        if($request->get('appid')){
                            AndroidAppID::where('user_id',$findlogin->id)->delete();
                            $this->insertAppId($findlogin, $request->get('appid'));
                        }
                        $user=UserModel::where('user_email',$request->user_email)->first();
                        
                            DB::beginTransaction();
                            if(! $token = JWTAuth::fromUser($user)){
                                throw new \Exception('JWT could not generate token: 3309');
                            }
                            $user->auth_key = $token;
                            $user->code = NULL;
                            $user->update();
                            DB::commit();
                                # Return Resonse with Token
                                // dd($user);
                                $userattr = collect($user->attributesToArray())->map(function($item, $key) use($token){
                                    return (!empty($item))?$item:'';
                                        
                                });
                            return ApiResponse::ok(
                                'Logged In Successfully', 
                                [
                                    'userdata'=>$userattr,
                                    'token'=>$token
                                ]
                            );
                    }else{
                        return ApiResponse::error(
                            'You cannot login now in this account. Please contact to administartor.', 
                        );
                    }
                }else{
                    $ff = UserModel::where('user_email', $request->get('email'))->first();
                    if (empty($ff)) {
                        $user = UserModel::create([
                        'user_email'            => $newmailaddress,
                        'user_image'            => $request->get('image'),
                        'social_login'            => '1',
                        'status'  => 1,
                        ]);
                        if(! $token = JWTAuth::fromUser($user)){
                            throw new \Exception('JWT could not generate token: 3309');
                        }
                        if ($request->get('appid')) {
                            $findlogin = UserModel::where('id', $user->id)->first(['id']);
                            $this->insertAppId($findlogin, $request->get('appid'));
                        }
                        $inserteddata = UserModel::where('id', $user->id)->first();
                        $modified = collect($inserteddata->attributesToArray())->map(function($item, $key) use($token){
                            if($key==='auth_key'){
                                return $token;
                            }else{
                                return ($item)?$item:'';
                            }
                         });
                    }
                    return ApiResponse::ok(
                        'Logged In Successfully', 
                        [
                            'userdata'=>$modified,
                            'token'=>$token
                        ]
                    );
                }
            }
        }else{
            return ApiResponse::error(
                'Unauthorise Request'
            );
        }
    }

    public function insertAppId($findlogin, $appid)
    {
        $appdata['user_id'] = $findlogin->id;
        $appdata['appkey'] = $appid;
        $findexist = DB::table('androidappid')->where('user_id', $findlogin->id)->where('appkey', $appid)->first();
        if (empty($findexist)) {
            DB::connection('mysql2')->table('androidappid')->insert($appdata);
        }
    }
}
