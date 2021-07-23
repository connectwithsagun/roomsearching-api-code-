<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PropertyDetailController;
use App\Http\Controllers\PropetyAminitiController;
use App\Http\Controllers\ForgetPasswordController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::post('profile',[UserProfileController::class,'uploadFile']);
    Route::post('add/property/aminities',[PropetyAminitiController::class,'addAminites']);
});


//user login and register
Route::post("login",[UserController::class,'login']);
Route::post("register",[UserController::class,'register']);
Route::post('verifyotp',[UserController::class,'verifyOtp']);

//reset password
Route::post('forgetpassword',[\App\Http\Controllers\ForgetPasswordController::class,'forgetpassword']);
Route::post('resetpassword',[\App\Http\Controllers\ForgetPasswordController::class,'resetpassword']);

//basic details of user
Route::get('register/userlist',[UserController::class,'registerUser']);
Route::get('verified/userlist',[UserController::class,'verifiedUser']);
Route::get('nonverified/userlist',[UserController::class,'nonVerifiedUser']);
Route::get('user/detail/{id}',[UserController::class,'userDetail']);
Route::delete('user/delete/{id}',[UserController::class,'destroy']);

//profile details of user
Route::get('user/profile/detail/list',[UserProfileController::class,'userProfile']);
Route::get('user/profile/detail/{name}',[UserProfileController::class,'profileDetail']);
Route::get('user/profile/detailid/{id}',[UserProfileController::class,'profileDetailId']);
Route::post('searchuser',[UserProfileController::class,'username']);
Route::delete('user/profile/delete/{id}',[UserProfileController::class,'destroy']);

//property details
Route::get('property/detail/list',[PropertyDetailController::class,'propertyDetail']);
Route::get('property/detail/{name}',[PropertyDetailController::class,'Details']);
Route::delete('property/delete/{id}',[PropertyDetailController::class,'destroy']);
Route::get('property/{location}',[PropertyDetailController::class,'location']);
Route::post('searchproperty',[PropertyDetailController::class,'search']);
Route::post('add/property',[PropertyDetailController::class,'addproperty']);



//property animities
Route::get('property/aminities/detail/list',[PropetyAminitiController::class,'showAminiti']);
Route::delete('property/aminities/delete/{id}',[PropetyAminitiController::class,'destroy']);

