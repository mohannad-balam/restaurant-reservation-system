<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReservationController as ReservationControllerApi;
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

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/menus', [MenuController::class, 'index']);
Route::post('/init-reservation', [ReservationControllerApi::class, 'storeFirst']);
Route::put('/confirm-reservation/{id}', [ReservationControllerApi::class, 'storeStepTwo']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
