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
     * Define the package routes based name.
     * 
     * For example: 
     *      - route('luna.rbac.roles')
     *      - route('luna.rbac.roles.show')
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

    /**
     * Allow access to any of the management routes in the  package: 
     *      - routes
     *      - roles
     *      - users
     */
    'allow-cruds' => true,

    /**
     * Allow access to any of the roles CRUD routes.
     */
    'allow-roles-crud' => true,

    /**
     * Allow access to any of the routes CRUD routes.
     */
    'allow-routes-crud' => true,

    /**
     * Allow access to any of the users CRUD routes.
     */
    'allow-users-crud' => true,

    /**
     * Default error message to be displayed when any of the CRUD routes are not accesible due to package configuration
     */
    'allow-cruds-msg' => 'Ups! Something went wrong. The URL you are trying to get does not exist or has restricted access.',
];