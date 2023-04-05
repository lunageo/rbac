<?php

return [

    /**
     * List of namespaces that need to be excluded.
     * Any routes within these namespaces wont be added in the db.
     * 
     * For example: 
     *      - Luna\Permissions\Controllers
     *      - App\Http\Controllers\Api
     */
    'excluded-namespaces' => [],
    
    /**
     * Publish views under views/vendor/luna-permissions
     */
    'views-folder' => 'luna-permissions',

    /**
     * Define the routes "prefix" used in the package routes.
     * 
     * http://localhost:8000/luna/permisssions
     */
    'routes-prefix' => '/luna/permissions',

    /**
     * Define the routes "as" used in the package routes.
     */
    'routes-as' => 'luna.permissions.',

    /**
     * The user attributes to display when fetching the user list to assing users to roles.
     */
    'user-attributes' => [
        'id',
        'name',
    ],

    /**
     * Use the package migrations or no.
     */
    'use-migrations' => true,
];