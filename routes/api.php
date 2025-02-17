<?php
use App\Http\Controllers\Api\MenuController as UserMenuController;
use App\Http\Controllers\Api\CategoryController as UserCategoryController;
use App\Http\Controllers\Api\ReservationController as ReservationControllerApi;
use App\Http\Controllers\Api\TableController as UserTableController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * admin
 */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\TableController as AdminTableController;

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
    Route::get('/categories', [UserCategoryController::class, 'index']);
    Route::get('/categories/{category}', [UserCategoryController::class, 'show']);
    Route::get('/menus', [UserMenuController::class, 'index']);
    Route::get('/available-tables', [UserTableController::class, 'index']);
    Route::post('/create-reservation', [ReservationControllerApi::class, 'createReservation']);
    Route::get('/get-user-reservations', [ReservationControllerApi::class, 'getUserReservation']);
    Route::delete('/delete-user-reservation/{id}', [ReservationControllerApi::class, 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    // Route::get('/', [AdminController::class, 'index'])->name('index');
    ///categories
    Route::get('/get-categories', [AdminCategoryController::class, 'index']);
    Route::post('/create-category', [AdminCategoryController::class, 'store']);
    Route::delete('/delete-category/{id}', [AdminCategoryController::class, 'destroy']);
    Route::get('/get-categories/{id}', [AdminCategoryController::class, 'show']);
    Route::put('/update-category/{id}', [AdminCategoryController::class, 'update']);
    // Route::resource('admin-categories', AdminCategoryController::class);
    ///menus
    Route::get('/get-menus', [AdminMenuController::class, 'index']);
    Route::post('/create-menu', [AdminMenuController::class, 'store']);
    Route::delete('/delete-menu/{id}', [AdminMenuController::class, 'destroy']);
    Route::put('/update-menu/{id}', [AdminMenuController::class, 'update']);
    // Route::resource('admin-menus', AdminMenuController::class);
    ///tables
    Route::get('/get-tables', [AdminTableController::class, 'index']);
    Route::post('/create-table', [AdminTableController::class, 'store']);
    Route::delete('/delete-table/{id}', [AdminTableController::class, 'destroy']);
    Route::put('/update-table/{id}', [AdminTableController::class, 'update']);
    // Route::resource('admin-tables', AdminTableController::class);
    Route::get('/get-reservations', [AdminReservationController::class, 'index']);
    Route::post('/add-reservation', [AdminReservationController::class, 'store']);
    Route::delete('/delete-reservation/{id}', [AdminReservationController::class, 'destroy']);
    Route::put('/update-reservation/{id}', [AdminReservationController::class, 'update']);
    // Route::resource('admin-reservations', AdminReservationController::class);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
