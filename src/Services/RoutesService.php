<?php

namespace Luna\RBAC\Services;

use Luna\RBAC\Models\Route;

class RoutesService
{
    /**
     * Route
     *
     * @var Route
     */
    protected $route;

    /**
     * Class constructor.
     *
     * @param \Luna\RBAC\Models\Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * Get route model.
     *
     * @return Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * Get all the available routes from the db.
     *
     * @return Collection | null
     */
    public function allRoutes(): mixed
    {
        return Route::orderBy('namespace')
            ->orderBy('name')
            ->orderBy('uri')
            ->get();
    }

    /**
     * Get a route by id.
     *
     * @param integer $id
     *
     * @return Route
     */
    public  function findRoute(int $id): Route
    {
        return Route::findOrFail($id);
    }

    /**
     * Assign roles to a route.
     *
     * @param integer $route_id
     * @param array $role_ids
     *
     * @return Route
     */
    public function assignRolesToRoute(int $route_id, array $data): route
    {
        $this->route = $this->findRoute($route_id);
        $this->syncRoles($data);       

        return $this->route;
    }

    /**
     * Sync roles to the current route.
     *
     * @param array $data
     *
     * @return void
     */
    protected function syncRoles(array $data): void
    {
        if (!array_key_exists('roles', $data)) {
            $data['roles'] = [];
        }

        $role_ids = collect($data)->filter(function ($item) {
            
            if (!is_null($item)) {
                return $item;
            }
        })->toArray();
        $this->route->roles()->sync($role_ids);
    }
}