<?php

use App\Http\Controllers\Admin\EquipementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('/dashboard-stats', [DashboardController::class, 'getStats']);
    Route::get('/recent-equipments', [DashboardController::class, 'getRecentEquipments']);
    Route::get('/recent-maintenance', [DashboardController::class, 'getRecentMaintenance']);
    
    Route::apiResource('equipements', EquipementController::class);
    Route::apiResource('users', UserController::class);
    
    Route::post('/generate-report', [DashboardController::class, 'generateReport']);
    Route::post('/configuration', [DashboardController::class, 'updateConfiguration']);
});