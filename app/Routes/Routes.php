<?php

use App\Core\Router\Router;

/**
 * Exemple route
 * Router::get("Path", "Controller@Method", "Middleware Alias (Optional)");
 */

/** ROUTES GET */
Router::get('/users/[0-9]+', 'UserController@find', ['auth']);
Router::get('/users', 'UserController@findAll', ['auth']);

/** ROUTES POST */
Router::post('/users', 'UserController@register');
Router::post('/login', 'AuthController@login');
Router::post('/users/[0-9]+/drink', 'UserController@drink', ['auth']);

/** ROUTES PUT */
Router::put('/users/[0-9]+', 'UserController@update', ['auth']);

/** ROUTES DELETE */
Router::delete('/users/[0-9]+', 'UserController@delete', ['auth']);
