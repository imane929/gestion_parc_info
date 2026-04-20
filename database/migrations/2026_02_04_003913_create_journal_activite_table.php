<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_activite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->string('action', 100);
            $table->string('objet_type', 100);
            $table->unsignedBigInteger('objet_id');
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('donnees_avant')->nullable();
            $table->json('donnees_apres')->nullable();
            $table->timestamps();
            
            $table->index(['utilisateur_id', 'created_at']);
            $table->index(['objet_type', 'objet_id']);
            $table->index('action');
            $table->index('created_at');
        });
        
        DB::statement("ALTER TABLE journal_activite COMMENT = 'Journal d\\'audit des activités'");
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_activite');
    }
};