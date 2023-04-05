<?php

namespace Luna\RBAC\Models;

use Luna\RBAC\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'routes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'method',
        'uri',
        'name',
        'action',
        'namespace',
        'protect',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_routes', 'route_id', 'role_id');
    }

    /**
     * Get the roles list.
     *
     * @return Collection | null
     */
    public function getRoleListAttribute(): mixed
    {
        return Role::select(['id', 'name'])->get();
    }

    /**
     * Get a role by id.
     *
     * @param integer $role_id
     *
     * @return Role | null
     */
    public function haveRole(int $role_id): mixed
    {
        return $this->roles->firstWhere('id', $role_id);
    }
}
