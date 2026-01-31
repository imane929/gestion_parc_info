<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Technicien\TechnicienDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EquipementController;
use App\Http\Controllers\Admin\AffectationController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\RapportController;
use App\Http\Controllers\Admin\ConfigurationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routing based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'technicien') {
            return redirect()->route('technicien.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
    
    // Regular user dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // API routes for dashboard
        Route::get('/stats', [AdminDashboardController::class, 'getStats'])->name('stats');
        Route::get('/recent-equipments', [AdminDashboardController::class, 'getRecentEquipments'])->name('recent.equipments');
        Route::get('/recent-maintenance', [AdminDashboardController::class, 'getRecentMaintenance'])->name('recent.maintenance');
        
        // Resources
        Route::resource('users', UserController::class);
        Route::resource('equipements', EquipementController::class);
        Route::resource('affectations', AffectationController::class);
        Route::resource('tickets', TicketController::class);
        
        // Other pages
        Route::get('/historique', function () {
            return view('admin.historique');
        })->name('historique');
        
        Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
        Route::post('/rapports/generate', [RapportController::class, 'generate'])->name('rapports.generate');
        
        Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
        Route::post('/configuration/update', [ConfigurationController::class, 'update'])->name('configuration.update');
        
        Route::get('/approvisionnement', function () {
            return view('admin.approvisionnement');
        })->name('approvisionnement');
    });

    // Technician routes
    Route::middleware(['role:technicien'])->prefix('technicien')->name('technicien.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.technicien');
        })->name('dashboard');
    });
});

// API Routes
Route::middleware(['auth:sanctum'])->prefix('api/admin')->group(function () {
    Route::get('/dashboard-stats', [AdminDashboardController::class, 'getStats']);
    Route::get('/recent-equipments', [AdminDashboardController::class, 'getRecentEquipments']);
    Route::get('/recent-maintenance', [AdminDashboardController::class, 'getRecentMaintenance']);
    
    // Equipment API routes
    Route::get('/equipements', [EquipementController::class, 'apiIndex']);
    Route::post('/equipements', [EquipementController::class, 'apiStore']);
    Route::put('/equipements/{equipement}', [EquipementController::class, 'apiUpdate']);
    Route::delete('/equipements/{equipement}', [EquipementController::class, 'apiDestroy']);
});

// Fallback route for testing
Route::get('/test', function () {
    return 'Test route working';
});

require __DIR__.'/auth.php';
