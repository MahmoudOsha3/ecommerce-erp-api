<?php

use App\Http\Controllers\Dashboard\Authentication\{ResetPasswordController , LoginController , LogoutController , RegisterController ,ForgetPasswordController};
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function(){

    // Authentication
    Route::post('register' , [RegisterController::class , 'register']) ;
    Route::post('login' , [LoginController::class , 'login'])->middleware('throttle:admin-login') ;
    Route::post('forget-password' , [ForgetPasswordController::class , 'sendOtp']) ;
    Route::post('forget-password/verify-otp' , [ForgetPasswordController::class , 'verifyOtp']) ;
    Route::post('reset-password' , [ResetPasswordController::class , 'reset']) ;
    Route::post('logout' , [LogoutController::class , 'logout'])->middleware('auth:admin-api') ;




});


