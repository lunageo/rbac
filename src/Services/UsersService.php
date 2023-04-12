<?php

namespace Luna\RBAC\Services;

use Hash;
use App\Models\User;

class UsersService
{
    /**
     * User
     *
     * @var User
     */
    protected $user;

    /**
     * Class constructor.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user model.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get all the available users.
     *
     * @return Collection | null
     */
    public function allUsers(): mixed
    {
        return User::get();
    }

    /**
     * Store a new user.
     *
     * @param array $data
     *
     * @return void
     */
    public function store(array $data): void
    {
        if (config('luna-rbac.only-one-role') && 1 < count($data['roles'])) {
            abort(400, config('luna-rbac.only-one-role-msg'));
        }

        $this->user->fill($data);
        $this->user->password = Hash::make($data['password']);
        $this->user->save();
        $this->syncRoles($data);
    }

    /**
     * Find a user by id.
     *
     * @param integer $id
     *
     * @return User
     */
    public function find(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Update a user.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function update(int $id, array $data): void
    {
        if (config('luna-rbac.only-one-role') && 1 < count($data['roles'])) {
            abort(400, config('luna-rbac.only-one-role-msg'));
        }

        $this->user = $this->find($id);
        $this->user->fill($data);
        $this->user->update();
        $this->syncRoles($data);  
    }

    /**
     * Sync user roles.
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

        $role_ids = collect($data['roles'])->filter(function ($item) {
            
            if (!is_null($item)) {
                return $item;
            }
        })->toArray();
        $this->user->roles()->sync($role_ids);
    }

    /**
     * Delete a user.
     *
     * @param integer $id
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->user = $this->find($id);
        $this->user->delete();
    }
}