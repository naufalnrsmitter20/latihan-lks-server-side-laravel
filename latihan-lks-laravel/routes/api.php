<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWithPostController;
use App\Http\Middleware\TokenVerify;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/user", UserController::class, [
        "user.index", "user.show", "user.store", "user.update", "user.destroy"
]);

Route::apiResource("/userwithpost", UserWithPostController::class, [
        "post.index", "post.show", "post.store", "post.update", "post.destroy"
]);
Route::apiResource("/post", PostController::class, [
        "post.index", "post.show", "post.store", "post.update", "post.destroy"
]);

Route::post("register", RegisterController::class);
Route::post("login", LoginController::class);
Route::post("logout", LogoutController::class)->middleware(TokenVerify::class);