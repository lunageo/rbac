<?php

namespace Luna\RBAC\Console;

use Illuminate\Console\Command;

class LunaPermissionsPublishWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac-publish-web';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the package web routes.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Luna\RBAC\Providers\LunaPermissionsServiceProvider',
            '--tag' => 'web-routes',
        ]);
    }
}
