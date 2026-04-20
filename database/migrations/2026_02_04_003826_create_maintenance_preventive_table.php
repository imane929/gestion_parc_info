<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_preventive', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actif_informatique_id')->constrained('actifs_informatiques')->onDelete('cascade');
            $table->date('date_prevue');
            $table->enum('type', ['nettoyage', 'verification', 'mise_a_jour', 'remplacement', 'autre'])->default('verification');
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'annule'])->default('planifie');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('actif_informatique_id');
            $table->index('date_prevue');
            $table->index('statut');
            $table->index('type');
            $table->index(['actif_informatique_id', 'date_prevue']);
        });
        
        DB::statement("ALTER TABLE maintenance_preventive COMMENT = 'Table de la maintenance préventive'");
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_preventive');
    }
};