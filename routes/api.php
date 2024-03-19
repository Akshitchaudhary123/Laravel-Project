<?php

use App\Http\Controllers\UserDetailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
        // "php": "^7.3|^8.0|^8.1|^8.2",
// public routes
Route::post('/register',[UserController::class,'register']);
Route::get('/test',[UserController::class,'test']);
Route::post('/login',[UserController::class,'login']);
Route::post('/password-reset',[PasswordResetController::class,'passwordReset']);
Route::post('/reset-password/{token}',[PasswordResetController::class,'ResetPassword']);
Route::post('/reset/by-otp',[PasswordResetController::class,'resetPasswordByOtp']);
Route::post('/otp',[PasswordResetController::class,'getOtp']);
Route::post('/open-ai',[UserController::class,'OpenAI']);
// private routes
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[UserController::class,'logout']);
    Route::post('/details',[UserController::class,'UserDetails']);
});
