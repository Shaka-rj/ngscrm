<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\TurPlanController;

Route::middleware('auth:sanctum')->post('/location/store', [LocationController::class, 'store'])->name('user.location.store');

Route::middleware('auth:sanctum')->post('/turplan/update', [TurPlanController::class, 'update'])->name('user.turplan.update');