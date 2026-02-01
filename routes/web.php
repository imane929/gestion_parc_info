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
use App\Http\Controllers\Admin\HistoriqueController;
use App\Http\Controllers\Admin\ApprovisionnementController;
use App\Http\Controllers\UserDashboardController;
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
    
    // User routes
    Route::middleware(['role:utilisateur'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/tickets', [UserDashboardController::class, 'tickets'])->name('tickets');
        Route::get('/tickets/create', [UserDashboardController::class, 'createTicket'])->name('tickets.create');
        Route::post('/tickets', [UserDashboardController::class, 'storeTicket'])->name('tickets.store');
        Route::get('/equipements', [UserDashboardController::class, 'equipements'])->name('equipements');
    });
    
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
        
        // Other pages - FIXED: Using Controller methods
        Route::get('/historique', [HistoriqueController::class, 'index'])->name('historique');
        
        Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
        Route::post('/rapports/generate', [RapportController::class, 'generate'])->name('rapports.generate');
        
        Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
        Route::post('/configuration/update', [ConfigurationController::class, 'update'])->name('configuration.update');
        
        Route::get('/approvisionnement', [ApprovisionnementController::class, 'index'])->name('approvisionnement');
    });

    // Technicien routes
    Route::middleware(['role:technicien'])->prefix('technicien')->name('technicien.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TechnicienDashboardController::class, 'index'])->name('dashboard');
        
        // Tickets
        Route::get('/tickets', [TechnicienDashboardController::class, 'tickets'])->name('tickets');
        Route::get('/tickets/create', [TechnicienDashboardController::class, 'createTicket'])->name('tickets.create');
        Route::post('/tickets', [TechnicienDashboardController::class, 'storeTicket'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TechnicienDashboardController::class, 'showTicket'])->name('tickets.show');
        Route::post('/tickets/{ticket}/start', [TechnicienDashboardController::class, 'startTicket'])->name('tickets.start');
        Route::post('/tickets/{ticket}/complete', [TechnicienDashboardController::class, 'completeTicket'])->name('tickets.complete');
        
        // Interventions
        Route::get('/interventions', [TechnicienDashboardController::class, 'interventions'])->name('interventions');
        
        // Equipment
        Route::get('/equipements', [TechnicienDashboardController::class, 'equipements'])->name('equipements');
        
        // History
        Route::get('/historique', [TechnicienDashboardController::class, 'historique'])->name('historique');
        
        // Reports
        Route::get('/rapports', [TechnicienDashboardController::class, 'rapports'])->name('rapports');
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

// Test route
Route::get('/test', function () {
    return 'Test route working';
});

require __DIR__.'/auth.php';