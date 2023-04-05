<?php

namespace Luna\RBAC\Traits;

use Luna\RBAC\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait LunaPermissionsTrait
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
}