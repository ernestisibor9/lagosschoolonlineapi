<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/generate-token', [OtpController::class,'GenerateToken']);

Route::group(["middleware"=>["auth:sanctum"]], function(){
	Route::post('/send-otp', [OtpController::class,'GenerateOtp']);
	Route::post('/verify-email', [OtpController::class,'VerifyEmail']);
});

Route::post('/send-email', [EmailController::class, 'SendEmail']);