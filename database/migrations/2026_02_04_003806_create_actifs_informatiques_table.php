<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actifs_informatiques', function (Blueprint $table) {
            $table->id();
            $table->string('code_inventaire', 50)->unique();
            $table->enum('type', ['pc', 'imprimante', 'serveur', 'reseau', 'peripherique', 'mobile', 'autre'])->default('pc');
            $table->string('marque', 100);
            $table->string('modele', 150);
            $table->string('numero_serie', 100)->unique();
            $table->enum('etat', ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'])->default('bon');
            $table->date('date_achat')->nullable();
            $table->date('garantie_fin')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('localisation_id')->nullable()->constrained('localisations')->onDelete('set null');
            $table->foreignId('utilisateur_affecte_id')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('code_inventaire');
            $table->index('type');
            $table->index('etat');
            $table->index('localisation_id');
            $table->index('utilisateur_affecte_id');
            $table->index('garantie_fin');
            $table->index(['type', 'etat']);
        });
        
        DB::statement("ALTER TABLE actifs_informatiques COMMENT = 'Table des actifs informatiques'");
    }

    public function down(): void
    {
        Schema::dropIfExists('actifs_informatiques');
    }
};