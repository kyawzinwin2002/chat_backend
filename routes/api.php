<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
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
    Route::controller(ResetPasswordController::class)->group(function(){
        Route::post("checkEmail","check");
        Route::post("resetPassword","reset")->name("password.reset");
    });

    //User
    Route::middleware("auth:sanctum")->group(function () {

        Route::post('change-password',[ChangePasswordController::class,"change"]);

        Route::controller(ContactController::class)->group(function () {
            Route::get("friend/{friend_id}/add", "add");
            Route::get("friend/{friend_id}/accept", "accept");
            Route::get("friend/list", "friendList");
        });

        Route::controller(ChatController::class)->group(function () {
            Route::post("message/send", "send");
        });
    });
});
