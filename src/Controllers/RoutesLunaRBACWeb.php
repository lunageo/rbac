<?php

namespace Luna\RBAC\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Luna\RBAC\Services\RoutesService as Service;

class RoutesLunaRBACWeb extends Controller
{
    /**
     * Launch the routes index page.
     *
     * @return View
     */
    public function indexRoutes(Request $request, Service $service): View
    {
        return view('luna-rbac::routes.index', [
            'routes' => $service->allRoutes()
        ]);
    }

    /**
     * Show a route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\RoutesService $service
     * @param int $id
     *
     * @return View
     */
    public function showRoute(Request $request, Service $service, $id): View
    {
        return view('luna-rbac::routes.show', [
            'route' => $service->findRoute($id)
        ]);
    }

    /**
     * Update the roles assigned to a route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\RoutesService $service
     * @param int $id
     *
     * @return View
     */
    public function updateRoles(Request $request, Service $service, $id): View
    {        
        return view('luna-rbac::routes.show', [
            'route' => $service->assignRolesToRoute($id, $request->get('roles'))
        ]);
    }
}
