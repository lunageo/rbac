<?php

namespace Luna\Permissions\Console;

use Artisan;
use Illuminate\Console\Command;

class LunaPermissionsPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:permissions-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the package configuration (luna-permissions.php).';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Artisan::call('vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="config"');
        // Artisan::call('vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="migrations"');
        // Artisan::call('vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="views"');
        // Artisan::call('vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="view-components"');
    }
}
