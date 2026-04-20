<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licence_logiciels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logiciel_id')->constrained('logiciels')->onDelete('cascade');
            $table->string('cle_licence', 255)->unique();
            $table->date('date_achat');
            $table->date('date_expiration');
            $table->integer('nb_postes')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('logiciel_id');
            $table->index('date_expiration');
            $table->index('cle_licence');
            $table->index(['logiciel_id', 'date_expiration']);
        });
        
        DB::statement("ALTER TABLE licence_logiciels COMMENT = 'Table des licences logicielles'");
    }

    public function down(): void
    {
        Schema::dropIfExists('licence_logiciels');
    }
};