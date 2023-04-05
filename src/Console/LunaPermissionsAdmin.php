<?php

namespace Luna\RBAC\Console;

use Illuminate\Console\Command;
use Luna\RBAC\Services\LunaPermissionsService;

class LunaPermissionsAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:rbac-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a superadmin role.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        LunaPermissionsService::newInstance()->addSuperAdminRole();
    }
}
