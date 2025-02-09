<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameFileUpload;
use App\Http\Controllers\GetAllAdminData;
use App\Http\Controllers\ManageScores;
use App\Http\Controllers\ServeGameFile;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Middleware\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/v1/users", UserController::class);
// ->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::apiResource("/v1/games", GameController::class);
Route::get("/v1/admins", GetAllAdminData::class);
Route::post("/v1/auth/signup", Register::class);
Route::post("/v1/auth/signin", Login::class);
Route::post("/v1/auth/signout", Logout::class)->middleware([VerifyToken::class]);

Route::get("/v1/games/{slug}", [GameController::class, "show"]);
Route::post("/v1/games/{slug}/upload", GameFileUpload::class);

Route::get("/v1/games/{slug}/{version}", [ServeGameFile::class, "index"]);
Route::get("/v1/gamess/{slug}/scores", [ManageScores::class, "sorted"]);
Route::post("/v1/games/{slug}/scores", [ManageScores::class, "store"]);
