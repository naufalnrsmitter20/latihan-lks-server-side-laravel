<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Middleware\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/v1/user", UserController::class, [
    "user.index",
    "user.store",
    "user.show",
    "user.update",
    "user.destoy",
]);
Route::prefix("v1")->group(function () {
    Route::get("/place", [PlaceController::class, "index"])->name("index")->middleware(VerifyToken::class);
    Route::get("/place/{id}", [PlaceController::class, "show"])->name("show")->middleware(VerifyToken::class);
})->middleware(VerifyToken::class);

Route::prefix("v1")->group(function () {
    Route::post("/place", [PlaceController::class, "store"])->name("store")->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::put("/place/{id}", [PlaceController::class, "update"])->name("update")->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::delete("/place/{id}", [PlaceController::class, "destroy"])->name("destroy")->middleware([VerifyToken::class, VerifyAdmin::class]);
})->middleware([VerifyToken::class, VerifyAdmin::class]);

Route::prefix("v1")->group(function () {
    Route::get("/schedule", [ScheduleController::class, "index"])->name("index")->middleware(VerifyToken::class);
})->middleware(VerifyToken::class);
Route::prefix("v1")->group(function () {
    Route::post("/schedule", [ScheduleController::class, "store"])->name("store")->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::delete("/schedule/{id}", [ScheduleController::class, "destroy"])->name("destroy")->middleware([VerifyToken::class, VerifyAdmin::class]);
})->middleware([VerifyToken::class, VerifyAdmin::class]);

Route::apiResource("/v1/route", RouteController::class, [
    "route.index",
    "route.store",
])->middleware(VerifyToken::class);

Route::prefix("v1")->group(function () {
    Route::post("/auth/login", Login::class);
    Route::get("/auth/logout", Logout::class)->middleware(VerifyToken::class);
});
