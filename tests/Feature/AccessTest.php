<?php

namespace Luna\RBAC\Tests\Feature;

use DB;
use Luna\RBAC\Models\Role;
use Luna\RBAC\Models\Route;
use Luna\RBAC\Tests\BaseTest;
use Luna\RBAC\Tests\Misc\User;
use Illuminate\Support\Facades\Auth;
use Luna\RBAC\Services\LunaPermissionsService;

class AccessTest extends BaseTest
{
    /**
     * Test can access.
     * 
     * @covers feature
     * @covers access
     *
     * @return void
     */
    public function testCanAccess(): void
    {
        // Given I create a role
        Role::create([
            'key' => 'test-role',
            'name' => 'Test Role',
        ]);

        // And I create a user
        User::create([
            'name' => 'Test User',
            'email' => 'test.user@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'wqaaskajsuyehhgs',
        ]);

        // And I relate the role and user
        DB::table('roles_users')->insert([
            'role_id' => Role::where('key', 'test-role')->first()->id,
            'user_id' => User::where('email', 'test.user@email.com')->first()->id,
        ]);

        // And I create a route protected by the luna-access middleware
        $this->route_collection->add($this->router->get('/dummy/route/protected', [
            'namespace' => 'Luna\RBAC\Tests\Misc',
            'as' => 'dummy.route.protected',
            'uses' => 'DummyController@dummyIndex',
            'middleware' => ['luna-access'],
        ]));
        $this->router->setRoutes($this->route_collection);

        // When I execute the updateAppRoutes() function
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();

        // And I relate the role and route
        DB::table('roles_routes')->insert([
            'role_id' => Role::where('key', 'test-role')->first()->id,
            'route_id' => Route::where('name', 'dummy.route.protected')->first()->id,
        ]);

        // And I authenticate the user
        $user = User::where('email', 'test.user@email.com')->first();
        Auth::loginUsingId($user->id);
        
        // Then I should see that the user can access the route protected by the luna-access middleware 
        $expected = true;
        $actual = $service->canAccess($user, 'dummy/route/protected');

        $this->assertEquals($expected,  $actual);
    }

    /**
     * Test can not access
     * 
     * @covers feature
     * @covers access
     *
     * @return void
     */
    public function testCanNotAccess(): void
    {
        // Given I create a role
        $role = Role::create([
            'key' => 'test-role',
            'name' => 'Test Role',
        ]);

        // And I create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test.user@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'wqaaskajsuyehhgs',
        ]);        
        
        // And I relate the role and user
        DB::table('roles_users')->insert([
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);
        
        // And I create a route protected by the luna-access middleware
        $this->route_collection->add($this->router->get('/dummy/route/protected', [
            'namespace' => 'Luna\RBAC\Tests\Misc',
            'as' => 'dummy.route.protected',
            'uses' => 'DummyController@dummyIndex',
            'middleware' => ['luna-access'],
        ]));
        $this->router->setRoutes($this->route_collection);
        
        // When I authenticate the user
        $user = User::where('email', 'test.user@email.com')->first();
        Auth::loginUsingId($user->id);

        // And I execute the updateAppRoutes() function
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();
                
        // Then I should see that the user can't access the route protected by the luna-access middleware 
        $expected = false;
        $actual = $service->canAccess($user, 'dummy/route/another');

        $this->assertEquals($expected,  $actual);
    }
}