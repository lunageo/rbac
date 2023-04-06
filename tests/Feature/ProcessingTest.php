<?php

namespace Luna\RBAC\Tests\Feature;

use DB;
use Luna\RBAC\Models\Role;
use Luna\RBAC\Models\Route;
use Luna\RBAC\Tests\BaseTest;
use Luna\RBAC\Services\LunaPermissionsService;

class ProcessingTest extends BaseTest
{
    /**
     * Test the package will only update new routes.
     * 
     * If there are new routes created in the route files that need to be added to the db, 
     * the routes are already assigned to a role in the db, 
     * and the updateAppRoutes() function is triggered,
     * then the we should ONLY include the new routes from the route files and NEVER do any operation to the existing routes in the db. 
     * 
     * @covers feature
     * @covers processing
     *
     * @return void
     */
    public function testUpdateOnlyNewRoutes(): void
    {
        // Given I have routes in the db after runing the updateAppRoutes() function
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes(); 

        // And I have a roles
        Role::create([
            'key' => 'test-role',
            'name' => 'Test Role',
        ]);

        // And I have the role and the route related
        DB::table('roles_routes')->insert([
            'role_id' => Role::where('key', 'test-role')->first()->id,
            'route_id' => Route::first()->id,
        ]);

        $this->route_collection->add($this->router->get('/dummy/route/new', [
            'namespace' => 'Luna\RBAC\Tests\Misc',
            'as' => 'dummy.route.new',
            'uses' => 'DummyController@dummyIndex',
        ]));
        //$this->router->newRoute(['GET', 'HEAD'], '/dummy/route/new', 'DummyController@dummyIndex');

        // And I run updateAppRoutes() function
        $service = LunaPermissionsService::newInstance();
        $service->updateAppRoutes();
        
        // Then I should see the new route from the route file added to the db
        $route = Route::where('name', 'dummy.route.new')->first();
        $this->assertNotNull($route);

        // And I should have the relation between role and the old route
        $roles_routes = DB::table('roles_routes')->get();
        $this->assertEquals(1, $roles_routes->count());
        $this->assertEquals(Role::where('key', 'test-role')->first()->id, $roles_routes->first()->role_id);
        $this->assertEquals(Route::first()->id, $roles_routes->first()->route_id);
    }
}