<?php
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReservationController as ReservationControllerApi;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\AuthController;
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
Route::post('/user-login', [AuthController::class, 'login']);
Route::post('/user-register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/available-tables', [TableController::class, 'index']);
    Route::post('/create-reservation', [ReservationControllerApi::class, 'createReservation']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
