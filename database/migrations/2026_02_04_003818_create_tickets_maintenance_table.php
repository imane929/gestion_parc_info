<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets_maintenance', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 50)->unique();
            $table->foreignId('actif_informatique_id')->nullable()->constrained('actifs_informatiques')->onDelete('set null');
            $table->string('sujet', 200);
            $table->text('description');
            $table->enum('priorite', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            $table->enum('statut', ['ouvert', 'en_cours', 'en_attente', 'resolu', 'ferme'])->default('ouvert');
            $table->foreignId('assigne_a')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->foreignId('created_by')->constrained('utilisateurs')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('numero');
            $table->index('actif_informatique_id');
            $table->index('priorite');
            $table->index('statut');
            $table->index('assigne_a');
            $table->index('created_by');
            $table->index(['statut', 'priorite']);
            $table->index(['created_at', 'statut']);
        });
        
        DB::statement("ALTER TABLE tickets_maintenance COMMENT = 'Table des tickets de maintenance'");
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets_maintenance');
    }
};