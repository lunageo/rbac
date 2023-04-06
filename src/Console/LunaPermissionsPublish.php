<?php

namespace Luna\RBAC\Console;

use Illuminate\Console\Command;

class LunaPermissionsPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all the resouces available.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('luna:rbac-publish-migrations');
        $this->call('luna:rbac-publish-config');
        $this->call('luna:rbac-publish-web-routes');
        // $this->call('luna:rbac-publish-api-routes');
        $this->call('luna:rbac-publish-views');
    }
}
