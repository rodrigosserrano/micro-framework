<?php

use App\Core\Router\Router;

Router::get('/users/[0-9]+', 'UserController@find', ['auth']);
Router::get('/users', 'UserController@findAll', ['auth']);

Router::post('/users', 'UserController@register');
Router::post('/login', 'AuthController@login');
Router::post('/users/[0-9]+/drink', 'UserController@drink', ['auth']);

Router::put('/users/[0-9]+', 'UserController@update', ['auth']);

Router::delete('/users/[0-9]+', 'UserController@delete', ['auth']);

//UtilsHelpers::dd(Router::$routes);