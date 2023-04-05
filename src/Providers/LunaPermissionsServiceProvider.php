<?php

namespace Luna\Permissions\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route as AppRoute;
use Luna\Permissions\Console\LunaPermissionsInit;
use Luna\Permissions\Console\LunaPermissionsPublish;
use Luna\Permissions\Services\LunaPermissionsService;
use Luna\Permissions\Console\LunaPermissionsCheckRoutes;
use Luna\Permissions\Middleware\LunaPermissionsMiddleware;
use Luna\Permissions\Views\Components\RoutesTableViewComponent;

class LunaPermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerConfiguration();
    }

    /**
     * Boot all the elements.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerCommand();
        $this->publishConfiguration();
        $this->publishMigrations();
        $this->registerRoutes();
        $this->registerViews();
        $this->publishViews();
        $this->registerViewComponents();
        $this->publishViewComponents();
        $this->registerMiddleware();
        $this->registerGates();
    }

    /**
     * Rgister all the package gates.
     *
     * @return void
     */
    protected function registerGates(): void
    {
        Gate::define('have-access', function () {

            $user = Auth::user();

            return LunaPermissionsService::canAccess($user, AppRoute::current()->uri);
        });
    }

    /**
     * Register  the package middleware.
     *
     * @return void
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('luna-access', LunaPermissionsMiddleware::class);
    }

    /**
     * Publish the package view components.
     * 
     * php artisan vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="view-components"
     *
     * @return void
     */
    protected function publishViewComponents(): void
    {
        // if ($this->app->runningInConsole()) {
        //     // Publish view components
        //     $this->publishes([
        //         __DIR__.'/../Views/Components/' => app_path('View/Components'),
        //         __DIR__.'/../resources/views/components/' => resource_path('views/components'),
        //     ], 'view-components');
        // }
    }

    /**
     * Register the package view components.
     *
     * @return void
     */
    protected function registerViewComponents(): void
    {
        // $this->loadViewComponentsAs('lunapermissions', [
        //     RoutesTableViewComponent::class,
        // ]);
    }

    /**
     * Publish the package  views.
     * 
     * php artisan vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="views"
     *
     * @return void
     */
    protected function publishViews(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish views
            $this->publishes([
            __DIR__.'/../Views' => resource_path('views/vendor/' . config('luna-permissions.views-folder')),
            ], 'views');        
        }
    }

    /**
     * Register the package views.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Views', 'luna-permissions');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {   
        $routes_configuration = [
            'namespace' => 'Luna\Permissions\Controllers',
            'prefix' => config('luna-permissions.routes-prefix'),
            'as' => config('luna-permissions.routes-as'),
        ];

        // web
        Route::group($routes_configuration, function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        })
        //->middleware(['web'])
        ;

        // api
        // Route::group($routes_configuration, function () {
        //     $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        // });
    }

    /**
     * Publish the package migrations.
     *
     * @return void
     */
    protected function publishMigrations(): void
    {
        if (config('luna-permissions.use-migrations') && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Database/migrations/create_routes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_routes_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_routes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_routes_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_users_table.php'),
              ], 'migrations');
        }
    }

    /**
     * Register the luna permissions configuration file.
     *
     * @return void
     */
    protected function registerConfiguration(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'luna-permissions');
    }

    /**
     * Allow publishing the package configuration.
     * 
     * php artisan vendor:publish --provider="Luna\Permissions\Providers\LunaPermissionsServiceProvider" --tag="config"
     *
     * @return void
     */
    protected function publishConfiguration(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/../Config/config.php' => config_path('luna-permissions.php'),
            ], 'config');
        
        }
    }

    /**
     * Register the luna permissions package arisan commands.
     *
     * @return void
     */
    protected function registerCommand(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LunaPermissionsInit::class,
                LunaPermissionsPublish::class,
                LunaPermissionsCheckRoutes::class,
            ]);
        }
    }
}
