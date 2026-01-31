<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_affectation');
            $table->date('date_retour')->nullable();
            $table->text('raison')->nullable();
            $table->timestamps();
            
            $table->unique(['equipement_id', 'user_id', 'date_affectation']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};