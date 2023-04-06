<?php

namespace Luna\RBAC\Services;

use Luna\RBAC\Models\Role;

class RolesService
{
    /**
     * Role
     *
     * @var Role
     */
    protected $role;

    /**
     * Class constructor.
     *
     * @param \Luna\RBAC\Models\Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
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

        // update users
        $user_ids = collect($data['users'])->filter(function ($item) {
            
            if (!is_null($item)) {
                return $item;
            }
        })->toArray();
        $this->role->users()->sync($user_ids);
        
        // update routes
        $route_ids = collect($data['routes'])->filter(function ($item) {
            
            if (!is_null($item)) {
                return $item;
            }
        })->toArray();
        $this->role->routes()->sync($route_ids);
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
}