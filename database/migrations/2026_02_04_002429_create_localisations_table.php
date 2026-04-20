<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localisations', function (Blueprint $table) {
            $table->id();
            $table->string('site', 150);
            $table->string('batiment', 100)->nullable();
            $table->string('etage', 50)->nullable();
            $table->string('bureau', 100)->nullable();
            $table->timestamps();
            
            $table->index('site');
            $table->index(['site', 'batiment']);
            $table->unique(['site', 'batiment', 'etage', 'bureau']);
        });
        
        DB::statement("ALTER TABLE localisations COMMENT = 'Table des localisations physiques'");
    }

    public function down(): void
    {
        Schema::dropIfExists('localisations');
    }
};