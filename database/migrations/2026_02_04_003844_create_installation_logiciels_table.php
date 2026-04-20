<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installation_logiciels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licence_logiciel_id')->constrained('licence_logiciels')->onDelete('cascade');
            $table->foreignId('actif_informatique_id')->constrained('actifs_informatiques')->onDelete('cascade');
            $table->date('date_installation');
            $table->timestamps();
            
            $table->unique(['licence_logiciel_id', 'actif_informatique_id'],'inst_log_licence_actif_unique');
            $table->index('licence_logiciel_id');
            $table->index('actif_informatique_id');
            $table->index('date_installation');
        });
        
        DB::statement("ALTER TABLE installation_logiciels COMMENT = 'Table des installations logicielles'");
    }

    public function down(): void
    {
        Schema::dropIfExists('installation_logiciels');
    }
};