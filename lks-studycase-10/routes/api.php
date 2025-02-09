<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\CreateVote;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Middleware\VerifyToken;
use App\Http\Controllers\Auth\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagePartai;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\VotingActions;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFillBiodata;
use App\Http\Controllers\ManageCandidates;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KotaProvinsiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("/v1/users", UserController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::apiResource("/v1/kota", KotaController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::apiResource("/v1/provinsi", ProvinsiController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::put('/v1/prov/insert/{id}', [KotaProvinsiController::class, "insert"])->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::get('/v1/prov/insert/{id}', [KotaProvinsiController::class, "show"])->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::post("/v1/auth/register", Register::class);
Route::post("/v1/auth/login", Login::class);
Route::post("/v1/auth/logout", Logout::class);
// biodata
Route::get("/v1/user/biodata", [UserFillBiodata::class, "index"])->middleware([VerifyToken::class]);
Route::put("/v1/user/biodata/{id}", [UserFillBiodata::class, "fill"])->middleware([VerifyToken::class]);


Route::get("/v1/candidates", [ManageCandidates::class, "index"]);
Route::post("/v1/candidates", [ManageCandidates::class, "store"]);
Route::delete("/v1/candidates/{id}", [ManageCandidates::class, "destroy"]);
Route::get("/v1/partai", [ManagePartai::class, "index"]);
Route::get("/v1/partai/{id}", [ManagePartai::class, "show"]);
Route::post("/v1/partai", [ManagePartai::class, "store"]);
Route::delete("/v1/partai/{id}", [ManagePartai::class, "destroy"]);
Route::put("/v1/partai/insert/{id}", [ManagePartai::class, "update"]);
Route::put("/v1/vote/pilpres", [VotingActions::class, "store"]);
Route::post("/v1/vote/create", [CreateVote::class, "store"]);
Route::post("/v1/vote/insert", [CreateVote::class, "insert_voteType"]);
Route::get("/v1/vote/list", [CreateVote::class, "index"]);
Route::get("/v1/vote/type", [CreateVote::class, "get_type"]);
Route::put("/v1/vote/activate/{id}", [CreateVote::class, "activate"]);
Route::put("/v1/vote/upsert_candidates/{id}", [CreateVote::class, "upsert_candidates"]);
Route::put("/v1/vote/upsert_partai/{id}", [CreateVote::class, "upsert_partai"]);
Route::delete("/v1/vote/delete/{id}", [CreateVote::class, "destroy"]);


// voting
Route::get("/v1/voting/{id}", [VotingActions::class, "index"]);
Route::put("/v1/voting/{id}", [VotingActions::class, "voting"])->middleware(VerifyToken::class);
