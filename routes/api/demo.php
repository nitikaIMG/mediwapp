<?php

use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\DemoController;
use Illuminate\Support\Facades\Route;

Route::post('/tempuser',[AuthController::class,'tempuser']);
Route::post('/otpfetch',[AuthController::class,'otpfetch']);

