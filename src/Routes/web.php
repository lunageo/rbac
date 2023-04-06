<?php

use Illuminate\Support\Facades\Route;

Route::get('/routes', [
    'as' => 'routes.index',
    'uses' => 'RoutesLunaRBACWeb@indexRoutes',
]);

Route::get('/routes/{route}', [
    'as' => 'routes.show',
    'uses' => 'RoutesLunaRBACWeb@showRoute',
]);

Route::put('/routes/{route}', [
    'as' => 'routes.update',
    'uses' => 'RoutesLunaRBACWeb@updateRoles',
]);

Route::resources([
    'roles' => RolesLunaRBACWeb::class,
]);

Route::resources([
    'users' => UsersLunaRBACWeb::class,
]);
