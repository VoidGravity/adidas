<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route; // Update the import statement

class GeneratePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate {--model=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes();

        $permissions = [];

        foreach ($routes as $route) {
            $name = $route->getName();

            if ($name) {
                $permissionName = str_replace(['.', ':'], ['_', '_'], $name);
                $permissions[] = [
                    'route' => $permissionName,
                ];
            }
        }
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('TRUNCATE TABLE role_permissions CASCADE');
        DB::statement('TRUNCATE TABLE routes CASCADE');

        // DB::table('role_permissions')->truncate();
        // DB::table('routes')->truncate();
        DB::table('routes')->insert($permissions);
        //asigning the role id 1 to all permissions
        DB::table('role_permissions')->insert(
            DB::table('routes')->get()->map(function ($route) {
                return [
                    'role_id' => 44,
                    'route_id' => $route->id,
                ];
            })->toArray()
        );


        // DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Permissions generated successfully!');
    }
}
