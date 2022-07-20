<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ScratchAndWinTobaccoShopController;
use App\Http\Controllers\TobaccoShopController;
use App\Models\TobaccoShop;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/google/login/url', [App\Http\Controllers\LoginGoogleController::class, 'index']);

Route::post('/users',[\App\Http\Controllers\Auth\RegisteredUserController::class,'store']);
Route::post('/password/reset', [App\Http\Controllers\Auth\PasswordResetLinkController::class,'store']);
Route::get("/contabilizza/{tobaccoShop}/scratchAndWins" , [App\Http\Controllers\ScratchAndWinTobaccoShopController::class,'show'])->middleware(['auth:sanctum', 'ownerOrEmployee']);
Route::delete("/contabilizza/{tobaccoShop}/scratchAndWins/{scratchAndWinTobaccoShop}/delete" , [App\Http\Controllers\ScratchAndWinTobaccoShopController::class,'destroy'])->middleware(['auth:sanctum', 'owner']);
Route::post("/contabilizza/{tobaccoShop}/scratchAndWins/store" , [App\Http\Controllers\ScratchAndWinTobaccoShopController::class,'store'])->middleware(['auth:sanctum', 'ownerOrEmployee']);
Route::get('/contabilita/{tobaccoShop}/oggi', [ScratchAndWinTobaccoShopController::class,'today'] )->middleware(['auth:sanctum', 'ownerOrEmployee']);
Route::get('/contabilita/{tobaccoShop}/quotidiana', [ScratchAndWinTobaccoShopController::class,'daily'] )->middleware(['auth:sanctum', 'owner']);
Route::get('/contabilita/{tobaccoShop}/mensile', [ScratchAndWinTobaccoShopController::class,'monthly'] )->middleware(['auth:sanctum', 'owner']);
Route::get('/contabilita/{tobaccoShop}/employees', [EmployeeController::class,'show'] )->middleware(['auth:sanctum', 'owner']);
Route::delete('/contabilita/{tobaccoShop}/employees/{employee}', [EmployeeController::class,'destroy'] )->middleware(['auth:sanctum', 'owner']);
Route::post('/contabilita/{tobaccoShop}/employee/add', [EmployeeController::class,'store'] )->middleware(['auth:sanctum', 'owner']);
Route::post('/contabilizza/tobaccoShop/new', [TobaccoShopController::class,'store'] )->middleware(['auth:sanctum']);
Route::post('/contabilita/{tobaccoShop}/custom', [ScratchAndWinTobaccoShopController::class,'dayChoosenByUser'])->middleware(['auth:sanctum', 'owner']);
Route::get('/packages/{tobaccoShop}/inselling',[PackageController::class,'show'])->middleware(['auth:sanctum', 'ownerOrEmployee']);
Route::get('/packages/{tobaccoShop}/sold',[PackageController::class,'showPackageSold'])->middleware(['auth:sanctum', 'owner']);
Route::delete('/package/{tobaccoShop}/{package}',[PackageController::class,'destroy'])->middleware(['auth:sanctum','owner']);
Route::get('/packages/{tobaccoShop}/{package}/complete',[PackageController::class,'update'])->middleware(['auth:sanctum','owner']);
