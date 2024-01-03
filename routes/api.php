<?php

use App\Http\Controllers\Auth\EmailVerifyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RequestController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RequestContext;

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

        Route::get("/user", function (Request $request) {
            return $request->user();
        });

        Route::get("logout",[LogoutController::class,"logout"]);

        Route::post('change-password',[ChangePasswordController::class,"change"]);

        Route::controller(ContactController::class)->group(function () {
            Route::get("friend/{friend_id}/add", "add");
            Route::get("friend/{friend_id}/accept", "accept");
            Route::get("friend/{id}/unfriend","unfriend");
            Route::get("friend/list", "friendList");
            Route::get("strangers/list","strangers");
        });

        Route::controller(RequestController::class)->group(function(){
            Route::get("requests","requests");
            Route::get("requests/sent","sentRequests");
            Route::delete("request/{id}/delete","delete");
        });

        Route::controller(ChatController::class)->group(function () {
            Route::post("message/send", "send");
        });

        Route::controller(ConversationController::class)->group(function() {
            Route::get("conversations/index","get");
            Route::get("conversation/{id}/show","show");
            Route::delete("conversation/{id}/delete","delete");
        });

        Route::middleware("signed")->get("email/verify/{id}/{hash}",[EmailVerifyController::class,"verify"])->name("verification.verify");

    });
});
