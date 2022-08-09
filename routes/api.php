<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\welcome;

use App\Http\Controllers\MainController;
use App\Http\Controllers\authController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('save',[MainController::class,'saveData']);
    Route::put('update',[MainController::class,'update']);
    Route::delete('delete{id}',[MainController::class,'delete']);
    Route::post('logout',[authController::class,'logout']);
    Route::post('send',[authController::class,'sendMail']);
    


});

Route::get('fetch',[MainController::class,'getData']);
Route::get('fetch{id}',[MainController::class,'getDataById']);

//create user
Route::post('register',[authController::class,'register']);
Route::post('login',[authController::class,'login'])->middleware('testAuth');
Route::get('message',[authController::class,'message']);

//send mail



