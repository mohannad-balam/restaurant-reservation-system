<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController;
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

Route::get('/home', [WelcomeController::class, 'index']);

/*
FRONTEND ROUTES
*/
Route::get('/cats', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/cats/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/all-menus', [FrontendMenuController::class, 'index'])->name('menus.index');
Route::get('/reservations/step-one', [FrontendReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservations/step-one', [FrontendReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservations/step-two', [FrontendReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservations/step-two', [FrontendReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [WelcomeController::class, 'thankYou'])->name('thankyou');


/*
ADMIM ROUTES
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function(){
//     Route::get('/', [AdminController::class, 'index'])->name('index');
//     Route::resource('categories', CategoryController::class);
//     Route::resource('menus', MenuController::class);
//     Route::resource('tables', TableController::class);
//     Route::resource('reservations', ReservationController::class);
// });

require __DIR__.'/auth.php';
