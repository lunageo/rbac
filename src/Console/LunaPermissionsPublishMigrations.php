<?php

namespace Luna\RBAC\Console;

use Illuminate\Console\Command;

class LunaPermissionsPublishMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac-publish-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the package migrations.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Luna\RBAC\Providers\LunaPermissionsServiceProvider',
            '--tag' => 'migrations',
        ]);
    }
}
