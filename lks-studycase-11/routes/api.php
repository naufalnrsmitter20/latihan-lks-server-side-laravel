<?php

use App\Http\Controllers\Auth\LoginSociety;
use App\Http\Controllers\Auth\LoginUser;
use App\Http\Controllers\Auth\LogoutSociety;
use App\Http\Controllers\Auth\LogoutUser;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\SpotsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationsController;
use App\Http\Controllers\VaccineController;
use App\Http\Middleware\VerifySocietyToken;
use App\Http\Middleware\VerifyUserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("v1")->group(function () {
    Route::get("/user&society", [UserController::class,  "index"]);
    Route::post("/user", [UserController::class,  "storeUser"]);
    Route::post("/society", [UserController::class,  "storeSociety"]);
    Route::put("/user/{id}", [UserController::class,  "updateUser"]);
    Route::put("/society/{id}", [UserController::class,  "updateSociety"]);
    Route::delete("/user/{id}", [UserController::class,  "destroyUser"]);
    Route::delete("/society/{id}", [UserController::class,  "destroySociety"]);
    Route::prefix("auth")->group(function () {
        Route::post("/LoginUser", LoginUser::class);
        Route::post("/LoginSociety", LoginSociety::class);
        Route::post("/LogoutUser", LogoutUser::class)->middleware(VerifyUserToken::class);
        Route::post("/LogoutSociety", LogoutSociety::class)->middleware(VerifySocietyToken::class);
    });
    Route::prefix("regional")->group(function () {
        Route::get("/", [RegionalController::class,  "index"]);
        Route::post("/", [RegionalController::class,  "store"]);
        Route::delete("/{id}", [RegionalController::class,  "destroy"]);
    });
    Route::prefix("consultations")->group(function () {
        Route::get("/", [ConsultationsController::class,  "index"])->middleware(VerifySocietyToken::class);
        Route::post("/", [ConsultationsController::class,  "requestConsultation"])->middleware(VerifySocietyToken::class);
        Route::put("/{id}", [ConsultationsController::class,  "VerifyConsultation"]);
    });
    Route::prefix("vaccine")->group(function () {
        Route::get("/", [VaccineController::class,  "index"]);
        Route::post("/", [VaccineController::class,  "store"]);
    });
    Route::prefix("spots")->group(function () {
        Route::get("/", [SpotsController::class,  "index"])->middleware(VerifySocietyToken::class);
        Route::get("/all", [SpotsController::class,  "index"]);
        Route::post("/", [SpotsController::class,  "store"]);
        Route::get("/{id}", [SpotsController::class,  "show"])->middleware(VerifySocietyToken::class);
    });
    Route::prefix("vaccination")->group(function () {
        Route::get("/", [VaccinationsController::class,  "index"])->middleware(VerifySocietyToken::class);
        Route::post("/", [VaccinationsController::class,  "store"])->middleware(VerifySocietyToken::class);
        Route::put("/{id}", [VaccinationsController::class,  "verify"]);
    });
    Route::prefix("medical")->group(function () {
        Route::get("/", [MedicalController::class,  "index"]);
        Route::put("/{id}", [MedicalController::class,  "update"]);
    });
});
