<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SpetsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BazaController;
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

    Route::get('users', [AdminUserController::class, 'index'])->name('user.list');
    Route::get('users/requests', [AdminUserController::class, 'requests'])->name('user.requests');
    Route::get('users/requests/0/{id}', [AdminUserController::class, 'cancel_user']);
    Route::get('users/requests/2/{id}', [AdminUserController::class, 'confirm_agent']);
    Route::get('users/requests/3/{id}', [AdminUserController::class, 'confirm_manager_regions']);
    Route::post('users/requests/3/{id}', [AdminUserController::class, 'confirm_manager'])->name('user.confim.manager');

});

Route::prefix('user')
    ->name('user.')
    ->middleware([UserValid::class])
    ->group(function() {
    Route::get('spets', [SpetsController::class, 'index']);
    Route::get('spets/create', [SpetsController::class, 'create'])->name('spets.create');
    Route::get('spets/create2', [SpetsController::class, 'create2'])->name('spets.create2');
    Route::post('spets/store', [SpetsController::class, 'store'])->name('spets.store');
    Route::get('spets/{id}', [SpetsController::class, 'show'])->name('spets.show');

    Route::get('main', [MainController::class, 'index'])->name('main.index');

    Route::get('baza/district', [BazaController::class, 'district'])->name('baza.district');
    Route::post('baza/district/add', [BazaController::class, 'district_add'])->name('baza.district_add');
    Route::get('baza/object', [BazaController::class, 'userobject'])->name('baza.object');
    Route::post('baza/object/add', [BazaController::class, 'userobject_add'])->name('baza.object_add');
    Route::get('baza/doctor', [BazaController::class, 'doctor'])->name('baza.doctor');
    Route::post('baza/doctor/add', [BazaController::class, 'doctor_add'])->name('baza.doctor_add');
    Route::get('baza/pharmacy', [BazaController::class, 'pharmacy'])->name('baza.pharmacy');
    Route::post('baza/pharmacy/add', [BazaController::class, 'pharmacy_add'])->name('baza.pharmacy_add');
});


///////////    TEST \\\\\\\\\\
Route::get('user/reg', [UserController::class, 'test']);
///////////////////////////
Route::get('user/registration', [UserController::class, 'registration'])->name('registration');
Route::post('user/registration', [UserController::class, 'registration_store'])->name('registration.store');


Route::get('/telegram/test', [TelegramController::class, 'test']);
Route::get('/telegram/webapp', [TelegramController::class, 'webapp']);
Route::get('/telegram/webapp_data', [TelegramController::class, 'webapp_data']);
Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);