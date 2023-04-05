<?php

namespace Luna\RBAC\Console;

use Artisan;
use Illuminate\Console\Command;

class LunaPermissionsPublishApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac-publish-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the package api routes.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="api-routes"');
    }
}
