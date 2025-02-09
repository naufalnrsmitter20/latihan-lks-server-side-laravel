<?php

use Illuminate\Http\Request;
use App\Http\Middleware\VerifyToken;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ProtectedUser;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EskulController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Features\JumlahPesertaEskul;
use App\Http\Controllers\Features\DaftarEskulController;
use App\Http\Controllers\Features\EskulPesertaTerbanyak;
use App\Http\Controllers\Features\PindahEskulController;
use App\Http\Controllers\Features\TidakDaftarEskulController;
use App\Http\Controllers\TestingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/user", UserController::class, [
     "user.destroy", "user.index", "user.show", "user.store", "user.update"
]);
Route::apiResource("/eskul", EskulController::class, [
    "eskul.destroy", "eskul.index", "eskul.show", "eskul.store", "eskul.update"
])
->middleware([VerifyToken::class, ProtectedUser::class]);

Route::post("/register", RegisterController::class)->name("register");
Route::post("/login", LoginController::class)->name("login");
Route::post("/logout", LogoutController::class)->name("logout")
->middleware(VerifyToken::class);

Route::post("/daftar-eskul", DaftarEskulController::class)->name("daftar-eskul")
->middleware(VerifyToken::class);
Route::post("/pindah-eskul", PindahEskulController::class)->name("pindah-eskul")
->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/jumlah-peserta-eskul", JumlahPesertaEskul::class)->name("jumlah-peserta-eskul")
->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/eskul-peserta-terbanyak", EskulPesertaTerbanyak::class)->name("eskul-peserta-terbanyak")
->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/tidak-daftar-eskul", TidakDaftarEskulController::class)->name("tidak-daftar-eskul")
->middleware([VerifyToken::class, ProtectedUser::class]);
Route::get("/testing", TestingController::class)->name("testing");