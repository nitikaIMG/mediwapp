<?php

namespace App\Http\Controllers\Apis;
use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        return ApiResponse::ok('test',[]);
    }
}
