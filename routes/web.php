<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ActifController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\LogicielController;
use App\Http\Controllers\Admin\ContratController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LocalisationController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\InterventionController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PrestataireController;
use App\Http\Controllers\Admin\LicenceController;
use App\Http\Controllers\Admin\DemandeAccesController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\MyAssetsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardPortalController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->dashboardRouteName());
    }
    return view('welcome');
})->name('home');

Route::get('/welcome', fn() => view('welcome'))->name('welcome');

Route::get('/request-access', fn() => view('request-access'))->name('request-access');
Route::post('/request-access', [DemandeAccesController::class, 'store'])->name('request-access.submit');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Shared Protected Routes (All Roles)
|--------------------------------------------------------------------------
| Routes accessible by any authenticated and verified user.
*/
Route::middleware(['auth', 'verified'])->name('admin.')->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardPortalController::class, 'redirect'])->name('dashboard');
    Route::get('/dashboards/admin', [DashboardPortalController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboards/gestionnaire-it', [DashboardPortalController::class, 'gestionnaireIt'])->name('dashboard.gestionnaire_it');
    Route::get('/dashboards/technicien', [DashboardPortalController::class, 'technicien'])->name('dashboard.technicien');
    Route::get('/dashboards/utilisateur', [DashboardPortalController::class, 'utilisateur'])->name('dashboard.utilisateur');
    Route::get('/dashboards/analytics', [DashboardPortalController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/assignments', [DashboardPortalController::class, 'assignments'])->name('assignments');
    Route::get('/software-licenses', [DashboardPortalController::class, 'softwareLicenses'])->name('software-licenses');
    Route::get('/maintenance-history', [DashboardPortalController::class, 'maintenanceHistory'])->name('maintenance-history');
    Route::get('/search', [DashboardPortalController::class, 'search'])->name('search');

    Route::get('/legacy-dashboard', [DashboardController::class, 'index'])->name('dashboard.legacy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.update-preferences');
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('{notification}/marquer-lue', [NotificationController::class, 'marquerLue'])->name('marquer-lue');
        Route::post('marquer-toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('marquer-toutes-lues');
        Route::post('supprimer-lues', [NotificationController::class, 'supprimerLues'])->name('supprimer-lues');
        Route::delete('{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Tickets (Base access - creation for users, full access for others managed via Policies)
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.add-comment');
});

/*
|--------------------------------------------------------------------------
| Role-Based Access Control (Spatie)
|--------------------------------------------------------------------------
*/

// 1. UTILISATEUR: Mes Actifs, Ses Tickets
Route::middleware(['auth', 'role:utilisateur'])->name('admin.')->group(function () {
    Route::get('/my-assets', [MyAssetsController::class, 'index'])->name('my-assets');
});

// 2. MANAGER / TECHNICIEN / RESPONSABLE IT / ADMIN (Voir actifs/tickets/rapports)
Route::middleware(['auth', 'role:admin|responsable_it|technicien|manager'])->name('admin.')->group(function () {
    Route::get('/actifs', [ActifController::class, 'index'])->name('actifs.index');
    Route::get('/actifs/{actif}', [ActifController::class, 'show'])->name('actifs.show');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/actifs', [ReportController::class, 'actifs'])->name('reports.actifs');
    Route::get('/reports/tickets', [ReportController::class, 'tickets'])->name('reports.tickets');
    Route::get('/reports/inventaire', [ReportController::class, 'inventaire'])->name('reports.inventaire');
    Route::get('/reports/maintenance', [ReportController::class, 'maintenance'])->name('reports.maintenance');
    Route::get('/reports/licences', [ReportController::class, 'licences'])->name('reports.licences');
    Route::get('/reports/contrats', [ReportController::class, 'contrats'])->name('reports.contrats');
    Route::get('/reports/personnalise', [ReportController::class, 'personnalise'])->name('reports.personnalise');
    Route::get('/tickets/export', [TicketController::class, 'export'])->name('tickets.export');
    Route::get('/interventions/export', [InterventionController::class, 'export'])->name('interventions.export');
});

// 3. TECHNICIEN / RESPONSABLE IT / ADMIN (Maintenances & Interventions)
Route::middleware(['auth', 'role:admin|responsable_it|technicien'])->name('admin.')->group(function () {
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('interventions', InterventionController::class);
    Route::post('maintenances/{maintenance}/demarrer', [MaintenanceController::class, 'demarrer'])->name('maintenances.demarrer');
    Route::post('maintenances/{maintenance}/terminer', [MaintenanceController::class, 'terminer'])->name('maintenances.terminer');
    Route::post('maintenances/{maintenance}/annuler', [MaintenanceController::class, 'annuler'])->name('maintenances.annuler');
    Route::get('maintenances/retard/liste', [MaintenanceController::class, 'retard'])->name('maintenances.retard');
    Route::get('maintenances/prochaines/liste', [MaintenanceController::class, 'prochaines'])->name('maintenances.prochaines');
    Route::get('maintenances/planning/calendrier', [MaintenanceController::class, 'planning'])->name('maintenances.planning');
    Route::get('maintenances/export', [MaintenanceController::class, 'export'])->name('maintenances.export');
    Route::post('tickets/{ticket}/assigner', [TicketController::class, 'assigner'])->name('tickets.assigner');
    Route::post('tickets/{ticket}/resoudre', [TicketController::class, 'resoudre'])->name('tickets.resoudre');
    Route::post('tickets/{ticket}/intervention', [TicketController::class, 'addIntervention'])->name('tickets.add-intervention');
});

// 4. RESPONSABLE IT / ADMIN (Gestion du Parc Complet)
Route::middleware(['auth', 'role:admin|responsable_it'])->name('admin.')->group(function () {
    Route::resource('actifs', ActifController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('actifs/export', [ActifController::class, 'export'])->name('actifs.export');
    Route::post('actifs/{actif}/affecter', [ActifController::class, 'affecter'])->name('actifs.affecter');
    Route::post('actifs/{actif}/desaffecter', [ActifController::class, 'desaffecter'])->name('actifs.desaffecter');
    Route::post('actifs/{actif}/comment', [ActifController::class, 'addComment'])->name('actifs.comment');
    
    Route::resource('logiciels', LogicielController::class);
    Route::resource('licences', LicenceController::class);
    Route::resource('localisations', LocalisationController::class);
    Route::resource('contrats', ContratController::class);
    Route::resource('prestataires', PrestataireController::class);
});

// 5. ADMIN Only (Système & Administration)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('utilisateurs', UtilisateurController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('settings', SettingController::class)->except(['show']);
    Route::get('settings/groupe/{groupe}', [SettingController::class, 'groupe'])->name('settings.groupe');
    Route::post('settings/update-multiple', [SettingController::class, 'updateMultiple'])->name('settings.update-multiple');
    Route::post('settings/reset', [SettingController::class, 'reset'])->name('settings.reset');
    Route::post('settings/import', [SettingController::class, 'import'])->name('settings.import');
    Route::get('settings/export', [SettingController::class, 'export'])->name('settings.export');
    
    Route::prefix('demandes-acces')->name('demandes-acces.')->group(function () {
        Route::get('/', [DemandeAccesController::class, 'index'])->name('index');
        Route::post('/{demande}/approuver', [DemandeAccesController::class, 'approve'])->name('approve');
        Route::post('/{demande}/rejeter', [DemandeAccesController::class, 'reject'])->name('reject');
    });
    
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->middleware(['auth'])->group(function () {
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCountApi'])->name('notifications.unread-count');
});

Route::fallback(fn() => view('errors.404'));
