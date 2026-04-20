<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logiciels', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 200);
            $table->string('editeur', 150);
            $table->string('version', 50);
            $table->enum('type', ['os', 'bureau', 'serveur', 'web', 'mobile', 'autre'])->default('bureau');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('nom');
            $table->index('editeur');
            $table->index('type');
            $table->index(['nom', 'version']);
        });
        
        DB::statement("ALTER TABLE logiciels COMMENT = 'Catalogue des logiciels'");
    }

    public function down(): void
    {
        Schema::dropIfExists('logiciels');
    }
};