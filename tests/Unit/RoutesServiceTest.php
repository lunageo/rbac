<?php

namespace Luna\RBAC\Tests\Unit;

use Luna\RBAC\Models\Route;
use Luna\RBAC\Tests\BaseTest;
use Luna\RBAC\Services\LunaPermissionsService;

class RoutesServiceTest extends BaseTest
{
    /**
     * Test remove all app routes.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testStoreAllAppRoutes(): void
    {
        // Given I set the app routes
        $service = LunaPermissionsService::newInstance()->setAppRoutes();

        // When I store all the app routes
        $service->storeAllAppRoutes();

        // Then I should have 2 routes in the db.
        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\RBAC\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\RBAC\Tests\Misc',
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
     * @covers unit
     *
     * @return void
     */
    public function testRemoveAllSavedRoutes(): void
    {
        // Given I insert some routes in the db
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);

        // When I remove all the routes
        LunaPermissionsService::newInstance()->removeAllSavedRoutes();

        // Then I should not have routes in the db
        $expected = 0;
        $actual = Route::count();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test add route.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testAddRoute(): void
    {
        // Given I have new routes defined in a route file
        $service = LunaPermissionsService::newInstance();

        // When I add the routes
        $service->updateAppRoutes();

        // Then I should have routes in the db
        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\RBAC\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\RBAC\Tests\Misc',
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
     * Test the to add.
     * The routes exist in the route files but they don't in the database.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testRoutesToAdd()
    {
        // Given I have new routes defined in a route file
        $service = LunaPermissionsService::newInstance();

        // When I add the routes
        $service->init()
            ->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove()
            ->checkRoutesToAdd();

        // Then I should see those routes in the routes to add collection
        $expected = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'namespace' => 'Luna\RBAC\Tests\Misc',
                'as' => 'dummy.route',
                'uses' => 'DummyController@dummyIndex',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'namespace' => 'Luna\RBAC\Tests\Misc',
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
     * @covers unit
     *
     * @return void
     */
    public function testRemoveRoute(): void
    {
        // Given I have routes in the db that are not defined in a route file
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);

        // When I set the app routes
        // And I set the saved routes
        // And I check the routes to remove
        $service = LunaPermissionsService::newInstance();
        $service->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove();

        // And I remove the routes
        $service->removeRoutes($service->getRoutesToRemove());

        // Then I  should not see routes in the db
        $expected = 0;
        $actual = Route::count();
        
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test routes to remove.
     * The routes that exist in the database but they are not defined in the route files.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testRoutesToRemove(): void
    {
        // Given I have routes in the db that are not defined in a route file
        $data = [
            'first' => [
                'method' => 'GET, HEAD',
                'uri' => 'first/dummy/route',
                'name' => 'first.dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
            'second' => [
                'method' => 'GET, HEAD',
                'uri' => 'second/dummy/route',
                'name' => 'second/dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
        ];
        Route::create($data['first']);
        Route::create($data['second']);

        $expected = Route::get();

        // When I set the app routes
        // And I set the saved routes
        // And I check the routes to remove
        $service = LunaPermissionsService::newInstance();
        $service->setAppRoutes()
            ->setSavedRoutes()
            ->checkRoutesToRemove();

        // Then I should see the amount of routes that are in the db but not defined in the route file
        $actual = $service->getRoutesToRemove();

        $this->assertEquals($expected->count(), $actual->count());
        $this->assertEquals($expected->first()->name, $actual->first()->name);
    }

    /**
     * Test saved routes.
     * The routes saved in the routes table.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testSetSavedRoutes(): void
    {
        // Given I have routes in the db
        $data = [
            'method' => 'GET, HEAD',
            'uri' => 'dummy/route',
            'name' => 'dummy.route',
            'action' => 'DummyController@dummyIndex',
            'namespace' => 'Luna\RBAC\Tests\Misc',
        ];
        Route::create($data);
        
        // When I set the saved routes
        $service = new LunaPermissionsService;
        $service->setSavedRoutes();

        // Then I should see the same amount of routes from the db in the saved routes collection
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
     * @covers unit
     *
     * @return void
     */
    public function testSetAppRoutes(): void
    {
        // Given I have routes defined in a route file
        $expected = [
            0 => [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route',
                'name' => 'dummy.route',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ],
            1=> [
                'method' => 'GET, HEAD',
                'uri' => 'dummy/route/another',
                'name' => 'dummy.route.another',
                'action' => 'DummyController@dummyIndex',
                'namespace' => 'Luna\RBAC\Tests\Misc',
            ]
        ];

        // When I set the app routes
        $service = new LunaPermissionsService;
        $service->setAppRoutes();

        // Then I should see the routes defined in a route file in the app routes collection
        $actual = $service->getAppRoutes()->toArray();

        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    /**
     * Test initializing the service class.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testInit(): void
    {
        // Given I have a new instance of the service
        $service = LunaPermissionsService::newInstance();

        // And I have app routes collection
        $service->setAppRoutes();

        // And I have saved routes collection
        $service->setSavedRoutes();

        // And I have routes to add collection
        $service->checkRoutesToAdd();

        // And I have routes to remove collection
        $service->checkRoutesToRemove();

        // When I initialize the service
        $service->init();

        // Then I should have all collections empty
        $this->assertEquals(0, $service->getAppRoutes()->count());
        $this->assertEquals(0, $service->getSavedRoutes()->count());
        $this->assertEquals(0, $service->getRoutesToAdd()->count());
        $this->assertEquals(0, $service->getRoutesToRemove()->count());
    }

    /**
     * Test new instance of LunaPermissionsService.
     * 
     * @covers unit
     *
     * @return void
     */
    public function testNewInstance(): void
    {
        // Given I have a LunaPermissionsService class
        $expected = LunaPermissionsService::class;

        // When I call the newInstance method
        $actual = LunaPermissionsService::newInstance();

        // Then I should have a new LunaPermissionsService instance
        $this->assertInstanceOf($expected, $actual);
    }
}