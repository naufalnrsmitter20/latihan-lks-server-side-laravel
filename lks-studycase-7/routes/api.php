<?php

use App\Http\Controllers\Admin\CatatKomposisiRotiController;
use App\Http\Controllers\Admin\ManageBahanController;
use App\Http\Controllers\Admin\ManageRotiController;
use App\Http\Controllers\Admin\ManageSupplierBahanController;
use App\Http\Controllers\Admin\ViewDataTransactionController;
use App\Http\Controllers\Admin\ViewKomposisiBahanBakuController;
use App\Http\Controllers\Admin\ViewLogSupplyController;
use App\Http\Controllers\Admin\ViewLogUsageController;
use App\Http\Controllers\Admin\ViewTotalPengeluaranController;
use App\Http\Controllers\Admin\ViewTotalPenjualanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Cashier\CatatTransaksiController;
use App\Http\Controllers\GasDang\CatatLogSupplyController;
use App\Http\Controllers\GasDang\CatatLogUsageController;
use App\Http\Controllers\GetBahanController;
use App\Http\Controllers\GetCashierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Middleware\VerifyCashier;
use App\Http\Middleware\VerifyGasdang;
use App\Http\Middleware\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\withMiddleware;

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
Route::apiResource("/bahan", ManageBahanController::class, [
    "bahan.index",
    ("bahan.store"),
    "bahan.show",
    "bahan.update",
    "bahan.destroy",
])->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::apiResource("/roti", ManageRotiController::class, [
    "roti.index",
    "roti.store",
    "roti.show",
    "roti.update",
    "roti.destroy",
])->middleware([VerifyToken::class, VerifyAdmin::class]);
Route::prefix("auth")->group(function () {
    Route::post("/login", LoginController::class);
    Route::post("/logout", LogoutController::class)->middleware(VerifyToken::class);
});
Route::prefix("admin")->group(function () {
    Route::post("/catat-komposisi-roti", CatatKomposisiRotiController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/manage-supplier-bahan", ManageSupplierBahanController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/view-data-transaction", ViewDataTransactionController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::get("/view-komposisi-bahan-baku", ViewKomposisiBahanBakuController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/view-log-supply", ViewLogSupplyController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/view-log-usage", ViewLogUsageController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/view-total-pengeluaran", ViewTotalPengeluaranController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
    Route::post("/view-total-penjualan", ViewTotalPenjualanController::class)->middleware([VerifyToken::class, VerifyAdmin::class]);
});
Route::prefix("cashier")->group(function () {
    Route::post("/catat-transaksi", CatatTransaksiController::class)->middleware([VerifyToken::class, VerifyCashier::class]);
});
Route::prefix("gasdang")->group(function () {
    Route::post("/catat-log-supply", CatatLogSupplyController::class)->middleware([VerifyToken::class, VerifyGasdang::class]);
    Route::post("/catat-log-usage", CatatLogUsageController::class)->middleware([VerifyToken::class, VerifyGasdang::class]);
});

Route::get("get-cashier", GetCashierController::class);
Route::get("get-bahan", GetBahanController::class);
