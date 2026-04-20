<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->string('cle', 100)->unique();
            $table->text('valeur')->nullable();
            $table->string('groupe', 50)->default('systeme');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('cle');
            $table->index('groupe');
            $table->index(['groupe', 'cle']);
        });
        
        DB::statement("ALTER TABLE parametres COMMENT = 'Table des paramètres configurables'");
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};