<?php

namespace Luna\RBAC\Models;

use App\Models\User;
use Luna\RBAC\Models\Route;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
        'key',
        'name',
        'description',
    ];

    /**
     * Get the user list.
     *
     * @return Collection
     */
    public function getUserListAttribute(): Collection
    {
        $user_model = new User;
        $attributes = [];
        $attributes[] = $user_model->getKeyName();
        $attributes = array_merge($attributes, config('luna-rbac.user-attributes'));
        
        return User::select($attributes)->get();
    }

    /**
     * Get a user by id.
     *
     * @param integer $user_id
     *
     * @return User | null
     */
    public function haveUser(int $user_id): mixed
    {
        return $this->users->firstWhere('id', $user_id);
    }

    /**
     * The users that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'roles_users', 'role_id', 'user_id');
    }

    /**
     * The routes that belongs to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'roles_routes', 'role_id', 'route_id');
    }

    /**
     * Get the route list.
     *
     * @return Collection
     */
    public function getRouteListAttribute(): Collection
    {
        return Route::orderBy('namespace')
            ->orderBy('name')
            ->orderBy('uri')
            ->get();
    }
}
