<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncRoleTables extends Command
{
    protected $signature = 'roles:sync';
    protected $description = 'Sync role_utilisateur table with model_has_roles';

    public function handle()
    {
        foreach (User::all() as $user) {
            $roleIds = DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('model_type', 'App\Models\User')
                ->pluck('role_id');

            foreach ($roleIds as $roleId) {
                DB::table('role_utilisateur')->updateOrInsert(
                    ['role_id' => $roleId, 'model_type' => 'App\Models\User', 'model_id' => $user->id],
                    ['role_id' => $roleId, 'model_type' => 'App\Models\User', 'model_id' => $user->id]
                );
            }
        }

        $this->info('Done syncing ' . User::count() . ' users to role_utilisateur table');
    }
}
