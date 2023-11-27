<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PriceAlertController;
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
	Route::get('/delete-otp', [OtpController::class,'DeleteOtp']);
});

// Price Alert
Route::group(["middleware"=>["auth:sanctum"]], function(){
	Route::post('/create-price-alert', [PriceAlertController::class,'CreatePriceAlert']);
	Route::get('/price-alert', [PriceAlertController::class,'PriceAlert']);
	Route::get('/stocks', [PriceAlertController::class,'GetAllStock']);
	Route::get('/stocks/{id}', [PriceAlertController::class,'GetSingleStock']);
	Route::get('/edit-price-alert/{id}', [PriceAlertController::class,'EditPriceAlert']);
	Route::post('/update-price-alert/{id}', [PriceAlertController::class,'UpdatePriceAlert']);
	Route::get('/delete-price-alert/{id}', [PriceAlertController::class, 'DeletePriceAlert']);
});

// Market News
Route::group(["middleware"=>["auth:sanctum"]], function(){
	Route::get('/market-news', [NewsController::class,'MarketNews']);
	Route::get('/market-news/{id}', [NewsController::class,'SingleMarketNews']);
});

Route::post('/send-email', [EmailController::class, 'SendEmail']);