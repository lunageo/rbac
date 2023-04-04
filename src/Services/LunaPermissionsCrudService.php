<?php

namespace Luna\Permissions\Services;

use Luna\Permissions\Models\Role;
use Luna\Permissions\Models\Route;

class LunaPermissionsCrudService
{
    /**
     * Role
     *
     * @var Role
     */
    protected $role;

    /**
     * Route
     *
     * @var Route
     */
    protected $route;

    /**
     * Class constructor.
     *
     * @param \Luna\Permissions\Models\Role $role
     * @param \Luna\Permissions\Models\Route $route
     */
    public function __construct(Role $role, Route $route)
    {
        $this->role = $role;
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
     * Get the role model.
     *
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * Get all the available roles.
     *
     * @return Collection | null
     */
    public function allRoles(): mixed
    {
        return Role::get();
    }

    /**
     * Store a new role.
     *
     * @param array $data
     *
     * @return void
     */
    public function store(array $data): void
    {
        $this->role->fill($data);
        $this->role->save();
    }

    /**
     * Find a role by id.
     *
     * @param integer $id
     *
     * @return Role
     */
    public function find(int $id): Role
    {
        return $this->role->findOrFail($id);
    }

    /**
     * Update a role.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $this->role = $this->find($id);
        $this->role->fill($data);
        $this->role->update();
    }

    /**
     * Delete a role.
     *
     * @param integer $id
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->role = $this->find($id);
        $this->role->delete();
    }

    /**
     * Assign roles to a route.
     *
     * @param integer $route_id
     * @param array $role_ids
     *
     * @return Route
     */
    public function assignRolesToRoute(int $route_id, array $role_ids): route
    {
        $role_ids = collect($role_ids)->filter(function ($item) {
            
            if (!is_null($item)) {
                return $item;
            }
        })->toArray();

        $this->route = $this->findRoute($route_id);
        $this->route->roles()->sync($role_ids);

        return $this->route;
    }
}