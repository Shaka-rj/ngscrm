<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SpetsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\UserValid;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/products/{product}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');

    Route::get('users', [AdminUserController::class, 'index'])->name('admin.user.list');
    Route::get('users/requests', [AdminUserController::class, 'requests'])->name('admin.user.requests');

});

Route::prefix('user')
    ->name('user.')
    //->middleware([UserValid::class])
    ->group(function() {
    Route::get('spets', [SpetsController::class, 'index']);
    Route::get('spets/create', [SpetsController::class, 'create'])->name('spets.create');
    Route::get('spets/create2', [SpetsController::class, 'create2'])->name('spets.create2');
    Route::post('spets/store', [SpetsController::class, 'store'])->name('spets.store');
    Route::get('spets/{id}', [SpetsController::class, 'show'])->name('spets.show');

    Route::get('main', [MainController::class, 'index'])->name('main.index');
});

Route::get('user/registration', [UserController::class, 'registration'])->name('registration');
Route::post('user/registration', [UserController::class, 'registration_store'])->name('registration.store');

Route::get('/telegram/test', [TelegramController::class, 'test']);
Route::get('/telegram/webapp', [TelegramController::class, 'webapp']);
Route::get('/telegram/webapp_data', [TelegramController::class, 'webapp_data']);
Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);