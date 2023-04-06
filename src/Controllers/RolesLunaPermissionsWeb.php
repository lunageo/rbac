<?php

namespace Luna\RBAC\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Luna\RBAC\Services\LunaPermissionsCrudService as Service;


class RolesLunaPermissionsWeb extends Controller
{
    /**
     * Launch the roles index page.
     *
     * @return View
     */
    public function index(Request $request, Service $service): View
    {
        return view('luna-rbac::roles.index', [
            'roles' => $service->allRoles()
        ]);
    }

    /**
     * Launch create role view.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     *
     * @return View
     */
    public function create(Request $request, Service $service): View
    {
        return view('luna-rbac::roles.create', [
            'role' => $service->getRole()
        ]);
    }

    /**
     * Store a new role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Service $service): RedirectResponse
    {
        $service->store($request->all());

        return redirect()->route(config('luna-rbac.routes-as') . "roles.index");
    }

    /**
     * Show a role data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function show(Request $request,  Service $service, $id): View
    {
        return view('luna-rbac::roles.show', [
            'role' => $service->find($id)
        ]);
    }

    /**
     * Edit a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function edit(Request $request, Service $service, $id): View
    {
        return view('luna-rbac::roles.edit', [
            'role' => $service->find($id)
        ]);
    }

    /**
     * Update a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Service $service, $id): RedirectResponse
    {
        $service->update($id, $request->all());

        return redirect()->route(config('luna-rbac.routes-as') . "roles.index");
    }

    /**
     * Delete a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Service $service, $id): RedirectResponse
    {
        $service->destroy($id);

        return redirect()->route(config('luna-rbac.routes-as') . "roles.index");
    }
}
