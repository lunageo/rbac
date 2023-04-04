<?php

namespace Luna\Permissions\Tests;

use Orchestra\Testbench\TestCase;
use Luna\Permissions\Providers\LunaPermissionsServiceProvider;

class BaseTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    /**
     * Undocumented function
     *
     * @param [type] $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LunaPermissionsServiceProvider::class,
        ];
    }

    /**
     * Undocumented function
     *
     * @param [type] $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}