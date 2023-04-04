<?php

namespace Luna\Permissions\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Luna\Permissions\Services\LunaPermissionsCrudService as Service;

class RoutesLunaPermissionsWeb extends Controller
{
    /**
     * Launch the routes index page.
     *
     * @return View
     */
    public function indexRoutes(Request $request, Service $service): View
    {
        return view('luna-permissions::routes.index', [
            'routes' => $service->allRoutes()
        ]);
    }

    /**
     * Show a route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function showRoute(Request $request, Service $service, $id): View
    {
        return view('luna-permissions::routes.show', [
            'route' => $service->findRoute($id)
        ]);
    }

    /**
     * Update the roles assigned to a route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function updateRoles(Request $request, Service $service, $id): View
    {        
        return view('luna-permissions::routes.show', [
            'route' => $service->assignRolesToRoute($id, $request->get('roles'))
        ]);
    }
}