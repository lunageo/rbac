<?php

namespace Luna\RBAC\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Luna\RBAC\Console\LunaPermissionsAdmin;
use Luna\RBAC\Console\LunaPermissionsPublish;
use Luna\RBAC\Middleware\AllowCrudsMiddleware;
use Luna\RBAC\Services\LunaPermissionsService;
use Luna\RBAC\Console\LunaPermissionsPublishWeb;
use Luna\RBAC\Console\LunaPermissionsPublishApi;
use Luna\RBAC\Console\LunaPermissionsCheckRoutes;
use Illuminate\Support\Facades\Route as AppRoute;
use Luna\RBAC\Console\LunaPermissionsPublishViews;
use Luna\RBAC\Middleware\AllowUsersCrudsMiddleware;
use Luna\RBAC\Middleware\AllowRolesCrudsMiddleware;
use Luna\RBAC\Console\LunaPermissionsPublishConfig;
use Luna\RBAC\Middleware\LunaPermissionsMiddleware;
use Luna\RBAC\Middleware\AllowRoutesCrudsMiddleware;
use Luna\RBAC\Console\LunaPermissionsPublishMigrations;

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
     * Register the package middleware.
     *
     * @return void
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('luna-access', LunaPermissionsMiddleware::class);
        $router->aliasMiddleware('allow-cruds', AllowCrudsMiddleware::class);
        $router->aliasMiddleware('allow-roles-crud', AllowRolesCrudsMiddleware::class);
        $router->aliasMiddleware('allow-routes-crud', AllowRoutesCrudsMiddleware::class);
        $router->aliasMiddleware('allow-users-crud', AllowUsersCrudsMiddleware::class);
    }

    /**
     * Publish the package  views.
     * 
     * php artisan vendor:publish --provider="Luna\RBAC\Providers\LunaPermissionsServiceProvider" --tag="views"
     *
     * @return void
     */
    protected function publishViews(): void
    {
        if (config('luna-rbac.publish-views') && $this->app->runningInConsole()) {
            // Publish views
            $this->publishes([
                __DIR__.'/../Views' => resource_path('views/vendor/' . config('luna-rbac.views-folder')),
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
        $this->loadViewsFrom(__DIR__.'/../Views', 'luna-rbac');
    }

    /**
     * Publish the package routes.
     *
     * php artisan vendor:publish --provider="Luna\RBAC\Providers\LunaPermissionsServiceProvider" --tag="web-routes"
     * 
     * @return void
     */
    protected function publishRoutes():  void
    {
        if (config('luna-rbac.publish-routes') && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Routes/web.php' => base_path('routes/luna-rbac-web.php'),
            ], 'web-routes');

            // $this->publishes([
            //     __DIR__ . '/../Routes/api.php' => base_path('routes/luna-rbac-api.php'),
            // ], 'api-routes');
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {   
        $routes_configuration = [
            'namespace' => 'Luna\RBAC\Controllers',
            'prefix' => config('luna-rbac.routes-prefix'),
            'as' => config('luna-rbac.routes-as'),
        ];

        // web
        Route::group($routes_configuration, function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });

        // api
        // Route::group($routes_configuration, function () {
        //     $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        // });
    }

    /**
     * Publish the package migrations.
     * 
     * php artisan vendor:publish --provider="Luna\RBAC\Providers\LunaPermissionsServiceProvider" --tag="migrations"
     *
     * @return void
     */
    protected function publishMigrations(): void
    {
        if (config('luna-rbac.publish-migrations') && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Database/migrations/create_routes_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_routes_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_routes_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_routes_table.php'),
                __DIR__ . '/../Database/migrations/create_roles_users_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_roles_users_table.php'),
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
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'luna-rbac');
    }

    /**
     * Allow publishing the package configuration.
     * 
     * php artisan vendor:publish --provider="Luna\RBAC\Providers\LunaPermissionsServiceProvider" --tag="config"
     *
     * @return void
     */
    protected function publishConfiguration(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/../Config/config.php' => config_path('luna-rbac.php'),
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
                LunaPermissionsAdmin::class,
                LunaPermissionsCheckRoutes::class,             
                LunaPermissionsPublish::class,
                LunaPermissionsPublishMigrations::class,
                LunaPermissionsPublishConfig::class,
                LunaPermissionsPublishWeb::class,
                //LunaPermissionsPublishApi::class,                
                LunaPermissionsPublishViews::class,
            ]);
        }
    }
}
