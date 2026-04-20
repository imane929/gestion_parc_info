<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrats_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestataire_id')->constrained('prestataires')->onDelete('cascade');
            $table->string('numero', 100)->unique();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('sla')->nullable()->comment('Service Level Agreement');
            $table->decimal('montant', 12, 2)->nullable();
            $table->boolean('renouvellement_auto')->default(false);
            $table->integer('jours_alerte')->default(30);
            $table->timestamps();
            
            $table->index('prestataire_id');
            $table->index('numero');
            $table->index('date_debut');
            $table->index('date_fin');
            $table->index('montant');
            $table->index(['date_debut', 'date_fin']);
        });
        
        DB::statement("ALTER TABLE contrats_maintenance COMMENT = 'Table des contrats de maintenance'");
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats_maintenance');
    }
};