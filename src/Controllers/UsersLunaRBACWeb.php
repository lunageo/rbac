<?php

namespace Luna\RBAC\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Luna\RBAC\Services\UsersService as Service;

class UsersLunaRBACWeb extends Controller
{
    /**
     * Launch the users index page.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request, Service $service): View
    {
        return view('luna-rbac::users.index', [
            'users' => $service->allUsers()
        ]);
    }

    /**
     * Launch create user view.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     *
     * @return View
     */
    public function create(Request $request, Service $service): View
    {
        return view('luna-rbac::users.create', [
            'user' => $service->getUser()
        ]);
    }

    /**
     * Store a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Service $service): RedirectResponse
    {
        $request->validate(config('luna-rbac.user-validation'));

        $service->store($request->all());

        return redirect()->route(config('luna-rbac.routes-as') . "users.index");
    }

    /**
     * Show a user data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     * @param int $id
     *
     * @return View
     */
    public function show(Request $request,  Service $service, $id): View
    {
        return view('luna-rbac::users.show', [
            'user' => $service->find($id)
        ]);
    }

    /**
     * Edit a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     * @param int $id
     *
     * @return View
     */
    public function edit(Request $request, Service $service, $id): View
    {
        return view('luna-rbac::users.edit', [
            'user' => $service->find($id)
        ]);
    }

    /**
     * Update a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Service $service, $id): RedirectResponse
    {
        $service->update($id, $request->all());

        return redirect()->route(config('luna-rbac.routes-as') . "users.index");
    }

    /**
     * Delete a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Luna\RBAC\Services\UsersService $service
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Service $service, $id): RedirectResponse
    {
        $service->destroy($id);

        return redirect()->route(config('luna-rbac.routes-as') . "users.index");
    }
}
