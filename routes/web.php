<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SpetsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/products/{product}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');
});

Route::prefix('user')->name('user.')->group(function() {
    Route::get('spets', [SpetsController::class, 'index']);
    Route::get('spets/create', [SpetsController::class, 'create'])->name('spets.create');
    Route::get('spets/create2', [SpetsController::class, 'create2'])->name('spets.create2');
    Route::post('spets/store', [SpetsController::class, 'store'])->name('spets.store');
    Route::get('spets/{id}', [SpetsController::class, 'show'])->name('spets.show');
});