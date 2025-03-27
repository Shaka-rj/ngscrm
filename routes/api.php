<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::middleware('auth:sanctum')->post('/location/store', [LocationController::class, 'store'])->name('user.location.store');