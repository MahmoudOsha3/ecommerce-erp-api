<?php

use App\Http\Controllers\Dashboard\Authentication\ResetPasswordController;
use App\Http\Controllers\Dashboard\Authentication\ForgetPasswordController;
use App\Http\Controllers\Dashboard\Authentication\LoginController;
use App\Http\Controllers\Dashboard\Authentication\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function(){

    // Authentication
    Route::post('register' , [RegisterController::class , 'register']) ;
    Route::post('login' , [LoginController::class , 'login']) ;
    Route::post('forget-password' , [ForgetPasswordController::class , 'sendOtp']) ;
    Route::post('forget-password/verify-otp' , [ForgetPasswordController::class , 'verifyOtp']) ;
    Route::post('reset-password' , [ResetPasswordController::class , 'reset']) ;


});


