<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->enum('priorite', ['faible', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            $table->enum('statut', ['ouvert', 'en_cours', 'termine', 'annule'])->default('ouvert');
            $table->foreignId('equipement_id')->constrained()->onDelete('cascade');
            $table->foreignId('technicien_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('createur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('date_ouverture')->useCurrent();
            $table->timestamp('date_cloture')->nullable();
            $table->text('solution')->nullable();
            $table->timestamps();

            // Indexes for faster queries
            $table->index('statut');
            $table->index('priorite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};