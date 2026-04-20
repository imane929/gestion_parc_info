<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('pays', 100)->default('Maroc');
            $table->string('ville', 100);
            $table->string('quartier', 150)->nullable();
            $table->string('rue', 200)->nullable();
            $table->string('code_postal', 20)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            
            $table->index('ville');
            $table->index('pays');
            $table->index(['pays', 'ville']);
            //$table->spatialIndex(['latitude', 'longitude']);
        });
        
        DB::statement("ALTER TABLE adresses COMMENT = 'Table des adresses géographiques'");
    }

    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};