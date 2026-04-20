<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->string('code', 50)->nullable()->unique();
            $table->string('libelle', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['name', 'guard_name']);
        });
        
        DB::statement("ALTER TABLE permissions COMMENT = 'Table des permissions'");
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};