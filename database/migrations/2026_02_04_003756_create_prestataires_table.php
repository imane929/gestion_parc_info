<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 200);
            $table->string('telephone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->foreignId('adresse_id')->nullable()->constrained('adresses')->onDelete('set null');
            $table->timestamps();
            
            $table->index('nom');
            $table->index('email');
            $table->index('adresse_id');
        });
        
        DB::statement("ALTER TABLE prestataires COMMENT = 'Table des prestataires externes'");
    }

    public function down(): void
    {
        Schema::dropIfExists('prestataires');
    }
};