<?php
namespace App\Traits;

use App\Api\ApiResponse;
use Illuminate\Validation\Validator;

trait ValidationTrait{

    protected function validation_error_response(Validator $validator,$param2=2)
    {
        $_errors = $validator->errors()->messages();

        $first_error = array_values($_errors);

        if( !empty($first_error) && isset($first_error[0]) ) {
            if( isset($first_error[0][0]) ) {
                $first_error = $first_error[0][0];
            }
        }

        if( empty($first_error) ) {
            $first_error = __('Invalid data');
        }
        if($param2==1){
            return ApiResponse::validation(
                $first_error, (object)[]
            );
        }else{
            return ApiResponse::validation(
                $first_error
            );
        }
        
    }

    private function getOTP($status=0){
        if($status){
            return 1234;
        }else{
            return rand(0000,9999);
        }
    }
}
