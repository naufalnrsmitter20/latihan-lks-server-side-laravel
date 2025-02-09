<?php

use App\Http\Middleware\TeacherAccess;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminAccess;
use App\Http\Middleware\VerifyToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\RequestPrakerinPlace;
use App\Http\Controllers\AddMaxPeriodController;
use App\Http\Controllers\AddPrakerinPeriodController;
use App\Http\Controllers\DataIndustryController;
use App\Http\Controllers\GetMaxPeriodController;
use App\Http\Controllers\AddYearPeriodController;
use App\Http\Controllers\DataSiswaBelumMengajukan;
use App\Http\Controllers\UpdateMaxPeriodController;
use App\Http\Controllers\RiwayatPengajuanController;
use App\Http\Controllers\UpdateYearPeriodController;
use App\Http\Controllers\JumlahSiswaByStatusController;
use App\Http\Controllers\ManageTeacherAtIndustryController;
use App\Http\Controllers\ShowIndustryWithStudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/user", UserController::class, [
    "user.index", "user.show", "user.store", "user.update", "user.destroy"
]);

Route::apiResource("/industry", IndustryController::class, [
    "industry.index", "industry.show", "industry.store", "industry.update", "industry.destroy"
])->middleware([VerifyToken::class, AdminAccess::class]);

Route::post("/auth/login", LoginController::class)->name("login");
Route::post("/auth/logout", LogoutController::class)->name("logout")->middleware(VerifyToken::class);
Route::post("/add-prakerin-period", AddPrakerinPeriodController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::post("/add-year-period", AddYearPeriodController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::get("/period", GetMaxPeriodController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::put("/update-year-period/{id}", UpdateYearPeriodController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::post("/request-prakerin", RequestPrakerinPlace::class)->middleware([VerifyToken::class]);
Route::get("/riwayat-pengajuan", RiwayatPengajuanController::class)->middleware([VerifyToken::class]);
Route::get("/data-industy", DataIndustryController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::get("/data-siswa-belum-mengajukan", DataSiswaBelumMengajukan::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::get("/jumlah-siswa-by-status", JumlahSiswaByStatusController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::post("/manage-teacher-at-industry", ManageTeacherAtIndustryController::class)->middleware([VerifyToken::class, AdminAccess::class]);
Route::get("/show-industry-with-student", ShowIndustryWithStudentController::class)->middleware([VerifyToken::class, TeacherAccess::class]);