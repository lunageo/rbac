<?php

namespace Luna\RBAC\Tests;

use Artisan;
use Orchestra\Testbench\TestCase;
use Illuminate\Routing\RouteCollection;
use Luna\RBAC\Providers\LunaPermissionsServiceProvider;

class BaseTest extends TestCase
{
    /**
     * Load environment variables for the tests.
     *
     * @var boolean
     */
    protected $loadEnvironmentVariables = true;

    /**
     * Laravel app
     *
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Laravel Router object.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Laravel RouteCollection obj.
     *
     * @var Illuminate\Routing\RouteCollection
     */
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
     * Get the package service providers.
     *
     * @param \Illuminate\Foundation\Application $app
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
     * Set up the environment before the tests start.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $this->app = $app;

        $this->app['config']->set('database.default', 'testbench');
        $this->app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', __DIR__ . '/Misc/db/database.sqlite'),
            'prefix'   => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        $this->app['config']->set('app.debug', env('APP_DEBUG', true));

        $this->app['config']->set('luna-rbac.excluded-namespaces', [
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
    protected function defineRoutes($router): void
    {
        $this->router = $router;
        $this->route_collection = new RouteCollection;

        $this->route_collection->add($this->router->get('/dummy/route', [
            'namespace' => 'Luna\RBAC\Tests\Misc',
            'as' => 'dummy.route',
            'uses' => 'DummyController@dummyIndex',
        ]));

        $this->route_collection->add($this->router->get('/dummy/route/another', [
            'namespace' => 'Luna\RBAC\Tests\Misc',
            'as' => 'dummy.route.another',
            'uses' => 'DummyController@dummyIndex',
        ]));
        // routes that will not be added
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
     * Run database migrations and clean the database after.
     *
     * @return void
     */
    protected function defineDatabaseMigrations(): void
    {
        Artisan::call('migrate:fresh', ['--database' => 'testbench']);

        $this->loadMigrationsFrom(__DIR__ . '/Misc/migrations');

        Artisan::call('migrate', ['--database' => 'testbench']);

        $this->beforeApplicationDestroyed(
            fn () => Artisan::call('migrate:rollback', ['--database' => 'testbench'])
        );
    }
    
}