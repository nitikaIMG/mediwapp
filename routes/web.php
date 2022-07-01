<?php

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\SalesReport;
use Illuminate\Support\Facades\Auth;

Route::any('/', function () {
    return redirect()->route('login');
});
Route::any('/register',function(){
    return redirect('/login');
});
Auth::routes(['register'=>false]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){


// Category Routes
Route::resource('category',CategoryController::class);
Route::post('display_category',[CategoryController::class,'display_category'])->name('display_cat');
Route::get('enable_disable_category/{id}',[CategoryController::class,'enable_disable_category'])->name('enable_disable_category');
Route::get('delete_all',[CategoryController::class,'delete_all'])->name('delete_all');
Route::get('create_pdf_category',[CategoryController::class,'create_pdf_category']);
Route::get('create_csv_category',[CategoryController::class,'create_csv_category']);

//Brand Routes
Route::resource('brand',BrandController::class);
Route::post('display_brand',[BrandController::class,'display_brand'])->name('display_brand');
Route::get('enable_disable_brand/{id}',[BrandController::class,'enable_disable_brand'])->name('enable_disable_brand');
Route::get('brand_multiple_delete',[BrandController::class,'brand_multiple_delete'])->name('brand_multiple_delete');
Route::get('create_pdf_brand',[BrandController::class,'create_pdf_brand']);
Route::get('create_csv_brand',[BrandController::class,'create_csv_brand']);

//Subcategory Route
Route::resource('subcategory',SubcategoryController::class);
Route::post('display_subcategory',[SubcategoryController::class,'display_subcategory'])->name('display_subcategory');
Route::get('enable_dispbale_subcat/{id}',[SubcategoryController::class,'enable_dispbale_subcat'])->name('enable_dispbale_subcat');
Route::get('multiple_delete',[SubcategoryController::class,'multiple_delete'])->name('multiple_delete');
Route::get('create_pdf_subcategory',[SubcategoryController::class,'create_pdf_subcategory']);
Route::get('create_csv_subcategory',[SubcategoryController::class,'create_csv_subcategory']);

//product route
Route::resource('product',ProductController::class);
Route::post('display_product',[ProductController::class,'display_product'])->name('display_product');
Route::get('enable_disable_product/{id}',[ProductController::class,'enable_disable_product'])->name('enable_disable_product');
Route::get('multiple_delete_product',[ProductController::class,'multiple_delete_product'])->name('multiple_delete_product');
Route::get('create_pdf_product',[ProductController::class,'create_pdf_product']);
Route::get('create_csv_product',[ProductController::class,'create_csv_product']);
Route::post('get_subcat',[ProductController::class,'get_subcat'])->name('get_subcat');
Route::get('delete_multiple_image/{key}/{id}', [ProductController::class, 'deletemulimg']);

//Slider Route
Route::resource('slider',SliderController::class);
Route::post('display_sldier',[SliderController::class,'display_sldier'])->name('display_sldier');
Route::get('enable_dispbale_slider/{id}',[SliderController::class,'enable_dispbale_slider'])->name('enable_dispbale_slider');
Route::get('multiple_delete_slider',[SliderController::class,'multiple_delete_slider'])->name('multiple_delete_slider');
Route::get('create_pdf_slider',[SliderController::class,'create_pdf_slider']);
Route::get('create_csv_slider',[SliderController::class,'create_csv_slider']);

//user Route
Route::resource('user',UserController::class);
Route::post('display_user',[UserController::class,'display_user'])->name('display_user');
Route::post('enable_dispbale_user',[UserController::class,'enable_dispbale_user'])->name('enable_dispbale_user');
Route::get('user_order_detail/{id}',[UserController::class,'user_order_detail'])->name('user_order_detail');
Route::get('multiple_delete_user',[UserController::class,'multiple_delete_user'])->name('multiple_delete_user');
Route::get('create_order/{id}',[UserController::class,'create_order']);
Route::get('create_pdf_user',[UserController::class,'create_pdf_user']);
Route::get('create_csv_user',[UserController::class,'create_csv_user']);

//Order Route
Route::resource('order',OrderController::class);
Route::post('display_order',[OrderController::class,'display_order'])->name('display_order');
Route::post('enable_disable_order',[UserController::class,'enable_disable_order'])->name('enable_disable_order');
Route::get('/status_update/{val}/{id}',[OrderController::class,'status_update']);
Route::get('create_pdf_order',[OrderController::class,'create_pdf_order']);
Route::get('create_csv_order',[OrderController::class,'create_csv_order']);

//Product Stock
Route::resource('productstock',ProductStockController::class);
Route::post('display_product_quantity',[ProductStockController::class,'display_product_quantity'])->name('display_product_quantity');
Route::get('enable_disable_productstock/{id}',[ProductStockController::class,'enable_disable_productstock']);
Route::get('create_pdf_productstock',[ProductStockController::class,'create_pdf_productstock']);
Route::get('create_csv_productstock',[ProductStockController::class,'create_csv_productstock']);

//Sales Report
Route::resource('salesreport',SalesReport::class);
Route::post('display_usersalesreport',[SalesReport::class,'display_usersalesreport'])->name('display_usersalesreport');
Route::post('display_productsalesreport',[SalesReport::class,'display_productsalesreport'])->name('display_productsalesreport');


//banner
Route::resource('banner',BannerController::class);
});
