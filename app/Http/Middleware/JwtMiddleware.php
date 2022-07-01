<?php

namespace App\Http\Middleware;

use Closure;
use App\Api\ApiResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    
    public function handle($request, Closure $next)
    {
        $_error = '';
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            $_error = 'Token Is Invalid';
        } catch(TokenExpiredException $e) {
            $_error = 'Token Expired';
        } catch(\Exception $e) {
            $_error = 'Token Not Found';
        }

        if( $_error !== '' ) {
            return ApiResponse::unauthorized($_error);
        }

        return $next($request);
    }
}
