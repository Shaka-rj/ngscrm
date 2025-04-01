<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SpetsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BazaController;
use App\Http\Controllers\LocationController;
use App\Http\Middleware\UserValid;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TurPlanController;

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

    Route::prefix('baza')
    ->name('baza.')
    ->group(function(){
        Route::get('district/{id?}', [BazaController::class, 'district'])->name('district');
        Route::post('district/add',  [BazaController::class, 'district_add'])->name('district_add');
        Route::get('object/{id?}',   [BazaController::class, 'userobject'])->name('object');
        Route::post('object/add',    [BazaController::class, 'userobject_add'])->name('object_add');
        Route::get('doctor/{id?}',   [BazaController::class, 'doctor'])->name('doctor');
        Route::post('doctor/add',    [BazaController::class, 'doctor_add'])->name('doctor_add');
        Route::get('pharmacy/{id?}', [BazaController::class, 'pharmacy'])->name('pharmacy');
        Route::post('pharmacy/add',  [BazaController::class, 'pharmacy_add'])->name('pharmacy_add');
    });

    Route::prefix('location')
    ->name('location')
    ->group(function () {
        Route::get('district', [LocationController::class, 'district'])->name('.district');
        Route::get('object',   [LocationController::class, 'object'])->name('.object');
        Route::get('doctor',   [LocationController::class, 'doctor'])->name('.doctor');
        Route::get('pharmacy', [LocationController::class, 'pharmacy'])->name('.pharmacy');
        Route::get('/{id?}',   [LocationController::class, 'index'])->name('');
    });

    Route::prefix('plan')
    ->name('plan.')
    ->group(function (){
        Route::get('/',            [PlanController::class, 'index'])->name('index');
        Route::get('{date}',       [PlanController::class, 'show'])->name('show');
        Route::get('edit/{date}',  [PlanController::class, 'edit'])->name('edit');
        Route::post('edit/{date}', [PlanController::class, 'update'])->name('update');
    });

    Route::prefix('turplan')
    ->name('turplan.')
    ->group(function(){
        Route::get('/',                [TurPlanController::class, 'index'])->name('index');
        Route::get('{month_id}',       [TurPlanController::class, 'show'])->name('show');
        Route::get('edit/{month_id}',  [TurPlanController::class, 'edit'])->name('edit');
    });
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