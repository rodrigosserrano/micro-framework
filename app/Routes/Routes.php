<?php

use App\Core\Router\Router;

/**
 * Exemple route
 * $router = new Router();    <- Instance
 * $router->get("Path", "Controller@Method", "Middleware Alias (Optional)");     <- Creating route
 */
$router = new Router();

/** ROUTES GET */
$router->get('/users/[0-9]+', 'UserController@find', ['auth']);
$router->get('/users', 'UserController@findAll', ['auth']);

/** ROUTES POST */
$router->post('/users', 'UserController@register');
$router->post('/login', 'AuthController@login');
$router->post('/users/[0-9]+/drink', 'UserController@drink', ['auth']);

/** ROUTES PUT */
$router->put('/users/[0-9]+', 'UserController@update', ['auth']);

/** ROUTES DELETE */
$router->delete('/users/[0-9]+', 'UserController@delete', ['auth']);