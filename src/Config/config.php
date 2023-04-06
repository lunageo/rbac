<?php

return [

    /**
     * List of namespaces that need to be excluded.
     * Any routes within these namespaces wont be added in the db.
     * 
     * For example: 
     *      - Luna\RBAC\Controllers
     *      - App\Http\Controllers\Api
     */
    'excluded-namespaces' => [],
    
    /**
     * Publish views under views/vendor/luna-permissions
     */
    'views-folder' => 'luna-rbac',

    /**
     * Define the routes "prefix" used in the package routes.
     * 
     * For example: 
     *      - http://localhost:8000/luna/permisssions
     */
    'routes-prefix' => '/luna/rbac',

    /**
     * Define the routes "as" used in the package routes.
     * 
     * For example: 
     *      - route('luna.rbac.roles')
     */
    'routes-as' => 'luna.rbac.',

    /**
     * The user attributes to display when fetching the user list to assing users to roles.
     */
    'user-attributes' => [
        'id',
        'name',
    ],

    /**
     * Restrict how many roles can be assigned to a user.
     * 
     * For example: 
     *      - 'only-one-role' => false | A User can have many roles and a Role can have many users.
     *      - 'only-one-role' => true  | A User can only have  one role and a Role can have many users. 
     */
    'only-one-role' => false,

    /**
     * Default error message displayed when "only-one-role" is true and try to assigne 2 or more roles to a user.
     */
    'only-one-role-msg' => 'Ups! Something went wrong. User can only be assigned to one role.',

    /**
     * Publish the package migrations or no.
     */
    'use-migrations' => true,

    /**
     * Publish the package routes or no.
     */
    'publish-routes' => true,

    /**
     * Publish the package view or no.
     */
    'publish-views' => true,
];