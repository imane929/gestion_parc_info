<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectation_actifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actif_informatique_id')->constrained('actifs_informatiques')->onDelete('cascade');
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->timestamps();
            
            $table->index('actif_informatique_id');
            $table->index('utilisateur_id');
            $table->index('date_debut');
            $table->index('date_fin');
            $table->index(['actif_informatique_id', 'date_debut']);
        });
        
        DB::statement("ALTER TABLE affectation_actifs COMMENT = 'Historique des affectations d\\'actifs'");
    }

    public function down(): void
    {
        Schema::dropIfExists('affectation_actifs');
    }
};