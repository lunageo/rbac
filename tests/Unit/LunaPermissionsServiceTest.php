<?php

namespace Luna\Permissions\Tests\Unit;

use DB;
use Luna\Permissions\Models\Role;
use Luna\Permissions\Models\Route;
use Luna\Permissions\Tests\BaseTest;
use Illuminate\Support\Facades\Auth;
use Luna\Permissions\Tests\Misc\User;
use Luna\Permissions\Services\LunaPermissionsService;

class LunaPermissionsServiceTest extends BaseTest
{
    /**
     * Test can access.
     *
     * @return void
     */
    public function testCanAccess(): void
    {
        // create role
        Role::create([
            'key' => 'test-role',
            'name' => 'Test Role',
        ]);
        // create user
        User::create([
            'name' => 'Test User',
            'email' => 'test.user@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'wqaaskajsuyehhgs',
        ]);        
        // create role user relation
        DB::table('roles_users')->insert([
            'role_id' => Role::where('key', 'test-role')->first()->id,
            'user_id' => User::where('email', 'test.user@email.com')->first()->id,
        ]);
        // create the routes
        $this->route_collection->add($this->router->get('/dummy/route/protected', [
            'namespace' => 'Luna\Permissions\Tests\Misc',
            'as' => 'dummy.route.protected',
            'uses' => 'DummyController@dummyIndex',
            'middleware' => ['luna-access'],
        ]));
        $this->router->setRoutes($this->route_collection);        
        // set routes
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();

        // create roles routes relation
        DB::table('roles_routes')->insert([
            'role_id' => Role::where('key', 'test-role')->first()->id,
            'route_id' => Route::where('name', 'dummy.route.protected')->first()->id,
        ]);
        // authenticate  user
        $user = User::where('email', 'test.user@email.com')->first();
        Auth::loginUsingId($user->id);
                
        $expected = true;
        $actual = $service->canAccess($user, 'dummy/route/protected');

        $this->assertEquals($expected,  $actual);
    }

    /**
     * Test can not access
     *
     * @return void
     */
    public function testCanNotAccess(): void
    {
        // create role
        $role = Role::create([
            'key' => 'test-role',
            'name' => 'Test Role',
        ]);
        // create user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test.user@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'wqaaskajsuyehhgs',
        ]);        
        // create role user relation
        DB::table('roles_users')->insert([
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);
        // create the routes
        $this->route_collection->add($this->router->get('/dummy/route/protected', [
            'namespace' => 'Luna\Permissions\Tests\Misc',
            'as' => 'dummy.route.protected',
            'uses' => 'DummyController@dummyIndex',
            'middleware' => ['luna-access'],
        ]));
        $this->router->setRoutes($this->route_collection);
        // authenticate  user
        $this->actingAs($user);

        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();
                
        $expected = false;
        $actual = $service->canAccess($user, 'dummy/route/another');

        $this->assertEquals($expected,  $actual);
    }

    /**
     * Test remove all app routes.
     *
     * @return void
     */
    public function testStoreAllAppRoutes(): void
    {
        LunaPermissionsService::newInstance()
            ->setAppRoutes()
            ->storeAllAppRoutes();

        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route.another',
                'uses' => 'DummyController@dummyIndex',
            ]
        ];
        $actual = Route::get();

        $this->assertEquals(2, $actual->count());
        $this->assertEquals($expected['first']['as'], $actual->first()->name);
        $this->assertEquals($expected['second']['as'], $actual->last()->name);
    }

    /**
     * Test remove all saved routes.
     *
     * @return void
     */
    public function testRemoveAllSavedRoutes(): void
    {
        // insert some routes that are are going to be removed.
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);

        LunaPermissionsService::newInstance()->removeAllSavedRoutes();

        $expected = 0;
        $actual = Route::count();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test add route.
     *
     * @return void
     */
    public function testAddRoute(): void
    {
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();

        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route.another',
                'uses' => 'DummyController@dummyIndex',
            ]
        ];
        $actual = Route::get();

        $this->assertEquals($expected['first']['as'], $actual->first()->name);
        $this->assertEquals($expected['second']['as'], $actual->last()->name);
    }

    /**
     * Test the to add.
     * The routes exist in the route files but they don't in the database.
     *
     * @return void
     */
    public function testRoutesToAdd()
    {
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();

        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\Permissions\Tests\Misc',
                'as' => 'dummy.route.another',
                'uses' => 'DummyController@dummyIndex',
            ]
        ];        
        $actual = $service->getRoutesToAdd();

        $this->assertEquals($expected['first']['as'], $actual->first()->name);
        $this->assertEquals($expected['second']['as'], $actual->last()->name);
    }

    /**
     * Test deleting routes from the database.
     *
     * @return void
     */
    public function testRemoveRoute(): void
    {
        // insert some routes that are are going to be removed.
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);

        // check they were inserted
        $this->assertEquals(2, Route::count());
        $this->assertEqualsCanonicalizing($data['first']['name'], Route::get()->toArray()[0]['name']);
        $this->assertEqualsCanonicalizing($data['second']['name'], Route::get()->toArray()[1]['name']);

        $service = LunaPermissionsService::newInstance();
        $service->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove();

        $service->removeRoutes($service->getRoutesToRemove());

        $expected = 0;
        $actual = Route::count();
        
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test routes to remove.
     * The routes that exist in the database but they are not defined in the route files.
     *
     * @return void
     */
    public function testRoutesToRemove(): void
    {
        // insert some routes that are not defined in the list of tests routes.
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);
        // check they were inserted
        $this->assertEquals(2, Route::count());
        $this->assertEqualsCanonicalizing($data['first']['name'], Route::get()->toArray()[0]['name']);
        $this->assertEqualsCanonicalizing($data['second']['name'], Route::get()->toArray()[1]['name']);

        $expected = Route::get();

        $service = LunaPermissionsService::newInstance();
        $service->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove();

        $actual = $service->getRoutesToRemove();

        $this->assertEquals($expected->count(), $actual->count());
        $this->assertEquals($expected->first()->name, $actual->first()->name);
    }

    /**
     * Test saved routes.
     * The routes saved in the routes table.
     *
     * @return void
     */
    public function testSavedRoutes(): void
    {
        // insert a route
        $data = [
            'method' => 'GET, HEAD',
            'uri' => 'dummy/route',
            'name' => 'dummy.route',
            'action' => 'DummyController@dummyIndex',
            'namespace' => 'Luna\Permissions\Tests\Misc',
        ];
        Route::create($data);
        // check it was inserted
        $this->assertEquals(1, Route::count());
        $this->assertEqualsCanonicalizing($data['method'], Route::first()->method);
        $this->assertEqualsCanonicalizing($data['uri'], Route::first()->uri);
        $this->assertEqualsCanonicalizing($data['name'], Route::first()->name);
        $this->assertEqualsCanonicalizing($data['action'], Route::first()->action);
        $this->assertEquals($data['namespace'], Route::first()->namespace);
        
        $service = new LunaPermissionsService;
        $service->setSavedRoutes();
        $expected = Route::count();
        $actual = $service->getSavedRoutes()->count();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test setting app routes collection.
     * 
     * Test no null namespace route is added.
     * Test no empty namespace route is added.
     * Test no excluded namespace route is added.
     *
     * @return void
     */
    public function testSetAppRoutes(): void
    {
        $expected = [
            0 => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'name' => 'dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ],
            1=> [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'name' => 'dummy.route.another',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\Permissions\Tests\Misc',
            ]
        ];
        $service = new LunaPermissionsService;
        $service->setAppRoutes();
        $actual = $service->getAppRoutes()->toArray();

        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    /**
     * Test new instance of  LunaPermissionsService.
     *
     * @return void
     */
    public function testNewInstance(): void
    {
        $expected = LunaPermissionsService::class;
        $actual = LunaPermissionsService::newInstance();

        $this->assertInstanceOf($expected, $actual);
    }
}