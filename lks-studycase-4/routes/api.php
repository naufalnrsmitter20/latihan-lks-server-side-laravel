<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\History\HistoryPeminjamanRuangController;
use App\Http\Controllers\History\HistoryPeminjamanSiswaController;
use App\Http\Controllers\List\LamaPenggunaanRuanganController;
use App\Http\Controllers\List\RuangSedangDipakaiController;
use App\Http\Controllers\List\RuangTersediaController;
use App\Http\Controllers\Peminjaman\AdminVerifikasiRuangController;
use App\Http\Controllers\Peminjaman\SiswaPinjamRuangController;
use App\Http\Controllers\RuangController;
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
Route::apiResource("/ruang", RuangController::class, [
    "ruang.index",
    "ruang.show",
    "ruang.store",
    "ruang.update",
    "ruang.destroy"
]);


Route::post("/siswa-pinjam-ruang", SiswaPinjamRuangController::class)->middleware(VerifyToken::class);
Route::post("/login", LoginController::class);
Route::post("/logout", LogoutController::class)->middleware(VerifyToken::class);
Route::put("/admin-verifikasi-ruang/{id}", AdminVerifikasiRuangController::class)->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/history-peminjaman-ruang", HistoryPeminjamanRuangController::class)->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/history-peminjaman-siswa", HistoryPeminjamanSiswaController::class)->middleware(VerifyToken::class);
Route::get("/ruangan-sedang-dipakai", RuangSedangDipakaiController::class)->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/ruang-tersedia", RuangTersediaController::class)->middleware([VerifyToken::class]);
Route::get("/lama-penggunaan", LamaPenggunaanRuanganController::class);
