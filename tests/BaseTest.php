<?php

namespace Luna\Permissions\Tests;

use Artisan;
use Orchestra\Testbench\TestCase;
use Illuminate\Routing\RouteCollection;
use Luna\Permissions\Providers\LunaPermissionsServiceProvider;

class BaseTest extends TestCase
{
    protected $loadEnvironmentVariables = true;

    protected $router;

    protected $route_collection;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
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
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', __DIR__ . '/Misc/db/database.sqlite'),
            'prefix'   => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        $app['config']->set('app.debug', env('APP_DEBUG', true));

        $app['config']->set('luna-permissions.excluded-namespaces', [
            'This\Namespace\Is\Excluded',
            'This\Namespace\Is\Excluded\As\Well',
        ]);
    }

    /**
     * Define routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        $this->router = $router;
        $this->route_collection = new RouteCollection;

        $this->route_collection->add($this->router->get('/dummy/route', [
            'namespace' => 'Luna\Permissions\Tests\Misc',
            'as' => 'dummy.route',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->route_collection->add($this->router->get('/dummy/route/another', [
            'namespace' => 'Luna\Permissions\Tests\Misc',
            'as' => 'dummy.route.another',
            'uses' => 'DummyController@dummyIndex',
        ]));
        // routes that  will not be added
        $this->route_collection->add($this->router->get('/dummy/route/null-namespace', [
            'namespace' => null,
            'as' => 'dummy.route.null.namespace',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->route_collection->add($this->router->get('/dummy/route/empty-namespace', [
            'namespace' => '',
            'as' => 'dummy.route.empty.namespace',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->route_collection->add($this->router->get('/dummy/route/exluded-namespace', [
            'namespace' => 'This\Namespace\Is\Excluded',
            'as' => 'dummy.route.excluded.namespace',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->route_collection->add($this->router->get('/dummy/route/exluded-namespace-as-well', [
            'namespace' => 'This\Namespace\Is\Excluded\As\Well',
            'as' => 'dummy.route.excluded.namespace.as.well',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->router->setRoutes($this->route_collection);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        Artisan::call('migrate:fresh', ['--database' => 'testbench']);

        $this->loadMigrationsFrom(__DIR__ . '/Misc/migrations');

        Artisan::call('migrate', ['--database' => 'testbench']);

        $this->beforeApplicationDestroyed(
            fn () => Artisan::call('migrate:rollback', ['--database' => 'testbench'])
        );
    }
    
}