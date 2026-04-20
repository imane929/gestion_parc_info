<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_utilisateur', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->morphs('model');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unique(['role_id', 'model_id', 'model_type'], 'role_user_unique');
            $table->index(['model_id', 'model_type', 'role_id'], 'role_user_index');
        });
        
        DB::statement("ALTER TABLE role_utilisateur COMMENT = 'Table pivot utilisateurs-rôles'");
    }

    public function down(): void
    {
        Schema::dropIfExists('role_utilisateur');
    }
};
