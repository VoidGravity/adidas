<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class AddPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permissions';

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
        // $permissions = [];
        foreach ($routes as $route) {
            $uri = $route->uri();
            dd($uri);
            if (strstr($uri,'_')) continue;
            if (strstr($uri,'api')) continue;
            if (strstr($uri,'csrf')) continue;          
        }
        // \App\Models\route::insert($permissions);
    }
}
