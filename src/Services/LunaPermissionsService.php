<?php

namespace Luna\RBAC\Services;

use Luna\RBAC\Models\Role;
use Luna\RBAC\Models\Route;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model as User;
use Illuminate\Support\Facades\Route as AppRoutes;

class LunaPermissionsService
{
    /**
     * Routes collection defined in the application routes file.
     *
     * @var Collection
     */
    protected $app_routes;

    /**
     * Routes saved in the database.
     *
     * @var Collection
     */
    protected $saved_routes;

    /**
     * Routes that will be added to the db.
     *
     * @var Collection
     */
    protected $routes_to_add;

    /**
     * Routes that will be removed from the db.
     *
     * @var Collection
     */
    protected $routes_to_remove;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Update the routes in the db based on the routes defined in the route files.
     *
     * @return void
     */
    public function updateAppRoutes(): void
    {
        $this->init()
            ->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove()
            ->removeRoutes($this->routes_to_remove)
            ->checkRoutesToAdd()
            ->addRoutes($this->routes_to_add);
    }

    /**
     * Get all the app routes.
     *
     * @return LunaPermissionsService
     */
    public function setAppRoutes(): LunaPermissionsService
    {
       $app_routes = collect(AppRoutes::getRoutes()->getRoutes());

        foreach ($app_routes as $app_route) {
            
            $route  = new Route;
            $route->fill([
                'method' => implode(', ', $app_route->methods),
                'uri' => $app_route->uri,
                'name' => $app_route->action['as'],
                'action' => $app_route->action['controller'],
                'namespace' => $app_route->action['namespace'],
            ]);

            // only routes not blacklisted
            // only routes within a namespace            
            if (!in_array($route->namespace, config('luna-rbac.excluded-namespaces')) && !empty($route->namespace)) {
                $this->app_routes->push($route);
            }
        }

        return $this;
    }

    /**
     * Get the app routes collection.
     *
     * @return Collection
     */
    public function getAppRoutes(): Collection
    {
        return $this->app_routes;
    }

    /**
     * Get all the saved routes.
     *
     * @return LunaPermissionsService
     */
    public function setSavedRoutes(): LunaPermissionsService
    {
        $this->saved_routes = Route::select(['method', 'uri', 'name', 'action', 'namespace'])->get();

        return $this;
    }

    /**
     * Get the saved routes collection.
     *
     * @return Collection
     */
    public function getSavedRoutes(): Collection
    {
        return $this->saved_routes;
    }

    /**
     * Check the routes tha tneeds to be removed form the db.
     * These routes exist in the database but they don't exist in the route files.
     *
     * @return LunaPermissionsService
     */
    public function checkRoutesToRemove(): LunaPermissionsService
    {
        $this->routes_to_remove = Route::select(['method', 'uri', 'name', 'action', 'namespace'])
            ->whereNotIn('name', $this->app_routes->map(function ($item) {
                return $item->name;
            })->toArray())
            ->get();

        return $this;
    }

    /**
     * Get the routes to be removed.
     *
     * @return Collection
     */
    public function getRoutesToRemove(): collection
    {
        return $this->routes_to_remove;
    }

    /**
     * Remove a group of routes from the db.
     *
     * @param \Illuminate\Support\Collection $routes
     *
     * @return LunaPermissionsService
     */
    public function removeRoutes(Collection $routes): LunaPermissionsService
    {
        foreach ($routes as $route) {
            Route::where('name', $route->name)->first()->delete();
        }

        return $this;
    }

    /**
     * Check the routes that need to be added to the  database.
     * The routes exist in the route files but they don't in the database.
     *
     * @return LunaPermissionsService
     */
    public function checkRoutesToAdd(): LunaPermissionsService
    {
        $saved_routes = $this->saved_routes;
        $all = collect(array_merge($saved_routes->toArray(), $this->app_routes->toArray()));
        $dup = $all->duplicates();
        $result = $all->reject(function ($v, $k) use ($dup) {
            return in_array($v, $dup->toArray());
        });

        $this->routes_to_add = $result->map(function ($item) {
            
            $route = new Route;
            $route->fill([
                'method' => $item['method'],
                'uri' => $item['uri'],
                'name' => $item['name'],
                'action' => $item['action'],
                'namespace' => $item['namespace'],
            ]);

            return $route;
        });

        return $this;
    }

    /**
     * Get the routes to be added.
     *
     * @return Collection
     */
    public function getRoutesToAdd(): Collection
    {
        return $this->routes_to_add;
    }

    /**
     * Save new routes in the db.
     *
     * @param \Illuminate\Support\Collection $routes
     *
     * @return LunaPermissionsService
     */
    public function addRoutes(Collection $routes): LunaPermissionsService
    {
        foreach ($routes as $route) {
            $route->save();
        }

        return $this;
    }

    /**
     * Remove all routes.
     *
     * @return LunaPermissionsService
     */
    public function removeAllSavedRoutes(): LunaPermissionsService
    {
        if (0 < Route::count()) {
            Route::query()->delete();
        }

        return $this;
    }

    /**
     * Add all app routes.
     *
     * @return LunaPermissionsService
     */
    public function storeAllAppRoutes(): LunaPermissionsService
    {
        $this->addRoutes($this->app_routes);

        return $this;
    }

    /**
     * Initialize all the service class attributes.
     *
     * @return LunaPermissionsService
     */
    public function init(): LunaPermissionsService
    {
        $this->app_routes = collect([]);
        $this->saved_routes = collect([]);
        $this->routes_to_add = collect([]);
        $this->routes_to_remove = collect([]);

        return $this;
    }

    /**
     * Check if the authenticated user have access to the current route.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @param string $current_route_uri
     *
     * @return boolean
     */
    static public function canAccess(User $user, string $current_route_uri): bool
    {
        $can_access = false;
        
        if ($user && $user->roles()->exists()) {
            $user_roles = $user->roles;

            foreach ($user_roles as $role) {

                if ($role->routes()->exists()) {
                    $role = $role->routes->firstWhere('uri',  $current_route_uri);
                
                    if ($role) {
                        $can_access = true;
                    }
                }
            }
        }        

        return $can_access;
    }

    /**
     * Add the super user admin role.
     *
     * @return void
     */
    public function addSuperAdminRole(): void
    {
        if (0 == Role::where('key', 'superadmin')->count()) {
            Role::create([
                'key' => 'superadmin',
                'name' => 'Super Admin',
                'description' => 'Super administrator role.',
            ]);
        }
    }

    /**
     * Get a new PermissionService instance.
     *
     * @return LunaPermissionsService
     */
    static public function newInstance(): LunaPermissionsService
    {
        return new LunaPermissionsService;
    }
}