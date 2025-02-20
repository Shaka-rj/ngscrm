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
    Route::get('spets/create', [SpetsController::class, 'create'])->name('user.spets.create');
    Route::post('spets/store', [SpetsController::class, 'store'])->name('user.spets.store');
    Route::get('spets/{id}', [SpetsController::class, 'show'])->name('user.spets.show');
});