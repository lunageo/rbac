<?php

namespace Luna\Permissions\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Luna\Permissions\Services\LunaPermissionsCrudService as Service;


class RolesLunaPermissionsWeb extends Controller
{
    /**
     * Launch the roles index page.
     *
     * @return View
     */
    public function index(Request $request, Service $service): View
    {
        return view('luna-permissions::roles.index', [
            'roles' => $service->allRoles()
        ]);
    }

    /**
     * Launch create role view.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     *
     * @return View
     */
    public function create(Request $request, Service $service): View
    {
        return view('luna-permissions::roles.create', [
            'role' => $service->getRole()
        ]);
    }

    /**
     * Store a new role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Service $service): RedirectResponse
    {
        $service->store($request->all());

        return redirect()->route(config('luna-permissions.routes-as') . "roles.index");
    }

    /**
     * Show a role data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function show(Request $request,  Service $service, $id): View
    {
        return view('luna-permissions::roles.show', [
            'role' => $service->find($id)
        ]);
    }

    /**
     * Edit a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return View
     */
    public function edit(Request $request, Service $service, $id): View
    {
        return view('luna-permissions::roles.edit', [
            'role' => $service->find($id)
        ]);
    }

    /**
     * Update a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Service $service, $id): RedirectResponse
    {
        $service->update($id, $request->all());

        return redirect()->route(config('luna-permissions.routes-as') . "roles.index");
    }

    /**
     * Delete a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\Permissions\Services\LunaPermissionsCrudService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Service $service, $id): RedirectResponse
    {
        $service->destroy($id);

        return redirect()->route(config('luna-permissions.routes-as') . "roles.index");
    }
}