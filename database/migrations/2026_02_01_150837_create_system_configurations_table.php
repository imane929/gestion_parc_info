<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default configuration
        DB::table('system_configurations')->insert([
            ['key' => 'organization_name', 'value' => 'Gestion Parc Informatique'],
            ['key' => 'contact_email', 'value' => 'contact@parc-info.com'],
            ['key' => 'email_notifications', 'value' => '1'],
            ['key' => 'auto_report', 'value' => 'weekly'],
            ['created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('system_configurations');
    }
};