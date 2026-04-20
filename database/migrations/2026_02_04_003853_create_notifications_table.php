<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('type', 50);
            $table->string('titre', 200);
            $table->text('message');
            $table->timestamp('lu_at')->nullable();
            $table->enum('canal', ['email', 'sms', 'app', 'tous'])->default('app');
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('utilisateur_id');
            $table->index('type');
            $table->index('lu_at');
            $table->index(['utilisateur_id', 'lu_at']);
        });
        
        DB::statement("ALTER TABLE notifications COMMENT = 'Table des notifications système'");
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};