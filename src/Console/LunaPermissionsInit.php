<?php

namespace Luna\Permissions\Console;

use Illuminate\Console\Command;
use App\Services\PermissionService;

class LunaPermissionsInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:permissions-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the permissions package.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //PermissionService::newInstance()->addSuperAdminRole();
    }
}
