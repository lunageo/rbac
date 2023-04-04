<?php

namespace Luna\Permissions\Traits;

use Luna\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait LunaPermissionsTrait
{
    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_users', 'user_id', 'role_id');
    }
}