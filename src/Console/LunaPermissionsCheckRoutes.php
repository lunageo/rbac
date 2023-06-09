<?php

namespace Luna\RBAC\Console;

use Illuminate\Console\Command;
use Luna\RBAC\Services\LunaPermissionsService;

class LunaPermissionsCheckRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the routes in the database  based on the application routes.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        LunaPermissionsService::newInstance()->updateAppRoutes();
    }
}
