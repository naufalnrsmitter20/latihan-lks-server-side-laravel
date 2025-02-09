<?php

use App\Http\Controllers\Admin\manageRoomController;
use App\Http\Controllers\Admin\ReportofReservationController;
use App\Http\Controllers\Admin\verifyCustomerController;
use App\Http\Controllers\Admin\viewUsedRoomNumberController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\ReserveMultipleRoomController;
use App\Http\Controllers\Customer\ViewAvailableRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ProtectedUser;
use App\Http\Middleware\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/user", UserController::class, [
    "user.index",
    "user.show",
    "user.store",
    "user.update",
    "user.destroy"
]);
Route::apiResource("/room", RoomController::class, [
    "room.index",
    "room.show",
    "room.store",
    "room.update",
    "room.destroy"
])->middleware([VerifyToken::class, ProtectedUser::class]);
Route::apiResource("/category", CategoryController::class, [
    "category.index",
    "category.show",
    "category.store",
    "category.update",
    "category.destroy"
])->middleware([VerifyToken::class, ProtectedUser::class]);

Route::post("/login", LoginController::class);
Route::post("/logout", LogoutController::class)->middleware([VerifyToken::class]);

Route::put("/admin/verify-customer", verifyCustomerController::class)->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/admin/view-used-room-number", viewUsedRoomNumberController::class)->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/admin/report-reservation", ReportofReservationController::class)->middleware([VerifyToken::class, ProtectedUser::class]);

Route::get("/customer/view-available-room", ViewAvailableRoomController::class)->middleware([VerifyToken::class]);;
Route::post("/customer/reserve-multiple-room", ReserveMultipleRoomController::class)->middleware(VerifyToken::class);
