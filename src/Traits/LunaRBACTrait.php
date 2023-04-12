<?php

namespace Luna\RBAC\Traits;

use Luna\RBAC\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait LunaRBACTrait
{
    /**
     * The roles that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_users', 'user_id', 'role_id');
    }

    /**
     * Get the role list.
     *
     * @return Collection
     */
    public function getRoleListAttribute(): Collection
    {
        return Role::get();
    }

    /**
     * Get a role by id from the related roles.
     *
     * @param integer $role_id
     *
     * @return Role | null
     */
    public function haveRole(int $role_id): mixed
    {
        return $this->roles->firstWhere('id', $role_id);
    }

    /**
     * Checks if the user have any associated role.
     *
     * @return boolean
     */
    public function haveRoles(): bool
    {
        if ($this->roles()->exists() && 0 < $this->roles->count()) {
            return true;
        }

        return true;
    }

    /**
     * Checks if the user have at least one role associated.
     *
     * @return boolean
     */
    public function haveOneOrMoreRole(): bool
    {
        if ($this->roles()->exists() && 1 <= $this->roles->count()) {
            return true;
        }
        return false;
    }
}