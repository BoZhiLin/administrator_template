<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class GenerateRouteJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json-route:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        $backend_json = [];
        $frontend_json = [];

        foreach ($routes as $route) {
            $route_name = $route->getName();
            $detail = [
                'method' => $route->methods(),
                'uri' => $route->uri()
            ];

            if (strpos($route->getActionName(), 'Admin')) {
                $backend_json[$route_name] = $detail;
            } elseif (strpos($route->getActionName(), 'Api')) {
                $frontend_json[$route_name] = $detail;
            }
        }

        $backend_file = resource_path('backend/js/router/routes.json');
        $frontend_file = resource_path('frontend/js/router/routes.json');
        file_put_contents($backend_file, json_encode($backend_json));
        file_put_contents($frontend_file, json_encode($frontend_json));

        $this->info('Completed!');
    }
}
