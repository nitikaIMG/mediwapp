<?php

use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\BannerController;
use App\Http\Controllers\Apis\CategoryController;
use App\Http\Controllers\Apis\ProductController;
use App\Http\Controllers\Apis\UserController;
use App\Http\Controllers\Apis\CartController;
use App\Http\Controllers\Apis\HealthGoalController;
use App\Http\Controllers\Apis\OrderController;
use App\Http\Controllers\Apis\PrescriptionController;
use App\Models\PrescriptionModel;
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
    Route::get('bestseller',[ProductController::class,'bestseller']);
    Route::post('add_wishlist_prod',[ProductController::class,'add_wishlist_prod']);
    Route::get('show_wishlist',[ProductController::class,'show_wishlist']);
    Route::post('single_product',[ProductController::class,'single_product']);

    Route::post('addcart',[CartController::class,'addcart']);
    Route::get('showcart',[CartController::class,'showcart']);
    Route::get('userprofile',[UserController::class,'userprofile']);
    Route::get('healthgoals',[HealthGoalController::class,'healthgoal']);

    Route::get('banner',[BannerController::class,'banner']);
    Route::get('myorders',[OrderController::class,'myorders']);

    Route::post('prescriptionupload',[PrescriptionController::class,'prescriptionupload']);
    
    
    Route::post('add_address',[UserController::class,'add_address']);
    Route::get('show_address',[UserController::class,'show_address']);
    Route::post('edit_address',[UserController::class,'edit_address']);
    Route::get('delete_address',[UserController::class,'delete_address']);
    Route::post('edit_userprofile',[UserController::class,'edit_userprofile']);
    Route::get('get_user_feedback',[UserController::class,'get_user_feedback']);
    Route::post('add_user_feedback',[UserController::class,'add_user_feedback']);

    Route::post('add_item', [CartController::class,'add_item']);
    Route::post('remove_item', [CartController::class,'remove_item']);
    Route::any('categoryproduct', [ProductController::class,'categoryproduct']);
});
