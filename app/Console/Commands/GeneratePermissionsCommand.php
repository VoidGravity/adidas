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
        $routes = Route::getRoutes(); // Update the method call

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

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('role_permissions')->truncate();
        DB::table('routes')->truncate();

        DB::table('routes')->insert($permissions);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Permissions generated successfully!');
    }
}
