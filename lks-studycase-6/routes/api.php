<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TelurController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Owner\ViewTransactionController;
use App\Http\Controllers\Owner\ViewIncomeEachDaysController;
use App\Http\Controllers\Cashier\ViewIncomeEachDayController;
use App\Http\Controllers\Owner\ViewEachQuantitySoldEggController;
use App\Http\Controllers\Transaction\AddToCartController;
use App\Http\Controllers\Transaction\AddTransactionController;
use App\Http\Middleware\AdminRoute;
use App\Http\Middleware\CashierRoute;
use App\Http\Middleware\VerifyToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/user", UserController::class, [
    "user.index",
    "user.store",
    "user.show",
    "user.update",
    "user.destroy",
]);
Route::apiResource("/telur", TelurController::class, [
    "telur.index",
    "telur.store",
    "telur.show",
    "telur.update",
    "telur.destroy",
])->middleware([VerifyToken::class, AdminRoute::class]);
Route::apiResource("/kemasan", KemasanController::class, [
    "kemasan.index",
    "kemasan.store",
    "kemasan.show",
    "kemasan.update",
    "kemasan.destroy",
])->middleware([VerifyToken::class, AdminRoute::class]);

Route::prefix("auth")->group(function () {
    Route::post("/login", LoginController::class);
    Route::post("/logout", LogoutController::class)->middleware(VerifyToken::class);
});

Route::prefix("owner")->group(function () {
    Route::get("/view-each-quantity-sold-egg", ViewEachQuantitySoldEggController::class)->middleware([VerifyToken::class, AdminRoute::class]);
    Route::get("/view-income-each-day", ViewIncomeEachDaysController::class)->middleware([VerifyToken::class, AdminRoute::class]);
    Route::get("/view-transaction", ViewTransactionController::class)->middleware([VerifyToken::class, AdminRoute::class]);
});
Route::prefix("cashier")->group(function () {
    Route::get("/view-income-each-day", ViewIncomeEachDayController::class)->middleware([VerifyToken::class, CashierRoute::class]);
});
Route::prefix("transaction")->group(function () {
    Route::post("/add-transaction", AddTransactionController::class);
    Route::post("/add-to-cart", AddToCartController::class);
});
