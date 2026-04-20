<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('installation_logiciels')->truncate();
        DB::table('pieces_jointes')->truncate();
        DB::table('commentaires')->truncate();
        DB::table('interventions')->truncate();
        DB::table('affectation_actifs')->truncate();
        DB::table('historique_actifs')->truncate();
        DB::table('licence_logiciels')->truncate();
        DB::table('tickets_maintenance')->truncate();
        DB::table('actifs_informatiques')->truncate();
        DB::table('logiciels')->truncate();
        DB::table('maintenance_preventive')->truncate();
        DB::table('contrats_maintenance')->truncate();
        DB::table('prestataires')->truncate();
        DB::table('localisations')->truncate();
        DB::table('journal_activite')->truncate();
        DB::table('notifications')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('All data cleared except users and roles!');
    }
}
