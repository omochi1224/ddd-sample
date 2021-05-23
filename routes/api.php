<?php

use Auth\Presentation\Controllers\RegisterController;
use Auth\Presentation\Controllers\UserFindController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('users', RegisterController::class)->name('user.register');
Route::GET('users', UserFindController::class)->name('user.find');
