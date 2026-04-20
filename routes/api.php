<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ActifController as ApiActifController;
use App\Http\Controllers\Api\V1\TicketController as ApiTicketController;
use App\Http\Controllers\Api\V1\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes publiques
Route::prefix('v1')->group(function () {
    // Authentification
    //Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('check-token', [AuthController::class, 'checkToken']);
});

// Routes protégées
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Authentification
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout-all', [AuthController::class, 'logoutAll']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::get('me', [AuthController::class, 'me']);
    
    // Profil utilisateur
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::post('change-password', [ProfileController::class, 'changePassword']);
        Route::get('notifications', [ProfileController::class, 'notifications']);
        Route::post('notifications/{notification}/marquer-lue', [ProfileController::class, 'marquerNotificationLue']);
        Route::post('notifications/marquer-toutes-lues', [ProfileController::class, 'marquerToutesNotificationsLues']);
        Route::get('mes-tickets', [ProfileController::class, 'mesTickets']);
        Route::get('mes-actifs', [ProfileController::class, 'mesActifs']);
        Route::get('mes-interventions', [ProfileController::class, 'mesInterventions']);
        Route::post('generate-api-token', [ProfileController::class, 'generateApiToken']);
        Route::get('api-tokens', [ProfileController::class, 'apiTokens']);
        Route::delete('api-tokens/{tokenId}', [ProfileController::class, 'revokeApiToken']);
        Route::delete('api-tokens', [ProfileController::class, 'revokeAllApiTokens']);
        Route::post('check-permissions', [ProfileController::class, 'checkPermissions']);
    });
    
    // Actifs
    Route::prefix('actifs')->group(function () {
        Route::get('/', [ApiActifController::class, 'index']);
        Route::post('/', [ApiActifController::class, 'store']);
        Route::get('{actif}', [ApiActifController::class, 'show']);
        Route::put('{actif}', [ApiActifController::class, 'update']);
        Route::delete('{actif}', [ApiActifController::class, 'destroy']);
        Route::post('{actif}/affecter', [ApiActifController::class, 'affecter']);
        Route::post('{actif}/desaffecter', [ApiActifController::class, 'desaffecter']);
        Route::get('{actif}/historique', [ApiActifController::class, 'historique']);
        Route::get('{actif}/tickets', [ApiActifController::class, 'tickets']);
        Route::get('statistiques', [ApiActifController::class, 'statistiques']);
        Route::get('garantie-expirant', [ApiActifController::class, 'garantieExpirant']);
    });
    
    // Tickets
    Route::prefix('tickets')->group(function () {
        Route::get('/', [ApiTicketController::class, 'index']);
        Route::post('/', [ApiTicketController::class, 'store']);
        Route::get('{ticket}', [ApiTicketController::class, 'show']);
        Route::put('{ticket}', [ApiTicketController::class, 'update']);
        Route::delete('{ticket}', [ApiTicketController::class, 'destroy']);
        Route::post('{ticket}/assigner', [ApiTicketController::class, 'assigner']);
        Route::post('{ticket}/resoudre', [ApiTicketController::class, 'resoudre']);
        Route::post('{ticket}/comment', [ApiTicketController::class, 'addComment']);
        Route::post('{ticket}/intervention', [ApiTicketController::class, 'addIntervention']);
        Route::get('{ticket}/commentaires', [ApiTicketController::class, 'commentaires']);
        Route::get('{ticket}/interventions', [ApiTicketController::class, 'interventions']);
        Route::get('{ticket}/pieces-jointes', [ApiTicketController::class, 'piecesJointes']);
        Route::get('statistiques', [ApiTicketController::class, 'statistiques']);
    });
});

// Rate limiting pour l'API
Route::middleware('throttle:api')->group(function () {
    // Routes avec rate limiting
});