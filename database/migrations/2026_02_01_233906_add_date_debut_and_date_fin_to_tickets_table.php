<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('date_debut')->nullable()->after('date_ouverture');
            $table->timestamp('date_fin')->nullable()->after('date_debut');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['date_debut', 'date_fin']);
        });
    }
    
};
