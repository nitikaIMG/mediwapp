<?php

use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\BannerController;
use App\Http\Controllers\Apis\CategoryController;
use App\Http\Controllers\Apis\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/tempuser',[AuthController::class,'tempuser']);
Route::post('/otpfetch',[AuthController::class,'otpfetch']);
Route::post('/userlogin',[AuthController::class,'userlogin']);
Route::post('/socialauthentication',[AuthController::class,'socialauthentication']);


Route::middleware('jwt.verify')->group(function() {
    Route::get('category',[CategoryController::class,'index']);
    Route::get('subcategory',[CategoryController::class,'index']);

    Route::get('discountedproduct',[ProductController::class,'discountedproduct']);
    Route::get('trendingproduct',[ProductController::class,'trendingproduct']);

    Route::get('banner',[BannerController::class,'banner']);

});
