<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pieces_jointes', function (Blueprint $table) {
            $table->id();
            $table->string('objet_type', 100); // Ex: App\Models\TicketMaintenance
            $table->unsignedBigInteger('objet_id');
            $table->string('nom_fichier', 255);
            $table->string('chemin', 500);
            $table->string('mime', 100);
            $table->bigInteger('taille')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['objet_type', 'objet_id']);
            $table->index('uploaded_by');
            $table->index('mime');
        });
        
        DB::statement("ALTER TABLE pieces_jointes COMMENT = 'Table des pièces jointes (polymorphique)'");
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces_jointes');
    }
};