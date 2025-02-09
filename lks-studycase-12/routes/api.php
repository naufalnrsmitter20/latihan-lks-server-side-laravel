<?php

use App\Http\Controllers\AdminActions;
use Illuminate\Http\Request;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifySociety;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\RequestDataValidation;
use App\Http\Controllers\ApplyingJobsController;
use App\Http\Controllers\AvailablePositionsController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\LoginAdmin;
use App\Models\JobCategory;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("v1")->group(function () {
    Route::post('/admin/login', LoginAdmin::class);
    // Route::post('/admin/logout', [Logout::class, "logout1"]);
    Route::prefix("auth")->group(function () {
        Route::post('/login', [Login::class, "login2"]);
        Route::post('/logout', [Logout::class, "logout2"]);
    });
    Route::prefix("user")->group(function () {
        Route::get('/', [UserController::class, "index1"]);
        Route::post('/', [UserController::class, "store1"]);
        Route::delete('/{id}', [UserController::class, "destroy1"]);
    });
    Route::prefix("society")->group(function () {
        Route::get('/', [UserController::class, "index2"]);
        Route::post('/', [UserController::class, "store2"]);
        Route::delete('/{id}', [UserController::class, "destroy2"]);
    });
    Route::prefix("regional")->group(function () {
        Route::get('/', [RegionalController::class, "index"]);
        Route::post('/', [RegionalController::class, "store"]);
        Route::delete('/{id}', [RegionalController::class, "destroy"]);
    });
    Route::prefix("validations")->group(function () {
        Route::get('/', [RequestDataValidation::class, "index"]);
        Route::post('/', [RequestDataValidation::class, "store"])->middleware(VerifySociety::class);
    });
    Route::prefix("available_positions")->group(function () {
        Route::get('/', [AvailablePositionsController::class, "index"]);
        Route::post('/', [AvailablePositionsController::class, "store"])->middleware(VerifySociety::class);
    });
    Route::prefix("job_vacancies")->group(function () {
        Route::get('/', [JobVacancyController::class, "index"])->middleware(VerifySociety::class);
        Route::get('/{id}', [JobVacancyController::class, "show"])->middleware(VerifySociety::class);
        Route::post('/', [JobVacancyController::class, "store"])->middleware(VerifySociety::class);
    });
    Route::prefix("applications")->group(function () {
        Route::get('/', [ApplyingJobsController::class, "index"])->middleware(VerifySociety::class);
        Route::post('/', [ApplyingJobsController::class, "store"])->middleware(VerifySociety::class);
    });
    Route::prefix("admin_actions")->group(function () {
        Route::put('/validate_society/{id}', [AdminActions::class, "validate_society"]);
        Route::post('/insert_job_category', [AdminActions::class, "insert_job_category"]);
    });
    Route::prefix("job_category")->group(function () {
        Route::get('/', [JobCategoryController::class, "index"])->middleware(VerifySociety::class);
    });
});