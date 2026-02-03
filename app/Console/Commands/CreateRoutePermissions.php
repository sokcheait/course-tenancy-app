<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreateRoutePermissions extends Command
{
    protected $signature = 'sokchea:create-permission-routes';

    protected $description = 'Create permissions like admin.users.index';

    public function handle()
    {
        $permissions = config('set-permission.permissions');

        foreach ($permissions as $role => $modules) {
            foreach ($modules as $module => $routes) {
                foreach ($routes as $route => $label) {

                    $permissionName = "{$role}.$route";

                    Permission::firstOrCreate([
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ]);

                    $this->line("✔ {$permissionName}");
                }
            }
        }

        $this->info('🎉 Permissions created successfully.');

        return Command::SUCCESS;
    }
}
