<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['allow-cruds'],
], function () {

    Route::group([
        'middleware' => 'allow-routes-crud',
    ], function () {

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
    });    
    
    Route::group([
        'middleware' => 'allow-roles-crud',
    ], function () {

        Route::resources([
            'roles' => RolesLunaRBACWeb::class,
        ]);
    }); 
    
    Route::group([
        'middleware' => 'allow-users-crud',
    ], function () {

        Route::resources([
            'users' => UsersLunaRBACWeb::class,
        ]);
    });        
});

