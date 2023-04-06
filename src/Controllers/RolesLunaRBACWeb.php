<?php

namespace Luna\RBAC\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Luna\RBAC\Services\RolesService as Service;

class RolesLunaRBACWeb extends Controller
{
    /**
     * Launch the roles index page.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\RolesService $service
     *
     * @return \Illuminate\Contracts\View\View
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
     * @param \Luna\RBAC\Services\RolesService $service
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
     * @param \Luna\RBAC\Services\RolesService $service
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
     * @param \Luna\RBAC\Services\RolesService $service
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
     * @param \Luna\RBAC\Services\RolesService $service
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
     * @param \Luna\RBAC\Services\RolesService $service
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
     * @param \Luna\RBAC\Services\RolesService $service
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
