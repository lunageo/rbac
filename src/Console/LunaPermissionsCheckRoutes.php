<?php

namespace Luna\Permissions\Console;

use Illuminate\Console\Command;
use Luna\Permissions\Services\LunaPermissionsService;

class LunaPermissionsCheckRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:permissions-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the routes and update the routes table.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        LunaPermissionsService::newInstance()->updateAppRoutes();
    }
}
