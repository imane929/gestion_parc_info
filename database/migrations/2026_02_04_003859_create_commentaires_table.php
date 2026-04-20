<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('objet_type', 100);
            $table->unsignedBigInteger('objet_id');
            $table->text('contenu');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['objet_type', 'objet_id']);
            $table->index('utilisateur_id');
            $table->index('created_at');
        });
        
        DB::statement("ALTER TABLE commentaires COMMENT = 'Table des commentaires (polymorphique)'");
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};