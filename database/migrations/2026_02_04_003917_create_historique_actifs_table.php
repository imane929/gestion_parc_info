<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historique_actifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actif_informatique_id')->constrained('actifs_informatiques')->onDelete('cascade');
            $table->string('evenement', 100);
            $table->text('details')->nullable();
            $table->timestamps();
            
            $table->index('actif_informatique_id');
            $table->index('evenement');
            $table->index('created_at');
            $table->index(['actif_informatique_id', 'created_at']);
        });
        
        DB::statement("ALTER TABLE historique_actifs COMMENT = 'Historique des modifications d\\'actifs'");
    }

    public function down(): void
    {
        Schema::dropIfExists('historique_actifs');
    }
};