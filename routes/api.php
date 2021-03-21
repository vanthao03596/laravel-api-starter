<?php

use App\Http\Controllers\API\AuthorizationController;
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

// Authorization management
Route::post('login', [AuthorizationController::class, 'store'])->middleware('guest');

Route::middleware('auth')
    ->group(function () {
        Route::get('me', [AuthorizationController::class, 'show']);
        Route::delete('logout', [AuthorizationController::class, 'destroy']);
    });
