<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemConfiguration;

class SystemConfigurationSeeder extends Seeder
{
    public function run()
    {
        $configurations = [
            ['key' => 'organization_name', 'value' => 'Gestion Parc Informatique'],
            ['key' => 'contact_email', 'value' => 'contact@parc-info.com'],
            ['key' => 'email_notifications', 'value' => '1'],
            ['key' => 'auto_report', 'value' => 'weekly'],
        ];
        
        foreach ($configurations as $config) {
            SystemConfiguration::updateOrCreate(
                ['key' => $config['key']],
                ['value' => $config['value']]
            );
        }
    }
}