<?php

use Illuminate\Support\Facades\Route;

Route::get('/routes', [
    'as' => 'routes.index',
    'uses' => 'RoutesLunaPermissionsWeb@indexRoutes',
]);

Route::get('/routes/{route}', [
    'as' => 'routes.show',
    'uses' => 'RoutesLunaPermissionsWeb@showRoute',
]);

Route::put('/routes/{route}', [
    'as' => 'routes.update',
    'uses' => 'RoutesLunaPermissionsWeb@updateRoles',
]);

Route::resources([
    'roles' => RolesLunaPermissionsWeb::class,
]);
