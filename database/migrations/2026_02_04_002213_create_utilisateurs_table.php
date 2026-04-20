<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'));
            $table->enum('civilite', ['M', 'Mme', 'Mlle'])->nullable();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email')->unique();
            $table->string('telephone', 20)->nullable();
            $table->string('password');
            $table->enum('etat_compte', ['actif', 'inactif', 'suspendu', 'bloque'])->default('actif');
            $table->timestamp('derniere_connexion_at')->nullable();
            $table->string('photo_url')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('civilite');
            $table->index('etat_compte');
            $table->index('derniere_connexion_at');
            $table->index(['nom', 'prenom']);
        });
        
        DB::statement("ALTER TABLE utilisateurs COMMENT = 'Table des utilisateurs du système'");
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};