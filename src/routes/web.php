<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteTobaccoShopController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TobaccoShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if( \Auth::user() ) return redirect(route('dashboard'));
    return view('home');
});
Route::get('/google/redirect', [App\Http\Controllers\LoginGoogleController::class,'store']);
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/impostazioni',[SettingsController::class,'index'])->name('impostazioni');


Route::get('/contabilizza/{tobaccoShop}',[TobaccoShopController::class,'show'])->middleware(['ownerOrEmployee','auth']);
Route::get('/user/logout',[LoginGoogleController::class,'closeSession']);
Route::get('/{tobaccoShop}/{token}/deleteTobaccoShop',[DeleteTobaccoShopController::class,'destroy']);
require __DIR__.'/auth.php';