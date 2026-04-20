<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_maintenance_id')->constrained('tickets_maintenance')->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->date('date');
            $table->text('travaux');
            $table->integer('temps_passe')->comment('Temps en minutes');
            $table->text('notes')->nullable();
            $table->string('rapport')->nullable();
            $table->timestamps();
            
            $table->index('ticket_maintenance_id');
            $table->index('technicien_id');
            $table->index('date');
            $table->index(['ticket_maintenance_id', 'date']);
            $table->index('rapport');
        });
        
        DB::statement("ALTER TABLE interventions COMMENT = 'Table des interventions techniques'");
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};