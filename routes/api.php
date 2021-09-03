<?php

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