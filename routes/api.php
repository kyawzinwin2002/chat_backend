<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FriendRequestController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function () {

    //Guest
    Route::post("register", [RegisterController::class, "register"]);
    Route::post("login", [LoginController::class, "login"]);

    //User
    Route::middleware("auth:sanctum")->group(function(){

       Route::controller(ContactController::class)->group(function (){
            Route::get("/friend/{friend_id}/add","add");
            Route::get("/friend/{friend_id}/accept","accept");
            Route::get("/friend/list","friendList");
            Route::get("/strangers/index","strangers");
       });

    });
});

